<?php
require_once '../../Modéle/db_Accueil.php'; // Inclure le fichier pour récupérer les données du prochain match
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
        
			<h1>
				Accueil 
			</h1>
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
						Actu Basket
					</h2>
					<div>
						<article>
							<h2>
							Record de points lors de Real Madrid - Maccabi Tel-Aviv
							</h2>
							<p>
							La rencontre entre le Real Madrid et le Maccabi Tel-Aviv jouée ce mardi a battu des records. Les deux équipes ont inscrit un total de 229 points (116-113), un record historique en Euroligue dans un match sans prolongation.
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