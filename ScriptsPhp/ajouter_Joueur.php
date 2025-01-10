<?php
// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=projet;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $numeroLicence = htmlspecialchars($_POST['Numero_Licence']);
    $dateNaissance = htmlspecialchars($_POST['date_naissance']);
    $taille = (int)$_POST['taille'];
    $poids = (float)$_POST['poids'];
    $idStatut = htmlspecialchars($_POST['Id_Statut']); // STAT001, STAT002, etc.
    $poste = htmlspecialchars($_POST['Poste']); // Poste pour la table Participer
    $idMatch = htmlspecialchars($_POST['Id_Match']); // Id du match

    // Validation du numéro de licence
    if (strpos($numeroLicence, "J") !== 0) {
        die("Erreur : Le numéro de licence doit commencer par 'J'.");
    }

    // Validation de l'existence de l'Id_Statut
    $stmtStatut = $pdo->prepare("SELECT COUNT(*) FROM statut WHERE Id_Statut = :idStatut");
    $stmtStatut->execute([':idStatut' => $idStatut]);
    $statutExiste = $stmtStatut->fetchColumn();

    if (!$statutExiste) {
        die("Erreur : Le statut sélectionné est invalide.");
    }

    // Insertion dans la table Joueurs
    $sqlJoueurs = "INSERT INTO Joueurs (Numero_Licence, Nom, Prenom, Date_De_Naissance, Taille, Poids, Id_Statut)
                   VALUES (:numeroLicence, :nom, :prenom, :dateNaissance, :taille, :poids, :idStatut)";
    $stmtJoueurs = $pdo->prepare($sqlJoueurs);

    try {
        $stmtJoueurs->execute([
            ':numeroLicence' => $numeroLicence,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':dateNaissance' => $dateNaissance,
            ':taille' => $taille,
            ':poids' => $poids,
            ':idStatut' => $idStatut,
        ]);

        // Insertion dans la table Participer
        $sqlParticiper = "INSERT INTO Participer (Numero_Licence, Id_Match, Poste)
                          VALUES (:numeroLicence, :idMatch, :poste)";
        $stmtParticiper = $pdo->prepare($sqlParticiper);

        $stmtParticiper->execute([
            ':numeroLicence' => $numeroLicence,
            ':idMatch' => $idMatch,
            ':poste' => $poste,
        ]);

        // Redirection vers Gestion.php après l'ajout réussi
        header("Location: Gestion.php");
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de l'insertion : " . $e->getMessage());
    }
} else {
    echo "Aucune donnée soumise.";
}
?>
