<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="../css/Base.css">
    <link rel="stylesheet" href="../css/Feuille_Match.css">
</head>
<body>
    <?php include 'header.php'; ?> 

    <h1>Feuille de Match</h1>

    <main>
        <section>
            <form id="feuilleDeMatchForm" action="enregistrer_feuille.php" method="POST">
                <h2>Sélectionnez les joueurs</h2>

                <label for="match">Choisissez un match :</label>
                <select name="match_id" id="match" required>
                    <?php
                    require_once '../SQL/db_connection.php';
                    require_once '../SQL/db_Feuilles_de_Matchs.php';

                    $db = connectDB();
                    $matches = getMatchsavenir($db);

                    foreach ($matches as $match) {
                        echo "<option value='" . htmlspecialchars($match['Id_Match']) . "'>" . htmlspecialchars($match['Date_Heure_Match']) . " - " . htmlspecialchars($match['Adversaire']) . "</option>";
                    }
                    ?>
                </select>

                <h3>Joueurs actifs</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Taille</th>
                            <th>Poids</th>
                            <th>Commentaire</th>
                            <th>Titulaire</th>
                            <th>Remplaçant</th>
                            <th>Poste</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $players = getJoueursactifsavecposition($db);

                        foreach ($players as $player) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($player['Nom']) . "</td>";
                            echo "<td>" . htmlspecialchars($player['Prenom']) . "</td>";
                            echo "<td>" . htmlspecialchars($player['Taille']) . " cm</td>";
                            echo "<td>" . htmlspecialchars($player['Poids']) . " kg</td>";
                            echo "<td>" . htmlspecialchars($player['Commentaires']) . "</td>";
                            echo "<td><input type='radio' name='joueur_" . htmlspecialchars($player['Numero_Licence']) . "' value='titulaire'></td>";
                            echo "<td><input type='radio' name='joueur_" . htmlspecialchars($player['Numero_Licence']) . "' value='remplacant'></td>";
                            echo "<td><input type='text' name='poste_" . htmlspecialchars($player['Numero_Licence']) . "' value='" . htmlspecialchars($player['Poste'] ?? '') . "' placeholder='Poste'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <button type="button" onclick="confirmerValidation(event)">Enregistrer</button>
            </form>
        </section>
    </main>

    <script src="../js/Feuilles_de_Matchs.js"></script>

</body>
</html>
