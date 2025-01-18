<?php
include_once '../Modéle/db_connection.php';

$pdo = connectDB();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $numeroLicence = htmlspecialchars($_POST['Numero_Licence']);
    $dateNaissance = htmlspecialchars($_POST['date_naissance']);
    $taille = (int)$_POST['taille'];
    $poids = (float)$_POST['poids'];
    $idStatut = htmlspecialchars($_POST['Id_Statut']);
    $Poste_Joueur = htmlspecialchars($_POST['Poste']);

    if (strpos($numeroLicence, "J") !== 0) {
        echo "<div class='error'>Le numéro de licence doit commencer par 'J'.</div>";
        exit;
    }

    try {
        $sqlJoueurs = "INSERT INTO joueurs (Numero_Licence, Nom, Prenom, Date_De_Naissance, Taille, Poids, Poste_Joueur, Id_Statut)
                       VALUES (:numeroLicence, :nom, :prenom, :dateNaissance, :taille, :poids, :Poste_Joueur, :idStatut)";
        $stmtJoueurs = $pdo->prepare($sqlJoueurs);

        $stmtJoueurs->execute([
            ':numeroLicence' => $numeroLicence,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':dateNaissance' => $dateNaissance,
            ':taille' => $taille,
            ':poids' => $poids,
            ':Poste_Joueur' => $Poste_Joueur,
            ':idStatut' => $idStatut,
        ]);

        header("Location: ../Vue/php/Gestion.php?success=1");
        exit;
    } catch (PDOException $e) {
        echo "<div class='error'>Erreur lors de l'insertion : " . htmlspecialchars($e->getMessage()) . "</div>";
    }
} else {
    echo "<div class='error'>Aucune donnée soumise.</div>";
}
?>
