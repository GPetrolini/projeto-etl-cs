<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - ETL CS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Pipeline de Dados - CS</h1>
        <p>Clique no botão abaixo para iniciar o processo de ETL na API Python.</p>

        <form action="index.php" method="post">
            <button type="submit" class="btn">Iniciar ETL</button>
        </form>

        <?php if (isset($errorMessage)): ?>
            <div class="response-box response-error">
                <p><strong>Falha na Operação:</strong></p>
                <pre><?php echo htmlspecialchars($errorMessage); ?></pre>
            </div>
        <?php endif; ?>

        <?php if (isset($successMessage)): ?>
            <div class="response-box response-success">
                <p><strong>Sucesso:</strong></p>
                <pre><?php echo htmlspecialchars($successMessage); ?></pre>
            </div>
        <?php endif; ?> 
    </div>
</body>
</html>