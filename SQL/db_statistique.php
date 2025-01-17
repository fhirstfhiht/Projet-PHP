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
                        (SELECT COUNT(*) 
                         FROM participer p2 
                         WHERE p2.Numero_Licence = p.Numero_Licence 
                           AND p2.Id_Match <= p.Id_Match)
                    ELSE 0
                END
            ) AS SelectionsConsecutives,
            ROUND(
                (SUM(CASE WHEN m.Victoire = 1 THEN 1 ELSE 0 END) / COUNT(p.Id_Match)) * 100, 
                2
            ) AS PourcentageGagnes
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
    // Vous pouvez gérer l’erreur comme vous le souhaitez (redirection, affichage, etc.)
    exit;
}
