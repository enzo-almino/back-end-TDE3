<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastro</h1>

    <?php if ($erro): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?route=auth&action=cadastro">
        <p>
            <label>Nome:</label><br>
            <input type="text" name="nome" placeholder="Seu nome completo" required>
        </p>
        <p>
            <label>Email:</label><br>
            <input type="email" name="email" placeholder="exemplo@email.com" required>
        </p>
        <p>
            <label>CPF:</label><br>
            <input type="text" name="cpf" maxlength="11" pattern="\d{11}" placeholder="000.000.000-00" title="Digite 11 números para o CPF ser válido" required>
        </p>
        <p>
            <label>Senha:</label><br>
            <input type="password" name="senha" minlength="6" placeholder="Insira sua senha" required>
        </p>
        <p>
            <label>Confirmar Senha:</label><br>
            <input type="password" name="confirmar_senha" minlength="6" placeholder="Repita sua senha" required>
        </p>
        <p>
            <button type="submit">Cadastrar</button>
        </p>
    </form>

    <p>Já tem conta? <a href="index.php?route=auth&action=login">Faça login</a></p>
</body>
</html>
