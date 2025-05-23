<?php
if (!isset($_SESSION)) {
  session_start();
}

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
  session_destroy();
  session_start();
  $_SESSION['connecte'] = FALSE;
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
  <title>Accueil</title>
</head>

<body>
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
        <?php
        if (!$_SESSION['connecte']) {
          echo '<button class="bouton_menu"><a href="connexion.php">Connexion</a></button>';

        } else {
          echo '<button class="bouton_menu"><a href="panier.php">Panier</a></button><button class="bouton_menu"><a href="profil.php">Profil</a></button>
        <button class="bouton_menu"><a href="index.php?logout=1">Déconnexion</a></button>';
        }
        ?>
      </ul>
      <i class='bx bx-search-alt'></i> <!--Pas utiliser mais permet de centrer le menu-->
    </div>
  </nav>
  <!-- <img src="europe.jpg">-->

  <!--<div class="scrolling-text">
  Profitez d'une Offre Exclusive après l'inscription avec le code Click-journeY !!!
</div>-->
  <section class="section_accueil">
    <div class="accueil_contenu1">
      <img src="media/phototexte.jpg" class="accueil_image">
      <div class="accueil_texte">
        <h3 class="accueil_titre1">Bienvenue sur CY Eastern</h3>
        <p class="accueil_p">Nous sommes CY Eastern , une agence de voyage spécialisé dans les pays d'europe de
          l'est.<br>
          Explorez l'Europe de l'est, vivez l'inoubliable avec CY Eastern !<br>
          Pour vivre pleinement votre aventure rejoignez nous.</p>

        <a class="accueil_btn" href="inscription.php">Inscrivez-vous</a>
      </div>
    </div>
  </section>



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



</body>

</html>