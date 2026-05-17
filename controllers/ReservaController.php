<?php

require_once __DIR__ . '/../models/ReservaModel.php';

class ReservaController
{
    private ReservaModel $model;

    public function __construct()
    {
        if (empty($_SESSION['usuario_id'])) {
            header('Location: index.php?route=auth&action=login');
            exit;
        }
        $this->model = new ReservaModel();
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
}
