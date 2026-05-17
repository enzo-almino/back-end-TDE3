<?php

require_once __DIR__ . '/../config/conexao.php';

class UsuarioModel
{
    private PDO $pdo;

    public function __construct()
    {
        global $pdo;
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
}
