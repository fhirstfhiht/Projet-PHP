<?php
include_once '../SQL/db_connection.php'; // Inclusion du fichier de connexion

$pdo = connectDB(); // Initialisation de la connexion 

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Charger les informations du joueur
    $query = $pdo->prepare("SELECT * FROM joueurs WHERE Numero_Licence = :id");
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();
    $joueur = $query->fetch(PDO::FETCH_ASSOC);

    if (!$joueur) {
        echo "Joueur introuvable.";
        exit;
    }
} else {
    echo "ID du joueur non fourni.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $date_naissance = $_POST['date_naissance'];
    $taille = $_POST['taille'];
    $poids = $_POST['poids'];
    $poste = $_POST['poste'];
    $id_statut = $_POST['Id_Statut'];

    // Mise à jour des informations du joueur
    $updateQuery = $pdo->prepare(
        "UPDATE joueurs 
        SET Nom = :nom, Prenom = :prenom, Date_De_Naissance = :date_naissance, 
            Taille = :taille, Poids = :poids, Poste_Joueur = :poste, Id_Statut = :id_statut 
        WHERE Numero_Licence = :id"
    );

    $updateQuery->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':date_naissance' => $date_naissance,
        ':taille' => $taille,
        ':poids' => $poids,
        ':poste' => $poste,
        ':id_statut' => $id_statut,
        ':id' => $id,
    ]);

    header("Location: ../php/Gestion.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Joueur</title>
    <link rel="stylesheet" href="../css/modifier.css">
</head>
<body>
    <h1>Modifier les informations du joueur</h1>
    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($joueur['Nom']) ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($joueur['Prenom']) ?>" required>

        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($joueur['Date_De_Naissance']) ?>" required>

        <label for="taille">Taille (cm) :</label>
        <input type="number" id="taille" name="taille" value="<?= htmlspecialchars($joueur['Taille']) ?>" required>

        <label for="poids">Poids (kg) :</label>
        <input type="number" id="poids" name="poids" value="<?= htmlspecialchars($joueur['Poids']) ?>" required>

        <label for="poste">Poste Préferé:</label>
        <select id="poste" name="poste" required>
            <option value="Ailier" <?= $joueur['Poste_Joueur'] == 'Ailier' ? 'selected' : '' ?>>Ailier</option>
            <option value="Meneur" <?= $joueur['Poste_Joueur'] == 'Meneur' ? 'selected' : '' ?>>Meneur</option>
            <option value="Arrière" <?= $joueur['Poste_Joueur'] == 'Arrière' ? 'selected' : '' ?>>Arrière</option>
            <option value="Ailier Fort" <?= $joueur['Poste_Joueur'] == 'Ailier Fort' ? 'selected' : '' ?>>Ailier Fort</option>
            <option value="Pivot" <?= $joueur['Poste_Joueur'] == 'Pivot' ? 'selected' : '' ?>>Pivot</option>
        </select>

        <label for="statut">Statut :</label>
        <select id="statut" name="Id_Statut" required>
            <option value="STAT001" <?= $joueur['Id_Statut'] == 'STAT001' ? 'selected' : '' ?>>Actif</option>
            <option value="STAT002" <?= $joueur['Id_Statut'] == 'STAT002' ? 'selected' : '' ?>>Blessé</option>
            <option value="STAT003" <?= $joueur['Id_Statut'] == 'STAT003' ? 'selected' : '' ?>>Suspendu</option>
            <option value="STAT004" <?= $joueur['Id_Statut'] == 'STAT004' ? 'selected' : '' ?>>Absent</option>
        </select>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
