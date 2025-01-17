<?php
// On inclut le fichier qui gère la logique SQL
require_once '../Modéle/db_modifier_joueur.php';

// 1) Récupération de la connexion
$pdo = getDBConnection();

// 2) Vérifier si l'ID du joueur est fourni
if (!isset($_GET['id'])) {
    echo "ID du joueur non fourni.";
    exit;
}

$id = $_GET['id'];

// 3) Charger les informations du joueur avec la fonction de_modifier.php
$joueur = getJoueurById($pdo, $id);
if (!$joueur) {
    echo "Joueur introuvable.";
    exit;
}

// 4) Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs du formulaire
    $joueurData = [
        'nom'            => $_POST['nom'],
        'prenom'         => $_POST['prenom'],
        'date_naissance' => $_POST['date_naissance'],
        'taille'         => $_POST['taille'],
        'poids'          => $_POST['poids'],
        'poste'          => $_POST['poste'],
        'Id_Statut'      => $_POST['Id_Statut'],
        // On récupère le commentaire
        'commentaires'   => $_POST['commentaires'] ?? ''
    ];

    // 5) Mettre à jour le joueur
    updateJoueur($pdo, $id, $joueurData);

    // 6) Rediriger vers la page de gestion
    header("Location: ../VUE/php/Gestion.php");
    exit;
}

// 7) Affichage du formulaire HTML si on n'est pas en POST
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier un Joueur</title>
    <link rel="stylesheet" href="/Projet_php/Vue/css/modifier.css">
</head>
<body>
    <h1>Modifier les informations du joueur</h1>
    <form method="POST">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" 
               value="<?= htmlspecialchars($joueur['Nom']) ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" 
               value="<?= htmlspecialchars($joueur['Prenom']) ?>" required>

        <label for="date_naissance">Date de Naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" 
               value="<?= htmlspecialchars($joueur['Date_De_Naissance']) ?>" required>

        <label for="taille">Taille (cm) :</label>
        <input type="number" id="taille" name="taille" 
               value="<?= htmlspecialchars($joueur['Taille']) ?>" required>

        <label for="poids">Poids (kg) :</label>
        <input type="number" id="poids" name="poids" 
               value="<?= htmlspecialchars($joueur['Poids']) ?>" required>

        <label for="poste">Poste Préféré :</label>
        <select id="poste" name="poste" required>
            <option value="Ailier"       <?= $joueur['Poste_Joueur'] === 'Ailier'       ? 'selected' : '' ?>>Ailier</option>
            <option value="Meneur"       <?= $joueur['Poste_Joueur'] === 'Meneur'       ? 'selected' : '' ?>>Meneur</option>
            <option value="Arrière"      <?= $joueur['Poste_Joueur'] === 'Arrière'      ? 'selected' : '' ?>>Arrière</option>
            <option value="Ailier Fort"  <?= $joueur['Poste_Joueur'] === 'Ailier Fort'  ? 'selected' : '' ?>>Ailier Fort</option>
            <option value="Pivot"        <?= $joueur['Poste_Joueur'] === 'Pivot'        ? 'selected' : '' ?>>Pivot</option>
        </select>

        <label for="Id_Statut">Statut :</label>
        <select id="Id_Statut" name="Id_Statut" required>
            <option value="STAT001" <?= $joueur['Id_Statut'] === 'STAT001' ? 'selected' : '' ?>>Actif</option>
            <option value="STAT002" <?= $joueur['Id_Statut'] === 'STAT002' ? 'selected' : '' ?>>Blessé</option>
            <option value="STAT003" <?= $joueur['Id_Statut'] === 'STAT003' ? 'selected' : '' ?>>Suspendu</option>
            <option value="STAT004" <?= $joueur['Id_Statut'] === 'STAT004' ? 'selected' : '' ?>>Absent</option>
        </select>

        <label for="commentaires">Commentaires :</label>
        <textarea id="commentaires" name="commentaires" rows="4" cols="50">
            <?= htmlspecialchars($joueur['Commentaires'] ?? '') ?>
        </textarea>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
