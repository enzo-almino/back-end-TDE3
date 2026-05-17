<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pacote</title>
</head>
<body>
    <h1>Criar Novo Pacote</h1>
    <a href="index.php?route=pacotes">Voltar</a>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?route=pacotes&action=criar">
        <p>
            <label>Título:</label><br>
            <input type="text" name="titulo" required>
        </p>
        <p>
            <label>Tipo de Transporte:</label><br>
            <select name="tipo_transporte" required>
                <option value="Avião">Avião</option>
                <option value="Ônibus">Ônibus</option>
                <option value="Cruzeiro">Cruzeiro</option>
            </select>
        </p>
        <p>
            <label>Preço (R$):</label><br>
            <input type="number" name="preco" step="0.01" min="0.01" required>
        </p>
        <p>
            <label>Vagas Totais:</label><br>
            <input type="number" name="vagas_totais" min="0" required>
        </p>
        <p>
            <label>Vagas Disponíveis:</label><br>
            <input type="number" name="vagas_disponiveis" min="0" required>
        </p>
        <p>
            <label>Data e Hora de Ida:</label><br>
            <input type="datetime-local" name="data_ida" required>
        </p>
        <p>
            <label>Data e Hora de Volta (opcional):</label><br>
            <input type="datetime-local" name="data_volta">
        </p>
        <p>
            <button type="submit">Salvar</button>
        </p>
    </form>
</body>
</html>
