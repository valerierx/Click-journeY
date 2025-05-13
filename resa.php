<?php
include('api/linkDB.php');
if (!isset($_SESSION['connecte'])) {
    header('Location: connexion.php');
    exit;
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
    <link id="css" rel="stylesheet" type="text/css" href="<?= htmlspecialchars($fiche)?>"> <!-- htmlspecialchars($fiche) sert à sécuriser ce que renvoie $fiche on pourrai faire sans -->
    <title>Réservation</title>
</head>

<body id="haut">

            <script type="module" src="js/resa.js"></script>

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
                    <li class="limenu"><a href="">Bon plans</a></li>
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

        <div class="container-res">
            <div class="img_reservation">
                <img <?php echo 'src="media/voyage/voyage' . $_GET['get'] . '.jpg" alt="Image ' . $voyage[$_GET['get']]['titre'] . '"'; ?>>
            </div>
            <div class="encadrement">
                <h1 class="titre"><?= $voyage[$_GET['get']]['titre'] ?></h1>
                <p class="texte-res"><?= $voyage[$_GET['get']]['description'] ?></p>
                <h3 id="prixbase" data-prix="<?=$voyage[$_GET['get']]['prix']?>">Prix de base: <?=$voyage[$_GET['get']]['prix']?> €</h3>
            </div>
        </div>
        <div class="container-res">
            <h1>Réservation Voyage</h1>
        <form id="voyageForm" action="api/resa.php" method="POST">
                        <div class="prix-total">Total : <span id="prixTotal">0</span> €</div>


            <div class="form-actions">
                <button type="submit">Commander</button>
            </div>
            </form>
        </div>


        <footer>
            <div class="contenu">
                <div class="logo">
                    <h2>CY Eastern</h2>
                    <p>top voyage je vous promet</p>
                    <img src="media/logo.webp" alt="Logo" width="300" height="110"
                        style="display: flex; margin-left: -50px;">
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