<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Times - ETL CS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-secondary">
    <div class="container mt-5 mb-5">
        <div class="card bg-dark text-white shadow-lg">
            <div class="card-body p-4 p-md-5">
                <h1 class="display-4 text-center mb-2">Análise de Performance por Time</h1>
                <p class="text-center text-white-50 mb-4">Dados de K/D Ratio e Score de Impacto médios, ordenados por score.</p>
                <div class="text-center mb-4">
                    <a href="index.php" class="btn btn-primary">&larr; Voltar para a Lista de Jogadores</a>
                </div>

                <?php if (isset($teamData) && !empty($teamData)): ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped table-hover"> 
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>K/D Ratio Médio</th>
                                    <th>Score de Impacto Médio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teamData as $team): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($team['team_name']); ?></td>
                                        <td><?php echo htmlspecialchars($team['kd_ratio']); ?></td>
                                        <td><?php echo htmlspecialchars($team['impact_score']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center">
                        Não foi possível carregar os dados da análise. Tente atualizar os dados na página principal.
                    </div>
                <?php endif; ?> 
            </div>
        </div>
    </div>
</body>
</html>