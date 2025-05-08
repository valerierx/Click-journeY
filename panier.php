<?php include('api/linkDB.php'); ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Recherche</title>
</head>

<body>

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
                <button class="bouton_menu"><a href="profil.php">Profil</a></button>
                <button class="bouton_menu"><a href="panier.php">Panier</a></button>
            </ul>

            <i class='bx bx-search-alt'></i>
            <!--Loupe de recherche-->
        </div>
    </nav>
</div>

<div class="container">
    <h1>Panier</h1>
    <div class="details">
        <?php
        $total = 0;
        foreach ($panier as $commande){
            $total += $commandes[$commande["idCommande"]]['total'];
            $debut = new DateTime($commandes[$commande['idCommande']]['debut']);
            $fin = new DateTime($commandes[$commande['idCommande']]['debut']);
            $fin->add(new DateInterval('P' . $voyage[$commandes[$commande['idCommande']]['idVoyage']]['duree'] . 'D'));

            echo '<h2>Voyage : '.  $voyage[$commandes[$commande['idCommande']]['idVoyage']]['titre'] .'</h2><p>';
            if(count($pays[$commandes[$commande['idCommande']]['idVoyage']]) != 1) {
                echo '<strong>Pays visités :</strong>';
            } else {
                echo '<strong>Pays visité :</strong>';
            }
            foreach($pays[$commandes[$commande['idCommande']]['idVoyage']] as $row) {
                echo ' ' . $row['nom'] ;
            }
            echo '</p><p><strong>Date de départ : </strong>' . date('d/m/Y', $debut->getTimestamp()) . '</p><p><strong>Date de retour : </strong>' . date('d/m/Y', $fin->getTimestamp()) . '</p><p><strong>Nombre de voyageurs :</strong> ' . $commandes[$commande['idCommande']]['nVoyageurs'] . " personne" . ($commandes[$commande['idCommande']]['nVoyageurs'] > 1 ? "s" : "");
            echo '<p><strong>Option choisie :</strong>';


            echo '<table border="1" cellpadding="5" cellspacing="0">';
            echo '<thead><tr>';

            if (!empty($commandesOpt) && isset($commandesOpt[$commande['idCommande']])) {
                echo '<th>Etape</th>';
                echo '<th>Option Titre</th>';
                echo '<th>Prix</th>';
                echo '<th>Personnes Max</th>';
            }

            echo '</tr></thead><tbody>';

            if ($commande['idCommande'] && isset($commandesOpt[$commande['idCommande']])) {
                foreach ($commandesOpt[$commande['idCommande']] as $item) {
                    echo '<tr>';
                    // Main commandeOpt data
                    echo '<td>' . htmlspecialchars($item['idEtape']) . '</td>';
                    // Additional option info
                    $optionId = $item['idOption'];
                    if (isset($option[$optionId]) && $optionId != "0") {
                        echo '<td>' . htmlspecialchars($option[$optionId]['titre']) . '</td>';
                        echo '<td>' . htmlspecialchars($option[$optionId]['prix']) . '€</td>';
                        echo '<td>' . htmlspecialchars($option[$optionId]['personnesMax']) . '</td>';
                    } else {
                        echo '<td colspan="3">Aucune option</td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">Aucune commande trouvée</td></tr>';
            }

            echo '</tbody></table>';

            echo '<a href="recapitulatif.php?commande='. $commande['idCommande'] . '" class="bouton1-res">Visualiser la commande</a>';


        }

        echo <<<'EOD'

        </p>

    </div>

    <p><strong>Le prix comprend : </strong></p>
    <p>Le prix initial du voyage inclut les nuits d'hôtel ainsi que la restauration par défaut (petit-déjeuner et
        dîner).</br>
        Il couvre également les activités proposées par l'agence.</br>
        De plus, les options que vous avez sélectionnées s'ajoutent au prix de base.</p>

    <p><strong>Attention : </strong></p>
    <p>Les services pour lesquels la prise en charge n'est pas indiquée sur la page de réservation ne sont pas
        couverts par l'agence.</p>
    <p class="total">Total du panier :
EOD;
        echo $total . "€</p>";

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