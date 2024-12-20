<!DOCTYPE HTML>
<html lang="fr">
    <link rel="stylesheet" href="Gestion.css">
    <head>
        <meta charset="utf-8" />
        <title>Gestion</title>
    </head>
    <?php include('header.php'); ?>
	<body>
  <main>
    <h1>Liste des joueurs</h1>
    <ul id="playerList">
      <li>
        <input type="checkbox" id="player1" class="toggle">
        <label for="player1" class="player-label">Joueur 1</label>
        <div class="player-info">
          <p>Âge : 25 ans</p>
          <p>Équipe : Équipe A</p>
          <p>Position : Attaquant</p>
		  <div class="Commentaires">
		  <p>Commentaire : </p>
</div>
          <div class="actions">
		  <a href="fiche.php" id="Fiche">Fiche joueur</a>
          <a href="Modifier.php" id="Modifier">Modifier</a>
		  <a href="Supprimer.php" id="Supprimer">Supprimer</a>
          </div>
        </div>
      </li>
      <li>
        <input type="checkbox" id="player2" class="toggle">
        <label for="player2" class="player-label">Joueur 2</label>
        <div class="player-info">
          <p>Âge : 28 ans</p>
          <p>Équipe : Équipe B</p>
          <p>Position : Défenseur</p>
          <div class="actions">
		  <a href="fiche.php" id="Fiche">Fiche joueur</a>
          <a href="Modifier.php" id="Modifier">Modifier</a>
		  <a href="Supprimer.php" id="Supprimer">Supprimer</a>
          </div>
        </div>
      </li>
      <li>
        <input type="checkbox" id="player3" class="toggle">
        <label for="player3" class="player-label">Joueur 3</label>
        <div class="player-info">
          <p>Âge : 22 ans</p>
          <p>Équipe : Équipe C</p>
          <p>Position : Milieu</p>
          <div class="actions">
		  <a href="fiche.php" id="Fiche">Fiche joueur</a>
          <a href="Modifier.php" id="Modifier">Modifier</a>
		  <a href="Supprimer.php" id="Supprimer">Supprimer</a>
          </div>
        </div>
      </li>
    </ul>
  </main>
</body>

    <?php include('footer.php'); ?>
    

</html>