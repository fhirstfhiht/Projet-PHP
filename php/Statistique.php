<?php
include_once '../SQL/db_statistique.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Matchs et Joueurs</title>
    <link rel="stylesheet" href="../css/Statistique.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<?php include('header.php'); ?>
<body>
    <h1 class="centrer">Statistiques des Matchs et Joueurs</h1>

    <section class="general-stats">
        <h2>Statistiques des Matchs</h2>
        <div class="stats-container">
            <p>Nombre total de matchs joués : <strong><?= $statistiques['total_matchs'] ?></strong></p>
            <p>Nombre de matchs gagnés : <strong><?= $statistiques['matchs_gagnes'] ?></strong> (<?= $statistiques['pourcentage_gagnes'] ?>%)</p>
            <p>Nombre de matchs nuls : <strong><?= $statistiques['matchs_nuls'] ?></strong> (<?= $statistiques['pourcentage_nuls'] ?>%)</p>
            <p>Nombre de matchs perdus : <strong><?= $statistiques['matchs_perdus'] ?></strong> (<?= $statistiques['pourcentage_perdus'] ?>%)</p>
        </div>
    </section>

    <section>
        <h2 class="centrer">Statistiques des Joueurs</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Statut Actuel</th>
                    <th>Poste Préféré</th>
                    <th>Titularisations</th>
                    <th>Remplacements</th>
                    <th>Moyenne des Évaluations</th>
                    <th>Nombre de Sélections Consécutives</th>
                    <th>Pourcentage de Matchs Gagnés</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($statistiques['joueurs'] as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['Nom'] . ' ' . $joueur['Prenom']) ?></td>
                        <td><?= htmlspecialchars($joueur['Statut'] ?? 'Non spécifié') ?></td>
                        <td><?= htmlspecialchars($joueur['PostePrefere'] ?? 'Non spécifié') ?></td>
                        <td><?= htmlspecialchars($joueur['Titularisations']) ?></td>
                        <td><?= htmlspecialchars($joueur['Remplacements']) ?></td>
                        <td><?= htmlspecialchars($joueur['MoyenneEvaluation'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($joueur['SelectionsConsecutives']) ?></td>
                        <td><?= htmlspecialchars($joueur['PourcentageGagnes'] ?? '0') ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
<?php include('footer.php'); ?>
</html>
