<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Reservas</title>
</head>
<body>
    <h1>Minhas Reservas</h1>
    <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! | <a href="index.php?route=pacotes">Pacotes</a> | <a href="index.php?route=auth&action=logout">Sair</a></p>

    <?php if ($sucesso): ?>
        <p style="color: green;">Reserva realizada com sucesso!</p>
    <?php endif; ?>

    <?php if (empty($reservas)): ?>
        <p>Você ainda não tem reservas.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Pacote</th>
                    <th>Transporte</th>
                    <th>Ida</th>
                    <th>Volta</th>
                    <th>Data da Reserva</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $reserva): ?>
                <tr>
                    <td><?= htmlspecialchars($reserva['codigo_localizador']) ?></td>
                    <td><?= htmlspecialchars($reserva['titulo']) ?></td>
                    <td><?= htmlspecialchars($reserva['tipo_transporte']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($reserva['data_ida'])) ?></td>
                    <td><?= $reserva['data_volta'] ? date('d/m/Y H:i', strtotime($reserva['data_volta'])) : 'Somente ida' ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($reserva['data_reserva'])) ?></td>
                    <td><?= htmlspecialchars($reserva['status_pagamento']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
