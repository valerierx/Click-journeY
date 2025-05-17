<?php 
if(!isset($_SESSION)) {
  session_start();
}
if($_SESSION['connecte']) {
  header('Location: index.php');
}
?>

<?php
// lecture du cookie pour le theme
$theme = $_COOKIE['theme'] ?? 'style';
$fiche = ($theme === 'sombre') ? 'sombre.css' : 'style.css';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link id="css" rel="stylesheet" type="text/css" href="<?= htmlspecialchars($fiche)?>">
  <title>Connexion</title>
</head>
<body>

<div>
  <nav>
    <div id="haut" class="divmenu">
      <div class="logo1">
        <a href="index.html"><img src="media/logo.webp" width="400" height="100" alt="Logo"></a>
      </div>
      <ul>
        <li class="limenu"><a href="index.html">Accueil</a></li>
        <li class="limenu"><a href="presentation.php">Trajets</a></li>
        <li class="limenu"><a href="recherche.php">Itinéraire</a></li>
        <li class="limenu"><a href="">Bon plan</a></li>
        <button class="bouton_menu"><a href="connexion.php">Connexion</a></button>
      </ul>
      <i class='bx bx-search-alt'></i>
      <!--Loupe de recherche-->
    </div>
  </nav>
</div>
<!-- <img src="europe.jpg">-->

<!--<div class="scrolling-text">
 Profitez d'une Offre Exclusive après l'inscription avec le code Click-journeY !!!
</div>-->

<div class="contenant">
  <div class="carte">
    <div class="texte">
      <h1>Connexion</h1>
      <?php
      if(isset($_GET["incorrect"])) {
        echo '<p class="message erreur">
          Mail ou mot de passe incorrect!
        </p>';
      } else if(isset($_GET['nvcompte'])) {
        echo '<p class="message valide">
          Votre compte a été créé! Connectez-vous ci-dessous.
        </p>';
      }
      ?>
      <form action="api/connexion.php" method="POST">
        <label> 
          <input type="email"  placeholder="Email" name="mail" id="email" maxlength="30" required>
          <div id="erreur-email" style="color: red; display: none;">Adresse email invalide</div>
        </label>
        <label class="conteneur-mdp">
          <input type="password" placeholder="Mot de passe" name="mdp" id="motdepasse" required>
          <span class="bouton-motdepasse" onclick="basculerMotdepasse()">👀</span>
      </label>


        <label for="remember">
          <input type="checkbox" id="remember">
          Se souvenir de moi
        </label>
        <br>
          <a class="lien" href="mdpoublie.php">Mot de passse oublié ?</a>
        </br>
        <br>
        <button class="submit" type="submit">Se connecter</button>
      </form>
      <br>
        Pas encore inscrit?
      </br>
      <a class="lien" href="inscription.php">Créer un compte</a>
    </div>
  </div>
</div>


<footer>
  <div class="contenu">
    <div class="logo">
      <h2>CY Eastern</h2>
      <p>top voyage je vous promet</p>
      <img src="media/logo.webp" alt="Logo" width="300" height="110" style="display: flex; margin-left: -50px;">
    </div>
    <div class="colonne">
      <h3>Ou nous trouver</h3>
      <p>Av. du Parc, 95000 Cergy</p>
      <p>2 Av. Adolphe Chauvin, 95300 Pontoise</p>
      <p>06 xx xx xx xx</p>
      <p><a href="mailto:exemple@mail.com" style="color: rgb(237, 184, 50);">exemple@mail.com</a></p>
    </div>
    <div class="colonne">
      <h3>Navigation</h3>
      <ul class="ul-footer">
        <li><a href="#haut">haut de page</a></li>
        <li><a href="index.html">Accueil</a></li>
        <li><a href="presentation.php">Présentation</a></li>
        <li><a href="#">Nos services</a></li>
        <li><a href="connexion.php">Connexion</a></li>
        <li><a href="inscription.php">Inscription</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>copyright © 2025, CY Eastern</p>
  </div>
</footer>
<script src="js/index.js"></script>
</body>
</html>