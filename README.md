# Agência de Viagens

Sistema web de gerenciamento de viagens, desenvolvido em PHP com arquitetura MVC e banco de dados PostgreSQL (Supabase).

## Funcionalidades

- Cadastro e login de usuários com senha criptografada (bcrypt)
- Controle de acesso por nível (admin e cliente)
- CRUD completo de viagens (criar, listar, editar, excluir) — restrito a admins
- Sistema de reservas com código localizador gerado automaticamente
- Admin pode visualizar e excluir todas as reservas
- Admin pode promover clientes a admin
- Validação de preços mínimos por tipo de transporte
- Validação de vagas mínimas por tipo de transporte
- Controle de vagas disponíveis (decrementadas automaticamente via trigger)
- Suporte a viagens somente de ida ou ida e volta
- Proteção de rotas — só usuários logados acessam as viagens

## Regras de Negócio

Autenticação:

- Senha deve ter no mínimo 6 caracteres
- CPF deve conter exatamente 11 dígitos numéricos
- Email e CPF são únicos (não permite duplicados)
- Só usuários logados podem ver e gerenciar viagens

Níveis de acesso:

- **Admin**: Pode criar, editar e excluir viagens; visualizar e excluir reservas de todos; promover clientes a admin
- **Cliente** (padrão): pode visualizar viagens e fazer reservas

Preços mínimos por transporte:

| Transporte | Somente ida | Ida e volta |
|---|---|---|
| Avião | mín. R$ 150 | mín. R$ 350 |
| Ônibus | mín. R$ 120 | mín. R$ 210 |
| Cruzeiro | não permitido | mín. R$ 440 |

Vagas mínimas por transporte:

| Transporte | Vagas totais mínimas |
|---|---|
| Avião | 100 |
| Cruzeiro | 100 |
| Ônibus | 20 |

Datas:

- A data de volta deve ser pelo menos 1 hora após a data de ida
- Cruzeiro obrigatoriamente precisa de data de volta (não aceita somente ida)
- Avião e ônibus podem ser somente ida

Vagas:

- Vagas disponíveis não podem ser maiores que vagas totais
- Ao criar uma reserva, o trigger do banco decrementa vagas automaticamente
- Ao cancelar uma reserva, o trigger incrementa vagas de volta
- Não é possível reservar se não há vagas disponíveis

Reservas:

- Cada reserva gera um código localizador único de 6 caracteres
- O status padrão da reserva é "Confirmado"
- Admin pode excluir qualquer reserva

Exclusão:

- Não é possível excluir um pacote que tenha reservas vinculadas

## Estrutura do Projeto

```
├── config/conexao.php            # Conexão PDO com Supabase
├── database/AgenciaDeViagens.sql # Script de criação do banco
├── models/
│   ├── PacoteModel.php           # CRUD de viagens
│   ├── UsuarioModel.php          # Cadastro, busca e promoção de usuários
│   └── ReservaModel.php          # Criação, listagem e exclusão de reservas
├── controllers/
│   ├── PacoteController.php      # Lógica de viagens + validações (admin)
│   ├── AuthController.php        # Login, cadastro e logout
│   ├── ReservaController.php     # Reservar, listar e excluir reservas
│   └── AdminController.php       # Gerenciamento de usuários (admin)
├── views/
│   ├── pacotes/                  # Listar, criar, editar viagens
│   ├── reservas/                 # Minhas reservas + todas (admin)
│   ├── admin/                    # Gerenciar usuários
│   └── auth/                     # Login e cadastro
├── routes/web.php                # Roteador
└── index.php                     # Ponto de entrada
```

## Como Rodar

1. Tenha o PHP 8.0+ instalado com a extensão `pdo_pgsql` habilitada
2. Clone o repositório
3. Inicie o servidor embutido:

```bash
php -S localhost:8000
```

4. Acesse `http://localhost:8000`
5. Cadastre um usuário e promova-o a admin via SQL:

```sql
UPDATE usuarios SET nivel_acesso = 'admin' WHERE email = 'seu@email.com';
```

## Tecnologias

- PHP 8.0+
- PostgreSQL (Supabase)
