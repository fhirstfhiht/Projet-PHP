<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matchs</title>
    <link rel="stylesheet" href="../css/Base.css">
    <link rel="stylesheet" href="../css/Liste_Match.css">
</head>
<body>
    <!-- <?php include 'header.php'; ?> -->

    <h1>Liste des Matchs</h1>

    <main>
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Date et Heure</th>
                        <th>Adversaire</th>
                        <th>Lieu</th>
                        <th>Résultat</th>
                        <th>Modification</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connexion à la base de données
                    require_once 'db_connection.php';

                    $db = connectDB();
                    $query = "SELECT Id_Match, Date_Heure_Match, Adversaire, Lieu, Score_equipe, Score_adversaire FROM Matchs";
                    $stmt = $db->query($query);

                    $currentDateTime = new DateTime();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Date_Heure_Match']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Adversaire']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['Lieu']) . "</td>";

                        $matchDateTime = new DateTime($row['Date_Heure_Match']);
                        if ($matchDateTime > $currentDateTime) {
                            echo "<td>A définir</td>";
                        } else {
                            if (!is_null($row['Score_equipe']) && !is_null($row['Score_adversaire'])) {
                                $result = $row['Score_equipe'] > $row['Score_adversaire'] ? 'Victoire' : ($row['Score_equipe'] == $row['Score_adversaire'] ? 'Égalité' : 'Défaite');
                                echo "<td>" . $result . "</td>";
                            } else {
                                echo "<td>Non défini</td>";
                            }
                        }

                        echo "<td>";
                        echo "<a href='modifier_match.php?id=" . htmlspecialchars($row['Id_Match']) . "'>Modifier</a> | ";
                        echo "<a href='#' onclick=\"confirmerSuppression(event, 'supprimer_match.php?id=" . htmlspecialchars($row['Id_Match']) . "')\">Supprimer</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <button class="btn" onclick="afficherPopupAjouterMatch()">Ajouter un Match</button>
        </section>
    </main>

    <script src="../js/Liste_Match.js"></script>
</body>
</html>
