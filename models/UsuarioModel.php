<?php

class UsuarioModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarPorEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function criar(array $dados): bool
    {
        $sql = "INSERT INTO usuarios (nome, email, senha, cpf)
                VALUES (:nome, :email, :senha, :cpf)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'nome'  => $dados['nome'],
            'email' => $dados['email'],
            'senha' => password_hash($dados['senha'], PASSWORD_BCRYPT),
            'cpf'   => $dados['cpf'],
        ]);
    }

    public function promover(int $id): bool
    {
        $stmt = $this->pdo->prepare("UPDATE usuarios SET nivel_acesso = 'admin' WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function listarClientes(): array
    {
        $stmt = $this->pdo->query("SELECT id, nome, email FROM usuarios WHERE nivel_acesso = 'cliente' ORDER BY nome");
        return $stmt->fetchAll();
    }
}
