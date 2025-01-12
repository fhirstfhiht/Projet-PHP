<?php
include_once '../SQL/db_connection.php';

$pdo = connectDB();

// Récupérer les matchs disponibles
$matchQuery = $pdo->prepare("SELECT Id_Match, Date_Heure_Match, Adversaire FROM matchs WHERE Date_Heure_Match > NOW()");
$matchQuery->execute();
$matchs = $matchQuery->fetchAll();

// Récupérer les joueurs actifs
$joueurQuery = $pdo->prepare("SELECT Numero_Licence, Nom, Prenom, Poste_Joueur FROM joueurs WHERE Id_Statut = 'STAT001'");
$joueurQuery->execute();
$joueurs = $joueurQuery->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="../css/Feuilles_de_Matchs.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<?php include('header.php'); ?>
<body>
    <h1 class="centrer">Créer une Feuille de Match</h1>

    <form id="feuilleDeMatchForm" action="../ScriptsPhp/enregistrer_feuille.php" method="POST">
        <h2 for="match">Match :</h2>
        <select id="match" name="Id_Match" required>
            <option value="">-- Sélectionnez un match --</option>
            <?php foreach ($matchs as $match): ?>
                <option value="<?= htmlspecialchars($match['Id_Match']) ?>">
                    <?= htmlspecialchars($match['Date_Heure_Match'] . " - " . $match['Adversaire']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <h2 class="centrer">Joueurs disponibles</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Poste Préféré</th>
                    <th>Sélectionnez un Poste</th>
                    <th>Titulaire</th>
                    <th>Remplaçant</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joueurs as $joueur): ?>
                    <tr>
                        <td><?= htmlspecialchars($joueur['Nom']) ?></td>
                        <td><?= htmlspecialchars($joueur['Prenom']) ?></td>
                        <td><?= htmlspecialchars($joueur['Poste_Joueur']) ?></td>
                        <td>
                            <select name="participation[<?= $joueur['Numero_Licence'] ?>][poste]">
                                <option value="">-- Sélectionnez un Poste --</option>
                                <option value="Ailier">Ailier</option>
                                <option value="Meneur">Meneur</option>
                                <option value="Arrière">Arrière</option>
                                <option value="Ailier Fort">Ailier Fort</option>
                                <option value="Pivot">Pivot</option>
                            </select>
                        </td>
                        <td>
                            <input type="radio" name="participation[<?= $joueur['Numero_Licence'] ?>][statut]" value="titulaire">
                        </td>
                        <td>
                            <input type="radio" name="participation[<?= $joueur['Numero_Licence'] ?>][statut]" value="remplaçant">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn">Enregistrer la Feuille de Match</button>
    </form>

    <script src="../js/Feuilles_de_Matchs.js"></script>
</body>

<?php include('footer.php'); ?>
</html>
