CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha TEXT NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    nivel_acesso VARCHAR(10) DEFAULT 'cliente' CHECK (nivel_acesso IN ('admin', 'cliente')),
    criado_em TIMESTAMP DEFAULT NOW()
);

CREATE TABLE pacotes (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT,
    tipo_transporte VARCHAR(20) NOT NULL CHECK (tipo_transporte IN ('Avião', 'Ônibus', 'Cruzeiro')),
    preco DECIMAL(10,2) NOT NULL CHECK (preco > 0),
    vagas_totais INT NOT NULL CHECK (vagas_totais >= 0),
    vagas_disponiveis INT NOT NULL CHECK (vagas_disponiveis >= 0),
    data_ida DATE NOT NULL,
    data_volta DATE NOT NULL,
    imagem_url TEXT,
    CONSTRAINT check_datas CHECK (data_volta >= data_ida)
);

CREATE TABLE reservas (
    id SERIAL PRIMARY KEY,
    usuario_id INT REFERENCES usuarios(id) ON DELETE CASCADE,
    pacote_id INT REFERENCES pacotes(id) ON DELETE RESTRICT,
    codigo_localizador VARCHAR(10) UNIQUE DEFAULT upper(substring(md5(random()::text), 1, 6)),
    data_reserva TIMESTAMP DEFAULT NOW(),
    status_pagamento VARCHAR(20) DEFAULT 'Confirmado'
);

-- Funções e Triggers de Vagas
CREATE OR REPLACE FUNCTION gerenciar_vaga_insert()
RETURNS TRIGGER AS $$
BEGIN
    IF (SELECT vagas_disponiveis FROM pacotes WHERE id = NEW.pacote_id) <= 0 THEN
        RAISE EXCEPTION 'Sem vagas disponíveis.';
    END IF;
    UPDATE pacotes SET vagas_disponiveis = vagas_disponiveis - 1 WHERE id = NEW.pacote_id;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_reserva_feita
BEFORE INSERT ON reservas
FOR EACH ROW EXECUTE FUNCTION gerenciar_vaga_insert();

CREATE OR REPLACE FUNCTION gerenciar_vaga_delete()
RETURNS TRIGGER AS $$
BEGIN
    UPDATE pacotes SET vagas_disponiveis = vagas_disponiveis + 1 WHERE id = OLD.pacote_id;
    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_reserva_cancelada
AFTER DELETE ON reservas
FOR EACH ROW EXECUTE FUNCTION gerenciar_vaga_delete();
