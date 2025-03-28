<?php
session_start();
if (!isset($_SESSION['connecte'])) {
    header('Location: connexion.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Profil</title>
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
        <li class="limenu"><a href="presentation.html">Trajets</a></li>
        <li class="limenu"><a href="recherche.html">Itinéraire</a></li>
      <li class="limenu"><a href="">Bon plans</a></li>
      <button class="bouton_menu"><a href="connexion.php">Connexion</a></button>
      <button class="bouton_menu"><a href="profil.php">Profil</a></button>
      </ul>
      <i class='bx bx-search-alt'></i>   <!--Pas utiliser mais permet de centrer le menu-->
  </div>
</nav>


<!-- Section Profil -->
<section class="profil">
    <div class="profil-elmt">
        <img src="media/profil.jpg" alt="Photo de Profil" class="avatar">
        <?php
        if(isset($_GET["mail"])) {
            echo '<p class="message valide">
            Votre profil a été modifié!
            </p>';
        }
        ?>
        <h1>Profil</h1>
        <p>Nom: <?=$_SESSION['nom']?></p>
        <p>Prénom: <?=$_SESSION['prenom']?></p>
        <p>Email: <?=$_SESSION['mail']?></p>
        <p>Date de naissance : <?=$_SESSION['naissance']?></p>
        <h2>Adresse</h2>
        <p>2 Avenue du Parc</p>
        <p>95000 Cergy</p>
        <div class="bouton-array">
          <button class="modif-btn"><a href="modifProfil.php">Modifier Profil</a></button>
          <?php if ($_SESSION['role'] == 0) {
              echo '<button class="admin-btn"><a href="admin.php">Tableau de bord admin</a></button>';
          };?>
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
            <li><a href="presentation.html">Présentation</a></li>
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