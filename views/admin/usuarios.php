<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
</head>
<body>
    <h1>Gerenciar Usuários</h1>
    <p>Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>! | <a href="index.php?route=pacotes">Pacotes</a> | <a href="index.php?route=auth&action=logout">Sair</a></p>

    <?php if (empty($clientes)): ?>
        <p>Nenhum cliente para promover.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= (int) $cliente['id'] ?></td>
                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td>
                        <form method="POST" action="index.php?route=admin&action=promover" style="display:inline;" onsubmit="return confirm('Promover este usuário a admin?')">
                            <input type="hidden" name="id" value="<?= (int) $cliente['id'] ?>">
                            <button type="submit">Promover a Admin</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
