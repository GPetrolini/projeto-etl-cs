<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Dados - CS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <?php require_once 'Config/PlayerStatsConstants.php'; ?>
</head>
<body class="bg-dark">
    <div class="container my-5">
        <div class="card bg-dark text-white border-secondary shadow-lg">
            <div class="card-body p-4 p-md-5">
                <h1 class="display-4 text-center mb-2 text-warning">Pipeline de Dados - CS</h1>
                <p class="text-center text-white-50 mb-4">Utilize os botões abaixo para interagir com o pipeline de dados.</p>
                
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                    <a href="teams.php" class="btn btn-primary">Ver Análise por Time &rarr;</a>
                    <form action="index.php" method="post" class="m-0">
                        <button type="submit" class="btn btn-success">Atualizar Dados (ETL)</button>
                    </form>
                </div>
                
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
                <?php endif; ?>

                <?php if (isset($successMessage)): ?>
                    <div class="alert alert-success"><?php echo htmlspecialchars($successMessage); ?></div>
                <?php endif; ?>

                <h2 class="mt-5 mb-3 h4">Estatísticas dos Jogadores</h2>
                <div class="search-container mb-3">
                    <form action="index.php" method="get" class="d-flex">
                        <input type="text" name="search" class="form-control me-2 bg-dark text-white" placeholder="Buscar por jogador ou time..." value="<?php echo htmlspecialchars($searchTerm ?? ''); ?>">
                        <button type="submit" class="btn btn-warning">Buscar</button>
                    </form>
                </div>

                <?php if (isset($data) && !empty($data)): ?>
                    <div class="table-container">
                        <table class="table table-dark table-striped table-hover"> 
                            <thead>
                                <tr>
                                    <th><?php echo PlayerStatsConstants::NAME_LABEL; ?></th>
                                    <th><?php echo PlayerStatsConstants::TEAM_NAME_LABEL; ?></th>
                                    <th><?php echo PlayerStatsConstants::KILL_COUNT_LABEL; ?></th>
                                    <th><?php echo PlayerStatsConstants::DEATH_COUNT_LABEL; ?></th>
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
                                        <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::KD_RATIO]); ?></td>
                                        <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::IMPACT_SCORE]); ?></td>
                                        <td><?php echo htmlspecialchars($jogador[PlayerStatsConstants::TIER]); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                
                    <div class="pagination-container d-flex justify-content-between mt-3">
                        <div>
                            <?php if ($currentPage > 1): ?>
                                <a href="index.php?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($searchTerm ?? ''); ?>" class="btn btn-outline-light">&larr; Anterior</a>
                            <?php endif; ?>
                        </div>
                        <div>
                            <?php if (count($data) >= 10): ?>
                                <a href="index.php?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($searchTerm ?? ''); ?>" class="btn btn-outline-light">Próxima &rarr;</a>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <p class="text-center text-white-50 mt-4">Nenhum dado encontrado no banco ou para o filtro informado.</p>
                <?php endif; ?> 
            </div>
        </div>
    </div>
</body>
</html>