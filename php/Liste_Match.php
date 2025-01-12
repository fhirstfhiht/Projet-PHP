<?php
require_once '../SQL/db_connection.php';

$db = connectDB();

$query = "SELECT Id_Match, Date_Heure_Match, Adversaire, Lieu, Score_equipe, Score_adversaire FROM Matchs";
$stmt = $db->query($query);

$currentDateTime = new DateTime();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matchs</title>
    <link rel="stylesheet" href="../css/Base.css">
    <link rel="stylesheet" href="../css/Liste_Match.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section>
        <div class="centrer">
            <a href="Gestion.php"><button class="btn">Liste des Joueurs</button></a>
        </div>
    </section>

    <h1>Liste des Matchs</h1>

    <main>
        

        <?php
        if (isset($_GET['message'])) {
            if ($_GET['message'] === 'success') {
                echo "<p style='color: green;'>Le match a été supprimé avec succès.</p>";
            } elseif ($_GET['message'] === 'updated') {
                echo "<p style='color: green;'>Le match a été modifié avec succès.</p>";
            } elseif ($_GET['message'] === 'notfound') {
                echo "<p style='color: red;'>Le match demandé est introuvable.</p>";
            }
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Date et Heure</th>
                    <th>Adversaire</th>
                    <th>Lieu</th>
                    <th>Résultat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Date_Heure_Match']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Adversaire']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Lieu']) . "</td>";

                    $matchDateTime = new DateTime($row['Date_Heure_Match']);
                    if ($matchDateTime > $currentDateTime) {
                        echo "<td>A définir</td>";
                    } else {
                        $result = (!is_null($row['Score_equipe']) && !is_null($row['Score_adversaire'])) ?
                            (($row['Score_equipe'] > $row['Score_adversaire']) ? 'Victoire' : (($row['Score_equipe'] === $row['Score_adversaire']) ? 'Égalité' : 'Défaite')) : 'Non défini';
                        echo "<td>" . htmlspecialchars($result) . "</td>";
                    }

                    echo "<td>";
                    if ($matchDateTime > $currentDateTime) {
                        echo "<a href='../ScriptsPhp/modifier_match.php?id=" . htmlspecialchars($row['Id_Match']) . "'>Modifier</a> | ";
                    }
                     
                    echo "<a href='javascript:void(0)' onclick=\"confirmerSuppression('" . htmlspecialchars($row['Id_Match']) . "')\">Supprimer</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="centrer" >
            <button class="btn" onclick="afficherPopupAjouterMatch()">Ajouter un Match</button>
        </div>
        
    </main>

    <script src="../js/Liste_Match.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>
