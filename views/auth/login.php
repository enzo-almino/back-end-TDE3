<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($erro): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?route=auth&action=login">
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="exemplo@email.com" required>
        </p>
        <p>
            <label>Senha:</label><br>
            <input type="password" name="senha" placeholder="Insira sua senha" required>
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>

    <p>Não tem conta? <a href="index.php?route=auth&action=cadastro">Cadastre-se</a></p>
</body>
</html>
