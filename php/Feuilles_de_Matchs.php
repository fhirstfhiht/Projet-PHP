<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="../css/Base.css">
    <link rel="stylesheet" href="../css/Feuilles_de_Matchs.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Feuille de Match</h1>

    <main>
        <?php
        require_once '../SQL/db_connection.php';
        require_once '../SQL/db_Feuilles_de_Matchs.php';

        $db = connectDB();
        $matches = getMatchsAvenir($db);
        $players = getJoueursActifsAvecPosition($db);
        ?>
        <section>
            <form id="feuilleDeMatchForm" action="../ScriptsPhp/enregistrer_feuille.php" method="POST">
                <h2>Sélection des Joueurs</h2>
                <div class="centrer">
                    <label for="match">Choisissez un match :</label>
                    <select name="Id_Match" id="match" required>
                        <option value="" disabled selected>-- Sélectionnez un match --</option>
                        <?php
                        foreach ($matches as $match) {
                            echo "<option value='" . htmlspecialchars($match['Id_Match']) . "'>" 
                                . htmlspecialchars($match['Date_Heure_Match']) . " - " 
                                . htmlspecialchars($match['Adversaire']) 
                                . "</option>";
                        }
                        ?>
                    </select>
                </div>
                
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
                        foreach ($players as $player) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($player['Nom']) . "</td>";
                            echo "<td>" . htmlspecialchars($player['Prenom']) . "</td>";
                            echo "<td>" . htmlspecialchars($player['Taille']) . " cm</td>";
                            echo "<td>" . htmlspecialchars($player['Poids']) . " kg</td>";
                            echo "<td>" . htmlspecialchars($player['Commentaires']) . "</td>";
                            echo "<td><input type='radio' name='joueur_" . htmlspecialchars($player['Numero_Licence']) . "' value='titulaire'></td>";
                            echo "<td><input type='radio' name='joueur_" . htmlspecialchars($player['Numero_Licence']) . "' value='remplacant'></td>";
                            echo "<td>" . htmlspecialchars($player['Poste']) . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </section>

        <div class="centrer">
            <section>
                <button class="btn" onclick="confirmerValidation(event)">Enregistrer</button>
            </section>
        </div>
    </main>

    <script src="../js/Feuilles_de_Matchs.js"></script>

    <?php include('footer.php'); ?>
</body>
</html>
