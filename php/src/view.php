<?php require_once 'Config/PlayerStatsConstants.php'; ?>
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

        <?php if (isset($data) && !empty($data)): ?>
            <div class="table-container">
                <table class="data-table"> 
                    <thead>
                        <tr>
                            <th><?php echo PlayerStatsConstants::NAME_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::TEAM_NAME_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::KILL_COUNT_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::DEATH_COUNT_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::ASSIST_COUNT_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::HEADSHOT_COUNT_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::KD_RATIO_LABEL; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $jogador): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::NAME]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::TEAM_NAME]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::KILL_COUNT]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::DEATH_COUNT]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::ASSIST_COUNT]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::HEADSHOT_COUNT]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::KD_RATIO]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?> 
    </div>
</body>
</html>