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
  <title>Inscription</title>
</head>

<body id="haut">

<div>
  <nav>
    <div class="divmenu">
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
    </div>
  </nav>
</div>

<div class="contenant">
  <div class="carte">
    <div class="texte">
      <h1>Inscription</h1>
      <?php
      if(isset($_GET["mail"])) {
        echo '<p class="message erreur">
          L\'adresse mail est déjà utilisée!
        </p>';
      }
      ?>
      <form action="api/inscription.php" method="POST">
        <label>
          <input type="text" placeholder="Nom" name="nom" required>
        </label>
        <label>
          <input type="text" placeholder="Prénom" name="prenom" required>
        </label>
        
        <label> 
          <input type="email"  placeholder="Email" name="mail" id="email" maxlength="30" required>
          <div id="compteur-email" class="compteur">0 / 30 caractères</div>
          <div id="erreur-email" style="color: red; display: none;">Adresse email invalide</div>
        </label>
          <label class="conteneur-mdp">
              <input type="password" placeholder="Mot de passe" name="mdp" id="motdepasse" maxlength="30" required>
              <span class="bouton-motdepasse" onclick="basculerMotdepasse()">👀</span>
              <div id="compteur-mdp" class="compteur">0 / 30 caractères</div>
          </label>
        <label>
          <input type="password" placeholder="Confirmation du mot de passe" name="mdp2" id="confirmation-mdp" required>
          <div id="erreur-mdp" style="color: red; display: none;"> Le mot de passe est incorrecte</div>
        </label>
        <label for="cgu">
          <input type="checkbox" id="cgu" name="cgu" required>
          J'accepte les conditions générales d'utilisation
        </label>
        <label for="newsletter">
          <input type="checkbox" id="newsletter" name="newsletter" value="1">
          J'accepte de recevoir notre newsletter
        </label>
        <button class="submit" type="submit">Créer un compte</button>
      </form>
      <br>
        Déjà client? <a class="lien" href="connexion.php">Se connecter</a>
      </br>
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
<script src="js/index.js" defer></script>
</body>
</html>