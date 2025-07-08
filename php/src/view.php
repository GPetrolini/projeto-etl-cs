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

        <?php if (isset($api_response_message)): ?>
            <div class="response-box <?php echo $status_class; ?>">
                <p><strong>Status da Operação:</strong></p>
                <pre><?php echo $api_response_message; ?></pre>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>