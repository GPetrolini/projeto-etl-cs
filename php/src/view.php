<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - ETL CS</title>
    <link rel="stylesheet" href="style.css">
    <?php require_once 'Config/PlayerStatsConstants.php'; ?>
</head>
<body>
    <div class="container">
        <h1>Pipeline de Dados - CS</h1>
        <p><a href="teams.php" class="btn">Ver Análise de Performance por Time &rarr;</a></p>
        <p>Clique no botão abaixo para atualizar os dados do banco de dados.</p>
        
        <form action="index.php" method="post">
            <button type="submit" class="btn">Atualizar Dados (ETL)</button>
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

        <div class="table-container">
            <h2>Estatísticas dos Jogadores</h2>
            
            <div class="search-container">
                <form action="index.php" method="get">
                    <input type="text" name="search" class="search-input" placeholder="Buscar por nome do jogador..." value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
                    <button type="submit" class="btn">Buscar</button>
                </form>
            </div>

            <?php if (isset($data) && !empty($data)): ?>
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
                            <th><?php echo PlayerStatsConstants::IMPACT_SCORE_LABEL; ?></th>
                            <th><?php echo PlayerStatsConstants::TIER_LABEL; ?></th>
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
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::IMPACT_SCORE]); ?></td>
                                <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::TIER]); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            
                <div class="pagination-container">
                    <?php if ($currentPage > 1): ?>
                        <a href="index.php?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($searchTerm ?? ''); ?>" class="btn">&larr; Anterior</a>
                    <?php endif; ?>

                    <?php if (count($data) >= 10): ?>
                        <a href="index.php?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($searchTerm ?? ''); ?>" class="btn">Próxima &rarr;</a>
                    <?php endif; ?>
                </div>

            <?php else: ?>
                <p>Nenhum dado encontrado no banco ou para o filtro informado.</p>
            <?php endif; ?> 
        </div>
    </div>
</body>
</html>