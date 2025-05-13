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
            </div>
        </div>
        <form action="api/resa.php" method="POST">

            <div class="container-res">
                <ul>
                    <?php
                    foreach ($etapes[$_GET['get']] as $id => $row) {
                        echo '<li><h4>Etape ' . $id . ' : ' . $row['titre'] . '</h4>';
                        echo '<ul>';

                        // Add "None" option first
                        echo '<li>';
                        echo '<input type="radio" name="etape_' . $id . '" id="none_' . $id . '" value="0" checked>';
                        echo '<label for="none_' . $id . '">Sans option</label>';
                        echo '</li>';

                        foreach ($etapeOpt[$_GET['get']][$id] as $idOpt => $row2) {
                            $optionData = $option[$row2['idOption']];
                            echo '<li>';
                            echo '<input type="radio" name="etape_' . $id . '" id="option_' . $id . '_' . $optionData['id'] . '" value="' . $optionData['id'] . '">';
                            echo '<label for="option_' . $id . '_' . $optionData['id'] . '">';
                            echo htmlspecialchars($optionData['titre']) . ' - ' . $optionData['prix'] . '€ (Max ' . $optionData['personnesMax'] . ' personnes)';
                            echo '</label>';
                            echo '</li>';
                        }

                        echo '</ul></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="container-res">
                <h3>Informations de réservation</h3>
                <ul class="booking-info">
                    <li>
                        <label for="passengers">Nombre de participants :</label>
                        <select name="passengers" id="passengers" required>
                            <?php
                            $maxCapacity = $voyage[$_GET['get']]['maxi'];
                            for ($i = 1; $i <= $maxCapacity; $i++) {
                                echo "<option value='$i'>$i personne" . ($i > 1 ? "s" : "") . "</option>";
                            }
                            ?>
                        </select>
                        (Capacité maximale : <?= $maxCapacity ?> personnes)
                    </li>

                    <li>
                        <label for="start_date">Date de début :</label>
                        <input type="date" name="start_date" id="start_date" required min="<?= date('Y-m-d') ?>"
                            max="<?= date('Y-m-d', strtotime('+1 year')) ?>">
                    </li>

                    <li class="info-note">
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
                    <li class="info-note">Les trajets aller et retour ne sont pas pris en charge.</li>
                    <li class="info-note">Durée du séjour : <?= $voyage[$_GET['get']]['duree'] ?> jours.</li>
                    <li class="info-note">Les services hôteliers, ainsi que les petits-déjeuners et dîners, sont
                        pris en charge.</li>
                    <li class="info-note">Des activités sont incluses dans la formule de base du voyage.</li>
                    <li class="info-note">N'oubliez pas de consulter la section "Étapes" pour sélectionner des
                        options complémentaires avant la validation finale.</li>
                </ul>
                

            </div>
            <input type="hidden" name="voyage" id="voyage" value="<?=$_GET['get']?>">
            <div class="form-actions">
                <button type="submit">Commander</button>
            </div>
        </form>


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