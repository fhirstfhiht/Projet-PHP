<?php
// Activer les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../SQL/db_connection.php';

$db = connectDB();

// Récupérer les données du joueur pour affichage dans le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations du joueur
    $stmt = $db->prepare("SELECT * FROM Joueurs WHERE Numero_Licence = ?");
    $stmt->execute([$id]);
    $joueur = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$joueur) {
        die("Erreur : Joueur introuvable.");
    }

    // Récupérer la liste des statuts
    $statutStmt = $db->prepare("SELECT Id_Statut, Libelle FROM Statut");
    $statutStmt->execute();
    $statuts = $statutStmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer la dernière position du joueur depuis la table Participer
    $positionStmt = $db->prepare("SELECT Poste FROM Participer WHERE Numero_Licence = ? LIMIT 1");
    $positionStmt->execute([$id]);
    $position = $positionStmt->fetchColumn() ?? '';
}

// Mettre à jour les données du joueur après soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $statut = $_POST['statut'];
    $position = $_POST['position'];
    $commentaire = $_POST['commentaire'];

    try {
        $db->beginTransaction();

        // Mettre à jour les données dans la table Joueurs
        $stmt = $db->prepare("UPDATE Joueurs SET Nom = ?, Prenom = ?, Date_De_Naissance = ?, Id_Statut = ?, Commentaires = ? WHERE Numero_Licence = ?");
        $stmt->execute([$nom, $prenom, $date_naissance, $statut, $commentaire, $id]);

        // Mettre à jour la position dans Participer
        $postStmt = $db->prepare("UPDATE Participer SET Poste = ? WHERE Numero_Licence = ? LIMIT 1");
        $postStmt->execute([$position, $id]);

        $db->commit();

        header('Location: ../php/Gestion.php');
        exit;
    } catch (PDOException $e) {
        $db->rollBack();
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE HTML>
<html lang="fr">
<head>
    <link rel="stylesheet" href="../css/modifier.css">
    <meta charset="utf-8" />
    <title>Modifier Joueur</title>
</head>
<body>
    <h1>Modifier les informations du joueur</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($joueur['Numero_Licence'] ?? '') ?>">

        <label>Nom :</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($joueur['Nom'] ?? '') ?>" required><br>

        <label>Prénom :</label>
        <input type="text" name="prenom" value="<?= htmlspecialchars($joueur['Prenom'] ?? '') ?>" required><br>

        <label>Date de Naissance :</label>
        <input type="date" name="date_naissance" value="<?= htmlspecialchars($joueur['Date_De_Naissance'] ?? '') ?>" required><br>

        <label>Statut :</label>
        <select name="statut" required>
            <?php foreach ($statuts as $statut): ?>
                <option value="<?= htmlspecialchars($statut['Id_Statut']) ?>" <?= $statut['Id_Statut'] === $joueur['Id_Statut'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($statut['Libelle']) ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Position :</label>
        <select name="position" required>
            <option value="Ailier" <?= $position === 'Ailier' ? 'selected' : '' ?>>Ailier</option>
            <option value="Meneur" <?= $position === 'Meneur' ? 'selected' : '' ?>>Meneur</option>
            <option value="Arrière" <?= $position === 'Arrière' ? 'selected' : '' ?>>Arrière</option>
            <option value="Ailier Fort" <?= $position === 'Ailier Fort' ? 'selected' : '' ?>>Ailier Fort</option>
            <option value="Pivot" <?= $position === 'Pivot' ? 'selected' : '' ?>>Pivot</option>
        </select><br>

        <label>Commentaire :</label>
        <textarea name="commentaire" rows="4" cols="50" required><?= htmlspecialchars($joueur['Commentaires'] ?? '') ?></textarea><br>

        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>
