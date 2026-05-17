<?php

class ReservaModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar(int $usuario_id, int $pacote_id): bool
    {
        $sql = "INSERT INTO reservas (usuario_id, pacote_id) VALUES (:usuario_id, :pacote_id)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'usuario_id' => $usuario_id,
            'pacote_id'  => $pacote_id,
        ]);
    }

    public function listarPorUsuario(int $usuario_id): array
    {
        $sql = "SELECT r.id, r.codigo_localizador, r.data_reserva, r.status_pagamento,
                       p.titulo, p.tipo_transporte, p.data_ida, p.data_volta
                FROM reservas r
                JOIN pacotes p ON p.id = r.pacote_id
                WHERE r.usuario_id = :usuario_id
                ORDER BY r.data_reserva DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return $stmt->fetchAll();
    }

    public function listarTodas(): array
    {
        $sql = "SELECT r.id, r.codigo_localizador, r.data_reserva, r.status_pagamento,
                       p.titulo, p.tipo_transporte,
                       u.nome AS usuario_nome, u.email AS usuario_email
                FROM reservas r
                JOIN pacotes p ON p.id = r.pacote_id
                JOIN usuarios u ON u.id = r.usuario_id
                ORDER BY r.data_reserva DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM reservas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
