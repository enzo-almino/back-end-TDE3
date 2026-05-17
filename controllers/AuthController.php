<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class AuthController
{
    private UsuarioModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new UsuarioModel($pdo);
    }

    public function login(): void
    {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $usuario = $this->model->buscarPorEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['nivel_acesso'] = $usuario['nivel_acesso'];
                header('Location: index.php?route=pacotes');
                exit;
            }

            $erro = 'Email ou senha incorretos.';
        }

        require __DIR__ . '/../views/auth/login.php';
    }

    public function cadastro(): void
    {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $cpf   = $_POST['cpf'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $confirmar = $_POST['confirmar_senha'] ?? '';

            if (!preg_match('/^\d{11}$/', $cpf)) {
                $erro = 'O CPF deve conter exatamente 11 dígitos numéricos.';
            } elseif ($senha !== $confirmar) {
                $erro = 'As senhas não coincidem.';
            } elseif ($this->model->buscarPorEmail($email)) {
                $erro = 'Este email já está cadastrado.';
            } else {
                try {
                    $this->model->criar([
                        'nome'  => $nome,
                        'email' => $email,
                        'cpf'   => $cpf,
                        'senha' => $senha,
                    ]);
                    header('Location: index.php?route=auth&action=login');
                    exit;
                } catch (PDOException $e) {
                    if (str_contains($e->getMessage(), 'cpf')) {
                        $erro = 'Este CPF já está cadastrado.';
                    } else {
                        $erro = 'Erro ao cadastrar. Tente novamente.';
                    }
                }
            }
        }

        require __DIR__ . '/../views/auth/cadastro.php';
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: index.php?route=auth&action=login');
        exit;
    }
}
