<?php

require_once __DIR__ . '/../models/UsuarioModel.php';

class AdminController
{
    private UsuarioModel $model;

    public function __construct(PDO $pdo)
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: index.php?route=auth&action=login');
            exit;
        }
        if (($_SESSION['nivel_acesso'] ?? '') !== 'admin') {
            header('Location: index.php?route=pacotes');
            exit;
        }
        $this->model = new UsuarioModel($pdo);
    }

    public function usuarios(): void
    {
        $clientes = $this->model->listarClientes();
        require __DIR__ . '/../views/admin/usuarios.php';
    }

    public function promover(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=admin');
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->promover($id);
        header('Location: index.php?route=admin');
        exit;
    }
}
