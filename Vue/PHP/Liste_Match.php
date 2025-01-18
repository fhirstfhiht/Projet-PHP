<?php
$currentDateTime = new DateTime();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matchs</title>
    <link rel="stylesheet" href="../CSS/base.css">
    <link rel="stylesheet" href="../CSS/Liste_Match.css">
    <link rel="stylesheet" href="../CSS/index.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section>
        <div class="centrer">
            <a href="Gestion.php"><button class="btn">Liste des Joueurs</button></a>
        </div>
    </section>

    <section class="section-page">
		<h2 class="title-page">Liste des Matchs</h2>
	</section>

    <main>
        <?php
        // Gestion des éventuels messages passés en GET
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
                <?php include('../../Modéle/db_Liste_Match.php'); ?>
            </tbody>
        </table>

        <div class="centrer" >
            <button class="btn" onclick="afficherPopupAjouterMatch()">Ajouter un Match</button>
        </div>
    </main>

    <script src="../JS/Liste_Match.js"></script>
</body>
<?php include 'footer.php'; ?>
</html>
