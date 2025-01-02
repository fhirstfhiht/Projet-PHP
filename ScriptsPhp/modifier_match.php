<?php
require_once '../SQL/db_connection.php';

$db = connectDB();

if (isset($_GET['id'])) {
    $idMatch = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dateHeure = $_POST['date_heure'];
        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];
        $scoreEquipe = $_POST['score_equipe'];
        $scoreAdversaire = $_POST['score_adversaire'];

        try {
            $updateQuery = "UPDATE Matchs 
                            SET Date_Heure_Match = :date_heure, 
                                Lieu = :lieu, 
                                Adversaire = :adversaire, 
                                Score_Equipe = :score_equipe, 
                                Score_Adversaire = :score_adversaire
                            WHERE Id_Match = :id";
            $stmt = $db->prepare($updateQuery);
            $stmt->execute([
                ':date_heure' => $dateHeure,
                ':lieu' => $lieu,
                ':adversaire' => $adversaire,
                ':score_equipe' => $scoreEquipe,
                ':score_adversaire' => $scoreAdversaire,
                ':id' => $idMatch
            ]);

            header('Location: ../php/Liste_Match.php?message=updated');
            exit;
        } catch (PDOException $e) {
            echo "Erreur lors de la modification : " . $e->getMessage();
        }
    } else {
        $query = "SELECT * FROM Matchs WHERE Id_Match = :id";
        $stmt = $db->prepare($query);
        $stmt->execute([':id' => $idMatch]);
        $match = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($match) {
            ?>
            <!DOCTYPE html>
            <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Modifier Match</title>
                <link rel="stylesheet" href="../css/Base.css">
                <link rel="stylesheet" href="../css/index.css">
                <link rel="stylesheet" href="../css/modifier_match.css">
            </head>
            <body>
                <h1>Modifier le Match</h1>
                <main>
                    <form action="modifier_match.php?id=<?= htmlspecialchars($idMatch) ?>" method="POST">
                        <label for="date_heure">Date et Heure :</label>
                        <input type="datetime-local" name="date_heure" id="date_heure" 
                               value="<?= htmlspecialchars($match['Date_Heure_Match']) ?>" required><br>

                        <label for="adversaire">Adversaire :</label>
                        <input type="text" name="adversaire" id="adversaire" 
                               value="<?= htmlspecialchars($match['Adversaire']) ?>" required><br>

                        <label for="lieu">Lieu :</label>
                        <input type="text" name="lieu" id="lieu" 
                               value="<?= htmlspecialchars($match['Lieu']) ?>" required><br>

                        <label for="score_equipe">Score Équipe :</label>
                        <input type="number" name="score_equipe" id="score_equipe" min="0" 
                               value="<?= htmlspecialchars($match['Score_Equipe']) ?>" required><br>

                        <label for="score_adversaire">Score Adversaire :</label>
                        <input type="number" name="score_adversaire" id="score_adversaire" min="0" 
                               value="<?= htmlspecialchars($match['Score_Adversaire']) ?>" required><br>

                        <button type="submit">Enregistrer les modifications</button>
                    </form>
                </main>
            </body>
            </html>
            <?php
        } else {
            echo "<p>Match introuvable.</p>";
        }
    }
} else {
    echo "<p>ID du match non spécifié.</p>";
}
?>
