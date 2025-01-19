<?php
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../php/Connexion.php');
    exit;
}

// Inclure les fichiers nécessaires
require_once '../../Modéle/db_connection.php';
require_once '../../Modéle/db_Feuilles_de_Matchs.php';

// Obtenir une connexion à la base de données
$pdo = connectDB();
$players = [];
$matchId = $_GET['Id_Match'] ?? null;

// Charger tous les matchs
$matchs = getAllMatches($pdo);


// Charger les joueurs associés si un match est sélectionné
$players = getPlayersForMatch($pdo, $matchId);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier une Feuille de Match</title>
    <link rel="stylesheet" href="../CSS/modifier_feuille_de_match.css">
    <link rel="stylesheet" href="../CSS/index.css">
    <link rel="stylesheet" href="../CSS/base.css">
</head>
<body>
<?php include('header.php'); ?>
    <h1>Modifier une Feuille de Match</h1>

    <!-- Sélection du match -->
    <form method="GET" action="modifier_feuille_de_match.php">
    <label for="match">Match :</label>
    <select id="match" name="Id_Match" onchange="this.form.submit()">
        <option value="">-- Sélectionnez un match --</option>
        <?php
        $matchs = getAllMatches($pdo);
        foreach ($matchs as $match): ?>
            <option value="<?= htmlspecialchars($match['Id_Match']) ?>" <?= isset($_GET['Id_Match']) && $_GET['Id_Match'] === $match['Id_Match'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($match['Date_Heure_Match'] . " - " . $match['Adversaire']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>


    <?php if (!empty($players)): ?>
        <!-- Affichage des joueurs -->
        <form method="POST" action="../../Controleur/modifier_feuille.php">
    <!-- Inclure l'ID du match dans un champ caché -->
    <input type="hidden" name="Id_Match" value="<?= htmlspecialchars($matchId) ?>">

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Poste</th>
                <th>Participation</th>
                <th>Commentaire</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($players as $player): ?>
        <tr>
            <td><?= htmlspecialchars($player['Nom'] . " " . $player['Prenom']) ?></td>
            <td>
                <select name="poste[<?= $player['Numero_Licence'] ?>]">
                    <option value="Ailier" <?= $player['Poste'] === 'Ailier' ? 'selected' : '' ?>>Ailier</option>
                    <option value="Meneur" <?= $player['Poste'] === 'Meneur' ? 'selected' : '' ?>>Meneur</option>
                    <option value="Arrière" <?= $player['Poste'] === 'Arrière' ? 'selected' : '' ?>>Arrière</option>
                    <option value="Ailier Fort" <?= $player['Poste'] === 'Ailier Fort' ? 'selected' : '' ?>>Ailier Fort</option>
                    <option value="Pivot" <?= $player['Poste'] === 'Pivot' ? 'selected' : '' ?>>Pivot</option>
                </select>
            </td>
            <td>
                <label>
                    <input type="radio" name="participation[<?= $player['Numero_Licence'] ?>]" value="titulaire" <?= $player['Statut_Participation'] === 'titulaire' ? 'checked' : '' ?>>
                    Titulaire
                </label>
                <label>
                    <input type="radio" name="participation[<?= $player['Numero_Licence'] ?>]" value="remplaçant" <?= $player['Statut_Participation'] === 'remplaçant' ? 'checked' : '' ?>>
                    Remplaçant
                </label>
            </td>
            <td>
                <input type="text" name="commentaire[<?= $player['Numero_Licence'] ?>]" value="<?= htmlspecialchars($player['Commentaires'] ?? '') ?>">
            </td>
            <td>
                <input type="number" name="note[<?= $player['Numero_Licence'] ?>]" value="<?= htmlspecialchars($player['Note'] ?? '') ?>" min="1" max="5">
            </td>
            <td>
                <!-- Formulaire individuel pour le bouton Supprimer -->
                <form method="POST" action="../../Controleur/modifier_feuille.php" style="display: inline;">
                    <input type="hidden" name="Id_Match" value="<?= htmlspecialchars($matchId) ?>">
                    <input type="hidden" name="Numero_Licence" value="<?= htmlspecialchars($player['Numero_Licence']) ?>">
                    <button type="submit" name="delete_player" value="1" class="btn btn-danger">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <!-- Bouton pour enregistrer les modifications -->
    <button type="submit" name="save_changes" value="1" class="btn-enregistrer">Enregistrer les Modifications</button>
</form>

    <?php else: ?>
        <p>Veuillez d'abord créer la feuille de match</p>
    <?php endif; ?>
</body>
</html>
