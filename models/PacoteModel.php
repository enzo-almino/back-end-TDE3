<?php

require_once __DIR__ . '/../config/conexao.php';

class PacoteModel
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function listarTodos(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM pacotes ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pacotes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function criar(array $dados): bool
    {
        $sql = "INSERT INTO pacotes (titulo, descricao, tipo_transporte, preco, vagas_totais, vagas_disponiveis, data_ida, data_volta, imagem_url)
                VALUES (:titulo, :descricao, :tipo_transporte, :preco, :vagas_totais, :vagas_disponiveis, :data_ida, :data_volta, :imagem_url)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'titulo'            => $dados['titulo'],
            'descricao'         => $dados['descricao'],
            'tipo_transporte'   => $dados['tipo_transporte'],
            'preco'             => $dados['preco'],
            'vagas_totais'      => $dados['vagas_totais'],
            'vagas_disponiveis' => $dados['vagas_disponiveis'],
            'data_ida'          => $dados['data_ida'],
            'data_volta'        => $dados['data_volta'],
            'imagem_url'        => $dados['imagem_url'] ?? null,
        ]);
    }

    public function atualizar(int $id, array $dados): bool
    {
        $sql = "UPDATE pacotes SET
                    titulo = :titulo,
                    descricao = :descricao,
                    tipo_transporte = :tipo_transporte,
                    preco = :preco,
                    vagas_totais = :vagas_totais,
                    vagas_disponiveis = :vagas_disponiveis,
                    data_ida = :data_ida,
                    data_volta = :data_volta,
                    imagem_url = :imagem_url
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id'                => $id,
            'titulo'            => $dados['titulo'],
            'descricao'         => $dados['descricao'],
            'tipo_transporte'   => $dados['tipo_transporte'],
            'preco'             => $dados['preco'],
            'vagas_totais'      => $dados['vagas_totais'],
            'vagas_disponiveis' => $dados['vagas_disponiveis'],
            'data_ida'          => $dados['data_ida'],
            'data_volta'        => $dados['data_volta'],
            'imagem_url'        => $dados['imagem_url'] ?? null,
        ]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM pacotes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
