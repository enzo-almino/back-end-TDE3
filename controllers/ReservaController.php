<?php

require_once __DIR__ . '/../models/ReservaModel.php';

class ReservaController
{
    private ReservaModel $model;

    public function __construct(PDO $pdo)
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: index.php?route=auth&action=login');
            exit;
        }
        $this->model = new ReservaModel($pdo);
    }

    public function reservar(): void
    {
        $pacote_id = (int) ($_GET['id'] ?? 0);
        $usuario_id = (int) $_SESSION['usuario_id'];

        try {
            $this->model->criar($usuario_id, $pacote_id);
            header('Location: index.php?route=reservas&action=minhas&sucesso=1');
            exit;
        } catch (PDOException $e) {
            if (str_contains($e->getMessage(), 'Sem vagas')) {
                header('Location: index.php?route=pacotes&erro=' . urlencode('Sem vagas disponíveis para este pacote.'));
                exit;
            }
            header('Location: index.php?route=pacotes&erro=' . urlencode('Erro ao realizar reserva.'));
            exit;
        }
    }

    public function minhas(): void
    {
        $usuario_id = (int) $_SESSION['usuario_id'];
        $reservas = $this->model->listarPorUsuario($usuario_id);
        $sucesso = isset($_GET['sucesso']);
        require __DIR__ . '/../views/reservas/minhas.php';
    }

    public function todas(): void
    {
        if (($_SESSION['nivel_acesso'] ?? '') !== 'admin') {
            header('Location: index.php?route=reservas');
            exit;
        }
        $reservas = $this->model->listarTodas();
        require __DIR__ . '/../views/reservas/todas.php';
    }

    public function excluir(): void
    {
        if (($_SESSION['nivel_acesso'] ?? '') !== 'admin') {
            header('Location: index.php?route=reservas');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=reservas&action=todas');
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        $this->model->excluir($id);
        header('Location: index.php?route=reservas&action=todas');
        exit;
    }
}
