<?php 
if(!isset($_SESSION)) {
  session_start();
}
if(!$_SESSION['connecte']) {
  header('Location: index.php');
}
require "api/linkDB.php"
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
  <title>Confirmation Paiement</title>
</head>
<body id="haut">
  
  <div>
<nav>
  <div class="divmenu">
    <div class="logo1">
        <a href="index.php"><img src="media/logo.webp" width="400" height="100" alt="Logo"></a>
    </div>
    <ul>
      <li class="limenu"><a href="index.php">Accueil</a></li>
        <li class="limenu"><a href="presentation.php">Trajets</a></li>
      <li class="limenu"><a href="recherche.php">Itinéraire</a></li>
      <li class="limenu"><a href="">Bon plan</a></li>
        <button class="bouton_menu"><a href="panier.php">Panier</a></button>
        <button class="bouton_menu"><a href="index.php?logout=1">Déconnexion</a></button>
        <button class="bouton_menu"><a href="profil.php">Profil</a></button>

      </ul>
      <i class='bx bx-search-alt'></i>
        <!--Loupe de recherche-->
  </div>
</nav>
  </div>
  <div class="confirmation-container">
  <?php 
  if(isset($_GET['succes'])) {
    echo '<h1>Paiement confirmé ✅</h1>
    <p>Merci pour votre réservation !</p>
    <p>Un e-mail de confirmation vous a été envoyé.</p>
    <p>Id de transaction : '. $_SESSION['transid'] . '</p>

    <div class="telechargements">
      <a href="recapitulatif.pdf" download class="btn-telechargement">📄 Télécharger le récapitulatif</a>
      <a href="facture.pdf" download class="btn-telechargement">🧾 Télécharger la facture</a>
    </div>';
  } else if(isset($_GET['cancel'])) {
      echo '  <h1>Commande annulée</h1>
    <p>La commande '. $_GET["commande"] . ' a bien été annulée.</p>
    <p>La somme de '. $commandes[$_GET["commande"]]['total'] . '€ ne vous a pas été facturée.</p>
    <a href="profil.php" class="btn-telechargement">Mes voyages</a>';
   } else {
    echo '  <h1>Paiement refusé ⛔</h1>
    <p>Veuillez réesayer votre achat.</p>
    <p>Id de transaction : '. $_SESSION['transid'] . '</p>
    <a href="recapitulatif.php?commande='.$_GET['commande']. '" class="btn-fail">Réessayer</a>';
 }
?>

    <a href="index.html" class="btn-retour">Retour à l'accueil</a>
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


</body>
</html>
