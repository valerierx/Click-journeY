<?php include('api/linkDB.php'); ?>

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
    <title>Reservation voyage</title>
</head>

<body class="body_reservation" id="haut">

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
                    <?php
                    if (!$_SESSION['connecte']) {
                        echo '<button class="bouton_menu"><a href="connexion.php">Connexion</a></button>';
                    } else {
                        echo '<button class="bouton_menu"><a href="panier.php">Panier</a></button><button class="bouton_menu"><a href="profil.php">Profil</a></button>
                              <button class="bouton_menu"><a href="index.php?logout=1">Déconnexion</a></button>';
                    }
                    ?>
                </ul>
                <i class='bx bx-search-alt'></i>
                <!--Loupe de recherche-->
            </div>
        </nav>
    </div>

    <div class="container-res">
        <div class="img_reservation">
            <img <?php echo 'src="media/voyage/voyage' . $_GET['get'] . '.jpg" alt="Image ' . $voyage[$_GET['get']]['titre'] . '"'; ?>>
        </div>
        <div class="encadrement">
            <h1 class="titre"><?= $voyage[$_GET['get']]['titre'] ?></h1>
            <p class="texte-res"><?= $voyage[$_GET['get']]['description'] ?></p>
        </div>
    </div>

    <div class="container-res">

        <div class="encadrement">
            <h3>Déroulement du voyage</h3>
            <ul>
                <?php
                foreach ($deroul[$_GET['get']] as $jour => $row) {
                    echo '<li><h4>Jour ' . $jour . ' : ' . $row['titre'] . '</h4>';
                    echo '<p>' . $row['desc'] . '</h4></li>';
                }
                ?>
            </ul>
        </div>

    </div>

    <div class="container-res">

        <div class="encadrement">
            <h3>Informations : </h3>
            <ul>
                <li>
                    <?php
                    if(count($pays[$_GET['get']]) != 1) {
                        echo 'Pays visités :';
                    } else {
                        echo 'Pays visité :';
                    }
                    foreach($pays[$_GET['get']] as $row) {
                        echo ' ' . $row['nom'] ;
                    }
                    ?>
                </li>
                <li>Les trajets aller et retour ne sont pas pris en charge.</li>
                <li>Capacité maximale : <?= $voyage[$_GET['get']]['maxi'] ?> personnes.</li>
                <li>Durée du séjour : <?= $voyage[$_GET['get']]['duree'] ?> jours.</li>
                <li>Les services hôteliers, ainsi que les petits-déjeuners et dîners, sont pris en charge.</li>
                <li>Des activités sont incluses dans la formule de base du voyage.</li>
                <li>N'oubliez pas de consulter la section "Étapes" pour sélectionner des options complémentaires
                    avant
                    la validation finale.</li>

            </ul>
        </div>

    </div>

    <div class="container-res">

        <div>
            <p class="prix_reservation">À partir de : <?= $voyage[$_GET['get']]['prix'] ?>€</p>
            <?php
            if($_SESSION['connecte']) {
                echo '<a href="resa.php?get=' . $_GET['get'] . '" class="bouton1-res">Réserver maintenant</a>';
            } else {
                echo '<a href="connexion.php" class="bouton1-res">Connectez-vous pour réserver</a>';
            }
            ?>
            <!--button class="bouton3-res">Étape</button>
            <button class="btn-paiement">Procédé au paiement</button-->
        </div>
        <div class="div2reservation">
            <h2>Je m’organise :</h2>
            <a href="#" class="bouton2-res" style="background-color: #17a2b8;">Téléchargez la brochure PDF</a>
            <a href="#" class="bouton2-res" style="background-color: #6c757d;">Contacter le voyagiste</a>
        </div>
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