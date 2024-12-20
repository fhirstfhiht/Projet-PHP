<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="../css/Base.css">
    <link rel="stylesheet" href="../css/Feuille_Match.css">
    <script>
        function confirmerValidation(event) {
            event.preventDefault();
            if (confirm("Êtes-vous sûr de vouloir enregistrer cette feuille de match ?")) {
                document.getElementById("feuilleDeMatchForm").submit();
            }
        }
    </script>
</head>
<body>
    <!-- <?php include 'header.php'; ?> -->

    <h1>Feuille de Match</h1>

    <main>
        <section>
            <form id="feuilleDeMatchForm" action="enregistrer_feuille.php" method="POST">
                <h2>Sélectionnez les joueurs</h2>

                <label for="match">Choisissez un match :</label>
                <select name="match_id" id="match" required>
                    <?php
                    require_once 'db_connection.php';
                    $db = connectDB();

                    $query = "SELECT Id_Match, Date_Heure_Match, Adversaire FROM Matchs WHERE Date_Heure_Match > NOW()";
                    $stmt = $db->query($query);

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($row['Id_Match']) . "'>" . htmlspecialchars($row['Date_Heure_Match']) . " - " . htmlspecialchars($row['Adversaire']) . "</option>";
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
                        $query = "SELECT Numero_Licence, Nom, Prenom, Taille, Poids, Commentaires FROM Joueurs WHERE Id_Statut = 'Actif'";
                        $stmt = $db->query($query);

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Nom']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Prenom']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Taille']) . " cm</td>";
                            echo "<td>" . htmlspecialchars($row['Poids']) . " kg</td>";
                            echo "<td>" . htmlspecialchars($row['Commentaires']) . "</td>";
                            echo "<td><input type='radio' name='joueur_" . htmlspecialchars($row['Numero_Licence']) . "' value='titulaire'></td>";
                            echo "<td><input type='radio' name='joueur_" . htmlspecialchars($row['Numero_Licence']) . "' value='remplacant'></td>";
                            echo "<td><input type='text' name='poste_" . htmlspecialchars($row['Numero_Licence']) . "' placeholder='Poste'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <button type="button" onclick="confirmerValidation(event)">Enregistrer</button>
            </form>
        </section>
    </main>
</body>
</html>
