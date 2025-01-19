<?php
require_once '../../Modéle/db_statistique.php';

$statistiques = getStatistiques();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../CSS/base.css">
    <link rel="stylesheet" href="../CSS/Statistique.css">
    <link rel="stylesheet" href="../CSS/index.css">
</head>

<?php include('header.php'); ?>

<body>

        <section class="section-page">
			<h2 class="title-page">Statistiques Générales</h2>
		</section>


    <main>
        <!-- Statistiques des matchs -->
        <section class="general-stats">
            <h2>Statistiques des Matchs</h2>
            <div class="stats-container">
                <p>Matchs gagnés : <strong><?= htmlspecialchars($statistiques['matchs']['matchs_gagnes'] ?? 0) ?></strong> (<?= htmlspecialchars($statistiques['matchs']['pourcentage_gagnes'] ?? 0) ?>%)</p>
                <p>Matchs nuls : <strong><?= htmlspecialchars($statistiques['matchs']['matchs_nuls'] ?? 0) ?></strong> (<?= htmlspecialchars($statistiques['matchs']['pourcentage_nuls'] ?? 0) ?>%)</p>
                <p>Matchs perdus : <strong><?= htmlspecialchars($statistiques['matchs']['matchs_perdus'] ?? 0) ?></strong> (<?= htmlspecialchars($statistiques['matchs']['pourcentage_perdus'] ?? 0) ?>%)</p>
                <p>Total des matchs : <strong><?= htmlspecialchars($statistiques['matchs']['total_matchs'] ?? 0) ?></strong></p>
            </div>
        </section>

        <!-- Statistiques des joueurs -->
        <section>
            <h2 class="title-page">Statistiques des Joueurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Statut</th>
                        <th>Poste Préféré</th>
                        <th>Titularisations</th>
                        <th>Remplacements</th>
                        <th>Moyenne Évaluation</th>
                        <th>% Victoires</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($statistiques['joueurs'])): ?>
                        <?php foreach ($statistiques['joueurs'] as $joueur): ?>
                            <tr>
                                <td><?= htmlspecialchars($joueur['Nom'] . ' ' . $joueur['Prenom']) ?></td>
                                <td><?= htmlspecialchars($joueur['Statut'] ?? 'Non spécifié') ?></td>
                                <td><?= htmlspecialchars($joueur['PostePrefere'] ?? 'Non spécifié') ?></td>
                                <td><?= htmlspecialchars($joueur['Titularisations']) ?></td>
                                <td><?= htmlspecialchars($joueur['Remplacements']) ?></td>
                                <td><?= htmlspecialchars($joueur['MoyenneEvaluation'] ?? '0') ?></td>
                                <td><?= htmlspecialchars($joueur['PourcentageGagnes'] ?? '0') ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" style="text-align: center;">Aucune donnée disponible.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
<?php include('footer.php'); ?>
</html>
