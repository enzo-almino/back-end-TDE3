<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viagens</title>
</head>
<body>
    <h1>Viagens</h1>
    <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! | <a href="index.php?route=reservas&action=minhas">Minhas Reservas</a><?php if (($_SESSION['nivel_acesso'] ?? '') === 'admin'): ?> | <a href="index.php?route=reservas&action=todas">Todas as Reservas</a> | <a href="index.php?route=admin">Gerenciar Usuários</a><?php endif; ?> | <a href="index.php?route=auth&action=logout">Sair</a></p>

    <?php if (($_SESSION['nivel_acesso'] ?? '') === 'admin'): ?>
        <a href="index.php?route=pacotes&action=criar">Nova Viagem</a>
    <?php endif; ?>

    <?php if (!empty($_GET['erro'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_GET['erro']) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Viagem</th>
                <th>Transporte</th>
                <th>Preço</th>
                <th>Vagas</th>
                <th>Ida</th>
                <th>Volta</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pacotes as $pacote): ?>
            <tr>
                <td><?= (int) $pacote['id'] ?></td>
                <td><?= htmlspecialchars($pacote['titulo']) ?></td>
                <td><?= htmlspecialchars($pacote['tipo_transporte']) ?></td>
                <td>R$ <?= number_format((float) $pacote['preco'], 2, ',', '.') ?></td>
                <td><?= (int) $pacote['vagas_disponiveis'] ?>/<?= (int) $pacote['vagas_totais'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($pacote['data_ida'])) ?></td>
                <td><?= $pacote['data_volta'] ? date('d/m/Y H:i', strtotime($pacote['data_volta'])) : 'Somente ida' ?></td>
                <td>
                    <a href="index.php?route=reservas&action=reservar&id=<?= (int) $pacote['id'] ?>" onclick="return confirm('Confirmar reserva?')">Reservar</a>
                    <?php if (($_SESSION['nivel_acesso'] ?? '') === 'admin'): ?>
                        <a href="index.php?route=pacotes&action=editar&id=<?= (int) $pacote['id'] ?>">Editar</a>
                        <form method="POST" action="index.php?route=pacotes&action=excluir" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                            <input type="hidden" name="id" value="<?= (int) $pacote['id'] ?>">
                            <button type="submit">Excluir</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
