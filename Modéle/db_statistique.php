<?php
include_once 'db_connection.php';

$pdo = connectDB(); // Connexion à la base de données

// Variables pour stocker les statistiques
$statistiques = [];

try {
    // -------------------------------------------------------------------------
    // 1) Statistiques par joueur, en ignorant les matchs dont la date est future
    // -------------------------------------------------------------------------
    // On utilise LEFT JOIN pour ne pas exclure les joueurs qui n’ont pas encore
    // participé à un match (m.Date_Heure_Match IS NULL).
    // La condition filtre sur la date : seuls les matchs dont la date est
    // aujourd’hui ou passée sont pris en compte.
    $queryJoueurStats = $pdo->query("
        SELECT 
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
        LEFT JOIN participer p 
               ON j.Numero_Licence = p.Numero_Licence
        LEFT JOIN matchs m 
               ON p.Id_Match = m.Id_Match
        LEFT JOIN statut s 
               ON j.Id_Statut = s.Id_Statut

        /* Filtre : ignorer les dates strictement supérieures à aujourd’hui */
        WHERE DATE(m.Date_Heure_Match) <= CURDATE()
              OR m.Date_Heure_Match IS NULL

        GROUP BY j.Nom, j.Prenom, s.Libelle, j.Poste_Joueur
    ");
    $statistiques['joueurs'] = $queryJoueurStats->fetchAll(PDO::FETCH_ASSOC);


    // --------------------------------------------------------
    // 2) Statistiques globales des matchs (gagnés, nuls, perdus)
    // --------------------------------------------------------
    // Pareil : on filtre les matchs futurs avec la même condition.
    $queryMatchsStats = $pdo->query("
        SELECT 
            COUNT(CASE WHEN Victoire = 1 THEN 1 END) AS matchs_gagnes,
            COUNT(CASE WHEN Egalite = 1 THEN 1 END) AS matchs_nuls,
            COUNT(CASE WHEN Victoire = 0 AND Egalite = 0 THEN 1 END) AS matchs_perdus,
            COUNT(*) AS total_matchs
        FROM matchs
        WHERE DATE(Date_Heure_Match) <= CURDATE()
    ");
    $matchsStats = $queryMatchsStats->fetch(PDO::FETCH_ASSOC);

    $statistiques['matchs_gagnes']  = $matchsStats['matchs_gagnes'];
    $statistiques['matchs_nuls']    = $matchsStats['matchs_nuls'];
    $statistiques['matchs_perdus']  = $matchsStats['matchs_perdus'];
    $statistiques['total_matchs']   = $matchsStats['total_matchs'];

    // Calcul des pourcentages
    if ($statistiques['total_matchs'] > 0) {
        $statistiques['pourcentage_gagnes'] = round(
            ($statistiques['matchs_gagnes'] / $statistiques['total_matchs']) * 100, 
            2
        );
        $statistiques['pourcentage_nuls'] = round(
            ($statistiques['matchs_nuls'] / $statistiques['total_matchs']) * 100, 
            2
        );
        $statistiques['pourcentage_perdus'] = round(
            ($statistiques['matchs_perdus'] / $statistiques['total_matchs']) * 100, 
            2
        );
    } else {
        $statistiques['pourcentage_gagnes'] = 0;
        $statistiques['pourcentage_nuls']   = 0;
        $statistiques['pourcentage_perdus'] = 0;
    }

} catch (PDOException $e) {
    echo "Erreur lors de la récupération des statistiques : " . $e->getMessage();
    exit;
}
