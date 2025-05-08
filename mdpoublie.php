
<?php
// lecture du cookie pour le theme
$theme = $_COOKIE['theme'] ?? 'style';
$fiche = ($theme === 'sombre') ? 'sombre.css' : 'style.css';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link id="css" rel="stylesheet" type="text/css" href="<?= htmlspecialchars($fiche)?>"> <!-- htmlspecialchars($fiche) sert à sécuriser ce que renvoie $fiche on pourrai faire sans -->
    <title>Mot de passe oublié</title>
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
            <h1>Réinitialisation du mot de passe</h1>
            <form action="#" method="POST">
                <label for="mail">
                    Pour créer un nouveau mot passe, veuillez renseigner votre adresse e-mail et nous vous enverrons un lien de réinitialisation par e-mail dans quelques minutes.
                    <input type="email" placeholder="Email" name="mail" id="mail" required>
                </label>
                <button class="submit" type="submit">Valider</button>
                <!--<a href="javascript:history.back()">Retour</a>-->

            </form>
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

</body>
</html>