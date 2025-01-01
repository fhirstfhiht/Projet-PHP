<?php
require_once '../SQL/db_connection.php';

$db = connectDB();

if (isset($_GET['id'])) {
    $idMatch = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dateHeure = $_POST['date_heure'];
        $adversaire = $_POST['adversaire'];
        $lieu = $_POST['lieu'];

        try {
            $updateQuery = "UPDATE Matchs 
                            SET Date_Heure_Match = :date_heure, Lieu = :lieu, Adversaire = :adversaire 
                            WHERE Id_Match = :id";
            $stmt = $db->prepare($updateQuery);
            $stmt->execute([
                ':date_heure' => $dateHeure,
                ':lieu' => $lieu,
                ':adversaire' => $adversaire,
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
            </head>
            <body>
                <main>
                    <form action="modifier_match.php?id=<?= htmlspecialchars($idMatch) ?>" method="POST">
                        <h2>Modifier le Match</h2>
                        <label>Date et Heure :</label>
                        <input type="datetime-local" name="date_heure" value="<?= htmlspecialchars($match['Date_Heure_Match']) ?>" required><br>

                        <label>Adversaire :</label>
                        <input type="text" name="adversaire" value="<?= htmlspecialchars($match['Adversaire']) ?>" required><br>

                        <label>Lieu :</label>
                        <select name="lieu" required>
                            <option value="domicile" <?= $match['Lieu'] === "domicile" ? "selected" : "" ?>>Domicile</option>
                            <option value="extérieur" <?= $match['Lieu'] === "extérieur" ? "selected" : "" ?>>Extérieur</option>
                        </select><br>

                        <button type="submit">Modifier</button>
                    </form>
                </main>
            </body>
            </html>
            <?php
        } else {
            echo "Match introuvable.";
        }
    }
} else {
    echo "ID du match non spécifié.";
}
?>
