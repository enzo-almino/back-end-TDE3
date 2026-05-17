<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todas as Reservas</title>
</head>
<body>
    <h1>Todas as Reservas</h1>
    <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! | <a href="index.php?route=pacotes">Pacotes</a> | <a href="index.php?route=auth&action=logout">Sair</a></p>

    <?php if (empty($reservas)): ?>
        <p>Nenhuma reserva encontrada.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Pacote</th>
                    <th>Transporte</th>
                    <th>Data da Reserva</th>
                    <th>Status</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva['codigo_localizador']) ?></td>
                    <td><?= htmlspecialchars($reserva['usuario_nome']) ?></td>
                    <td><?= htmlspecialchars($reserva['usuario_email']) ?></td>
                    <td><?= htmlspecialchars($reserva['titulo']) ?></td>
                    <td><?= htmlspecialchars($reserva['tipo_transporte']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($reserva['data_reserva'])) ?></td>
                    <td><?= htmlspecialchars($reserva['status_pagamento']) ?></td>
                    <td>
                        <form method="POST" action="index.php?route=reservas&action=excluir" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?')">
                            <input type="hidden" name="id" value="<?= (int) $reserva['id'] ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
