<?php
include_once '../SQL/db_connection.php';

$pdo = connectDB(); // Connexion à la base de données

// Variables pour stocker les statistiques
$statistiques = [];

try {
    // Tableau consolidé pour chaque joueur
    $queryJoueurStats = $pdo->query(
        "SELECT 
            j.Nom, 
            j.Prenom, 
            s.Libelle AS Statut, 
            j.Poste_Joueur AS PostePrefere,
            COUNT(CASE WHEN p.Statut_Participation = 'Titulaire' THEN 1 END) AS Titularisations,
            COUNT(CASE WHEN p.Statut_Participation = 'Remplaçant' THEN 1 END) AS Remplacements,
            ROUND(AVG(p.Note), 2) AS MoyenneEvaluation,
            MAX(
                CASE 
                    WHEN p.Id_Match IS NOT NULL THEN 
                        (SELECT COUNT(*) FROM participer p2 WHERE p2.Numero_Licence = p.Numero_Licence AND p2.Id_Match <= p.Id_Match)
                    ELSE 0
                END
            ) AS SelectionsConsecutives,
            ROUND((SUM(CASE WHEN m.Victoire = 1 THEN 1 ELSE 0 END) / COUNT(p.Id_Match)) * 100, 2) AS PourcentageGagnes
        FROM joueurs j
        LEFT JOIN participer p ON j.Numero_Licence = p.Numero_Licence
        LEFT JOIN matchs m ON p.Id_Match = m.Id_Match
        LEFT JOIN statut s ON j.Id_Statut = s.Id_Statut
        GROUP BY j.Nom, j.Prenom, s.Libelle, j.Poste_Joueur"
    );
    $statistiques['joueurs'] = $queryJoueurStats->fetchAll(PDO::FETCH_ASSOC);

    // Statistiques des matchs : gagnés, nuls, perdus et total joués
    $queryMatchsStats = $pdo->query(
        "SELECT 
            COUNT(CASE WHEN Victoire = 1 THEN 1 END) AS matchs_gagnes,
            COUNT(CASE WHEN Egalite = 1 THEN 1 END) AS matchs_nuls,
            COUNT(CASE WHEN Victoire = 0 AND Egalite = 0 THEN 1 END) AS matchs_perdus,
            COUNT(*) AS total_matchs
        FROM matchs"
    );
    $matchsStats = $queryMatchsStats->fetch(PDO::FETCH_ASSOC);
    $statistiques['matchs_gagnes'] = $matchsStats['matchs_gagnes'];
    $statistiques['matchs_nuls'] = $matchsStats['matchs_nuls'];
    $statistiques['matchs_perdus'] = $matchsStats['matchs_perdus'];
    $statistiques['total_matchs'] = $matchsStats['total_matchs'];

    // Calcul des pourcentages des résultats des matchs
    if ($statistiques['total_matchs'] > 0) {
        $statistiques['pourcentage_gagnes'] = round(($statistiques['matchs_gagnes'] / $statistiques['total_matchs']) * 100, 2);
        $statistiques['pourcentage_nuls'] = round(($statistiques['matchs_nuls'] / $statistiques['total_matchs']) * 100, 2);
        $statistiques['pourcentage_perdus'] = round(($statistiques['matchs_perdus'] / $statistiques['total_matchs']) * 100, 2);
    } else {
        $statistiques['pourcentage_gagnes'] = 0;
        $statistiques['pourcentage_nuls'] = 0;
        $statistiques['pourcentage_perdus'] = 0;
    }

} catch (PDOException $e) {
    echo "Erreur lors de la récupération des statistiques : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Joueurs et Matchs</title>
    <link rel="stylesheet" href="../css/Statistique.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<?php include('header.php'); ?>
<body>
    <h1 class="centrer">Statistiques des Joueurs et Matchs</h1>

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
