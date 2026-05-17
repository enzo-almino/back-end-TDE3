<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pacote</title>
</head>
<body>
    <h1>Editar Pacote</h1>
    <a href="index.php?route=pacotes">Voltar</a>

    <?php if (!empty($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?route=pacotes&action=editar&id=<?= $pacote['id'] ?>">
        <p>
            <label>Título:</label><br>
            <input type="text" name="titulo" value="<?= htmlspecialchars($pacote['titulo']) ?>" required>
        </p>
        <p>
            <label>Tipo de Transporte:</label><br>
            <select name="tipo_transporte" required>
                <option value="Avião" <?= $pacote['tipo_transporte'] === 'Avião' ? 'selected' : '' ?>>Avião</option>
                <option value="Ônibus" <?= $pacote['tipo_transporte'] === 'Ônibus' ? 'selected' : '' ?>>Ônibus</option>
                <option value="Cruzeiro" <?= $pacote['tipo_transporte'] === 'Cruzeiro' ? 'selected' : '' ?>>Cruzeiro</option>
            </select>
        </p>
        <p>
            <label>Preço (R$):</label><br>
            <input type="number" name="preco" step="0.01" min="0.01" value="<?= $pacote['preco'] ?>" required>
        </p>
        <p>
            <label>Vagas Totais:</label><br>
            <input type="number" name="vagas_totais" min="0" value="<?= $pacote['vagas_totais'] ?>" required>
        </p>
        <p>
            <label>Vagas Disponíveis:</label><br>
            <input type="number" name="vagas_disponiveis" min="0" value="<?= $pacote['vagas_disponiveis'] ?>" required>
        </p>
        <p>
            <label>Data e Hora de Ida:</label><br>
            <input type="datetime-local" name="data_ida" value="<?= date('Y-m-d\TH:i', strtotime($pacote['data_ida'])) ?>" required>
        </p>
        <p>
            <label>Data e Hora de Volta (opcional):</label><br>
            <input type="datetime-local" name="data_volta" value="<?= $pacote['data_volta'] ? date('Y-m-d\TH:i', strtotime($pacote['data_volta'])) : '' ?>">
        </p>
        <p>
            <button type="submit">Atualizar</button>
        </p>
    </form>
</body>
</html>
