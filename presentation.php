<?php
include('api/linkDB.php');

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Presentation</title>
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
          <li class="limenu"><a href="recherche.html">Itinéraire</a></li>
          <li class="limenu"><a href="">Bon plan</a></li>
          <?php
          if (!$_SESSION['connecte']) {
            echo '<button class="bouton_menu"><a href="connexion.php">Connexion</a></button>';
          } else {
            echo '<button class="bouton_menu"><a href="profil.php">Profil</a></button>
        <button class="bouton_menu"><a href="index.php?logout=1">Déconnexion</a></button>';
          }
          ?>
        </ul>
        <i class='bx bx-search-alt'></i>
        <!--Loupe de recherche-->
      </div>
      <div class="barre-recherche">
        <input type="text" class="recherche" placeholder="Rechercher...">
        <button class="bouton-recherche"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
            width="24px" fill="#e8eaed">
            <path
              d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
          </svg></button>
      </div>
    </nav>
  </div>



  <!-- <img src="europe.jpg">-->

  <!--<div class="scrolling-text">
  Profitez d'une Offre Exclusive après l'inscription avec le code Click-journeY !!!
</div>-->
  <!--<label>Filtre :</label>
 
  <select>
    <option value="">Choisir une option</option>
    <option value="Prix Croissant">Prix Croissant</option>
    <option value="Prix Décroissant">Prix Décroissant</option>
  </select>-->

  <div class="contenant">
    <?php
    for ($i = 1; $i <= 5; $i++) {
      echo '    <div class="carte">
      <img class="imagevoyage" src="media/voyage/voyage' . $i . '.jpg" alt="Image ' . $voyage[$i]['titre'] . '" >
      <div class="texte">
        <h2>' . $desc[$i]['titre'] . '</h2>
        <br>À partir de : ' . $voyage[$i]['prix'] . ' €</br>
        <p></p>
        <a href="voyage.php?get=' . $i . '">Réservez Maintenant</a>
      </div>
      </div>';
    }
    ?>
  </div>
  <div class="contenant">
    <?php
    for ($i = 6; $i <= 10; $i++) {
      echo '    <div class="carte">
      <img class="imagevoyage" src="media/voyage/voyage' . $i . '.jpg" alt="Image ' . $voyage[$i]['titre'] . '" >
      <div class="texte">
        <h2>' . $desc[$i]['titre'] . '</h2>
        <br>À partir de : ' . $voyage[$i]['prix'] . ' €</br>
        <p></p>
        <a href="voyage.php?get=' . $i . '">Réservez Maintenant</a>
      </div>
      </div>';
    }
    ?>
  </div>
  <div class="contenant">
    <?php
    for ($i = 11; $i <= 15; $i++) {
      echo '    <div class="carte">
      <img class="imagevoyage" src="media/voyage/voyage' . $i . '.jpg" alt="Image ' . $voyage[$i]['titre'] . '" >
      <div class="texte">
        <h2>' . $desc[$i]['titre'] . '</h2>
        <br>À partir de : ' . $voyage[$i]['prix'] . ' €</br>
        <p></p>
        <a href="voyage.php?get=' . $i . '">Réservez Maintenant</a>
      </div>
      </div>';
    }
    ?>
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