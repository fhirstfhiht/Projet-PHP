<?php
require_once 'db_connection.php';

function getStatistiques() {
    $db = connectDB();

    // Requête pour récupérer les statistiques des joueurs
    $queryJoueurs = "
        SELECT 
            j.Numero_Licence,
            j.Nom, 
            j.Prenom, 
            s.Libelle AS Statut, 
            j.Poste_Joueur AS PostePrefere,
            COUNT(CASE WHEN p.Statut_Participation = 'Titulaire' THEN 1 END) AS Titularisations,
            COUNT(CASE WHEN p.Statut_Participation = 'Remplaçant' THEN 1 END) AS Remplacements,
            ROUND(COALESCE(AVG(p.Note), 0), 2) AS MoyenneEvaluation,
            ROUND((SUM(CASE WHEN m.Victoire = 1 THEN 1 ELSE 0 END) / NULLIF(COUNT(p.Id_Match), 0)) * 100, 2) AS PourcentageGagnes
        FROM joueurs j
        LEFT JOIN participer p ON j.Numero_Licence = p.Numero_Licence
        LEFT JOIN matchs m ON p.Id_Match = m.Id_Match
        LEFT JOIN statut s ON j.Id_Statut = s.Id_Statut
        GROUP BY j.Numero_Licence
    ";

    $stmt = $db->query($queryJoueurs);
    $joueurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour les statistiques globales des matchs
    $queryMatchs = "
        SELECT 
            COUNT(CASE WHEN Victoire = 1 THEN 1 END) AS matchs_gagnes,
            COUNT(CASE WHEN Egalite = 1 THEN 1 END) AS matchs_nuls,
            COUNT(CASE WHEN Victoire = 0 AND Egalite = 0 THEN 1 END) AS matchs_perdus,
            COUNT(*) AS total_matchs
        FROM matchs
        WHERE DATE(Date_Heure_Match) <= CURDATE()
    ";

    $stmt = $db->query($queryMatchs);
    $matchs = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calcul des pourcentages
    $totalMatchs = $matchs['total_matchs'] ?? 0;
    if ($totalMatchs > 0) {
        $matchs['pourcentage_gagnes'] = round(($matchs['matchs_gagnes'] / $totalMatchs) * 100, 2);
        $matchs['pourcentage_nuls'] = round(($matchs['matchs_nuls'] / $totalMatchs) * 100, 2);
        $matchs['pourcentage_perdus'] = round(($matchs['matchs_perdus'] / $totalMatchs) * 100, 2);
    } else {
        $matchs['pourcentage_gagnes'] = 0;
        $matchs['pourcentage_nuls'] = 0;
        $matchs['pourcentage_perdus'] = 0;
    }

    return [
        'joueurs' => $joueurs,
        'matchs' => $matchs
    ];
}
