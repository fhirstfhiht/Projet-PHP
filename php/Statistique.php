<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../css/statistique.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <?php include('header.php'); ?>

    <main>
        <h1>Statistiques</h1>

        <section class="general-stats">
            <h2>Statistiques Globales</h2>
            <div class="stats-container">
                <?php
                require_once '../SQL/db_connection.php';
                $db = connectDB();

                // Requête pour les statistiques globales (nombre de matchs gagnés, perdus, nuls)
                $query = "SELECT 
                            COUNT(CASE WHEN Victoire = 1 THEN 1 END) AS Victoires,
                            COUNT(CASE WHEN Egalite = 1 THEN 1 END) AS Nuls,
                            COUNT(CASE WHEN Victoire = 0 AND Egalite = 0 THEN 1 END) AS Defaites
                          FROM Matchs";
                $stmt = $db->query($query);
                $globalStats = $stmt->fetch(PDO::FETCH_ASSOC);

                // Calcul du total
                $totalMatchs = array_sum($globalStats);

                echo "<p>Total de matchs : $totalMatchs</p>";
                echo "<p>Victoires : " . $globalStats['Victoires'] . " (" . round(($globalStats['Victoires'] / $totalMatchs) * 100, 2) . "%)</p>";
                echo "<p>Nuls : " . $globalStats['Nuls'] . " (" . round(($globalStats['Nuls'] / $totalMatchs) * 100, 2) . "%)</p>";
                echo "<p>Défaites : " . $globalStats['Defaites'] . " (" . round(($globalStats['Defaites'] / $totalMatchs) * 100, 2) . "%)</p>";
                ?>
            </div>
        </section>

        <section class="player-stats">
            <h2>Statistiques des Joueurs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Statut</th>
                        <th>Poste Préféré</th>
                        <th>Titularisations</th>
                        <th>Remplacements</th>
                        <th>Moyenne des Évaluations</th>
                        <th>Matchs Consécutifs</th>
                        <th>Pourcentage de Matchs Gagnés</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Requête pour les statistiques des joueurs
                    $query = "SELECT 
                                j.Nom,
                                j.Prenom,
                                s.Libelle AS Statut,
                                p.Poste,
                                COUNT(CASE WHEN p.Statut_Participation = 'Titulaire' THEN 1 END) AS Titularisations,
                                COUNT(CASE WHEN p.Statut_Participation = 'Remplaçant' THEN 1 END) AS Remplacements,
                                AVG(p.Note) AS MoyenneEvaluation,
                                MAX( 
                                    CASE 
                                        WHEN p.Id_Match IS NOT NULL THEN 
                                            (SELECT COUNT(*) FROM Participer p2 WHERE p2.Numero_Licence = p.Numero_Licence AND p2.Id_Match <= p.Id_Match)
                                        ELSE 0
                                    END
                                ) AS MatchsConsecutifs,
                                ROUND((SUM(CASE WHEN m.Victoire = 1 THEN 1 ELSE 0 END) / COUNT(p.Id_Match)) * 100, 2) AS PourcentageGagnes
                              FROM Joueurs j
                              LEFT JOIN Participer p ON j.Numero_Licence = p.Numero_Licence
                              LEFT JOIN Matchs m ON p.Id_Match = m.Id_Match
                              LEFT JOIN Statut s ON j.Id_Statut = s.Id_Statut
                              GROUP BY j.Nom, j.Prenom, s.Libelle, p.Poste";

                    $stmt = $db->query($query);

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Nom'] . ' ' . $row['Prenom']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Statut']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Poste'] ?? 'Non spécifié') . "</td>";
                        echo "<td>" . htmlspecialchars($row['Titularisations']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Remplacements']) . "</td>";
                        echo "<td>" . round($row['MoyenneEvaluation'], 2) . "</td>";
                        echo "<td>" . htmlspecialchars($row['MatchsConsecutifs']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['PourcentageGagnes']) . "%</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <?php include('footer.php'); ?>
</body>
</html>
