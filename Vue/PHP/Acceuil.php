<?php
require_once '../../Modéle/db_Accueil.php'; // Inclure le fichier pour récupérer les données du prochain match
session_start();
// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
    header('Location: ../../php/Connexion.php');
    exit;
}
?>

<!DOCTYPE HTML>

<html lang="fr">
    <link rel="stylesheet" href="../css/index.css">
    <head>
        <meta charset="utf-8" />
        <title>Page d'accueil</title>
    </head>
	
    <?php include('header.php'); ?>
    
    <body>
    <div class="background-image"></div>
		<main>
        
		<section class="accueil-section">
			<h2 class="accueil-title">Accueil</h2>
		</section>
			<div>
			<section id="match-a-venir">
				<h2>Prochain Match</h2>
				<?php if ($nextMatch): ?>
					<p><strong>Date et Heure :</strong> <?= htmlspecialchars($nextMatch['Date_Heure_Match']); ?></p>
					<p><strong>Lieu :</strong> <?= htmlspecialchars($nextMatch['Lieu']); ?></p>
					<p><strong>Adversaire :</strong> <?= htmlspecialchars($nextMatch['Adversaire']); ?></p>
				<?php elseif ($message): ?>
					<p><?= htmlspecialchars($message); ?></p>
				<?php endif; ?>
			</section>
				<section>
					<h2>
						Actualité Basket
					</h2>
					<div>
						<article>
							<h2>
							Le 2 mars 1962 à Hershey (Pennsylvanie)
							</h2>
							<p>
							Wilt Chamberlain a établi le record de points en un match de la NBA en marquant 100 points pour les Warriors de Philadelphie lors d'une victoire 169-147 contre les Knicks de New York.
							</p>
						</article>
						<article>
							<h2>
                            Guerschon Yabusele se distingue mais les Philadelphia Sixers s'inclinent en NBA
							</h2>
							<p>
							Guerschon Yabusele a été l'un des Philadelphia Sixers les plus en vue, mardi, en marquant 17 points face à l'Oklahoma City Thunder. Mais ce dernier est revenu victorieux de son déplacement en Pennsylvanie (118-102).
							</p>
						</article>
					</div>
				</section>
			</div>
			<aside>
				<p>
					Texte sans rapport direct.
				</p>
			</aside>
		</main>

		
    </body>
    <?php include('footer.php'); ?>
</html>