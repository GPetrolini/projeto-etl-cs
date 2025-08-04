<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise de Times - ETL CS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Análise de Performance por Time</h1>
        <p>Dados de K/D Ratio e Score de Impacto médios, ordenados por score.</p>
        <p><a href="index.php" class="btn">Voltar para a lista de jogadores</a></p>

        <div class="table-container">
            <?php if (isset($teamData) && !empty($teamData)): ?>
                <table class="data-table"> 
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
            <?php else: ?>
                <p>Não foi possível carregar os dados da análise. Tente atualizar os dados na página principal.</p>
            <?php endif; ?> 
        </div>
    </div>
</body>
</html>