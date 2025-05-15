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
  <title>Récapitulatif de votre voyage</title>
  <link id="css" rel="stylesheet" type="text/css" href="<?= htmlspecialchars($fiche)?>"> <!-- htmlspecialchars($fiche) sert à sécuriser ce que renvoie $fiche on pourrai faire sans -->

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
            <li class="limenu"><a href="recherche.php">Itinéraire</a></li>
            <li class="limenu"><a href="">Bon plan</a></li>
              <button class="bouton_menu"><a href="panier.php">Panier</a></button>
            <button class="bouton_menu"><a href="profil.php">Profil</a></button>
              <button class="bouton_menu"><a href="index.php?logout=1">Déconnexion</a></button>
          </ul>

          <i class='bx bx-search-alt'></i>
          <!--Loupe de recherche-->
        </div>
      </nav>
    </div>

    <div class="container">
      <h1>Récapitulatif de votre voyage</h1>
      <div class="details">
        <p><strong>Voyage : </strong><?= $voyage[$commandes[$_GET['commande']]['idVoyage']]['titre'] ?></p>
        <p>
            <?php
            if(count($pays[$commandes[$_GET['commande']]['idVoyage']]) != 1) {
                echo '<strong>Pays visités :</strong>';
            } else {
                echo '<strong>Pays visité :</strong>';
            }
            foreach($pays[$commandes[$_GET['commande']]['idVoyage']] as $row) {
                echo ' ' . $row['nom'] ;
            }
            ?></p>
        <p><strong>Date de départ : </strong><?php $debut = new DateTime($commandes[$_GET['commande']]['debut']);
        echo date('d/m/Y', $debut->getTimestamp()); ?></p>
        <p><strong>Date de retour : </strong><?php $fin = new DateTime($commandes[$_GET['commande']]['debut']);
        $fin->add(new DateInterval('P' . $voyage[$commandes[$_GET['commande']]['idVoyage']]['duree'] . 'D'));
        echo date('d/m/Y', $fin->getTimestamp()); ?></p>
        <p><strong>Nombre de voyageurs :
          </strong><?= $commandes[$_GET['commande']]['nVoyageurs'] . " personne" . ($commandes[$_GET['commande']]['nVoyageurs'] > 1 ? "s" : "") ?>
        </p>
        <p><strong>Option choisie :</strong>
          <!--table class="detail_table">
          <thead>
              <tr>
                  <th>Jour</th>
                  <th>Locomotion</th>
                  <th>Hébergement</th>
                  <th>Restauration</th>
                  <th>Activité sportive ou culturelle</th>
                  <th>Gestion du linge</th>
                  <th>Invité</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>1</td>
                  <td> Comprise </td>
                  <td> Comprise </td>
                  <td> Comprise </td>
                  <td> Non comprise</td>
                  <td> Oui </td>
                  <td>Non</td>
              </tr>
              <tr>
                  <td>2</td>
                  <td> Comprise </td>
                  <td> Non comprise </td>
                  <td> Non comprise </td>
                  <td> Non comprise </td>
                  <td> Non </td>
                  <td>Oui</td>
              </tr>
          </tbody>
      </table-->

          <?php
          $commandeId = isset($_GET['commande']) ? $_GET['commande'] : null;

          echo '<table border="1" cellpadding="5" cellspacing="0">';
          echo '<thead><tr>';

          if (!empty($commandesOpt) && isset($commandesOpt[$commandeId])) {
            echo '<th>Etape</th>';
            echo '<th>Option</th>';
            echo '<th>Prix</th>';
            echo '<th>Personnes Max</th>';
          }

          echo '</tr></thead><tbody>';

          if ($commandeId && isset($commandesOpt[$commandeId])) {
            foreach ($commandesOpt[$commandeId] as $item) {
                foreach($item as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['idEtape']) . '</td>';

                    if (isset($option[$row['idOption']]) && $row['idOption'] != "0") {
                        echo '<td>' . htmlspecialchars($option[$row['idOption']]['titre']) . '</td>';
                        echo '<td>' . htmlspecialchars($option[$row['idOption']]['prix']) . '€</td>';
                        echo '<td>' . htmlspecialchars($option[$row['idOption']]['personnesMax']) . '</td>';
                    } else {
                        echo '<td colspan="3">Aucune option</td>';
                    }
                    echo '</tr>';
                }
            }
          } else {
            echo '<tr><td colspan="6">Aucune commande trouvée</td></tr>';
          }

          echo '</tbody></table>';
          ?>
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
      <p class="total">Total à payer : <?= $commandes[$_GET['commande']]['total'] ?> €</p>


      <form action='https://www.plateforme-smc.fr/cybank/index.php' method='POST'>
        <input type='hidden' name='transaction' value=<?php
        $checkQuery = "SELECT id FROM transactions WHERE idCommande = '{$_GET['commande']}' AND status = '0' LIMIT 1";
        $result = mysqli_query($linkDB, $checkQuery);
        if (mysqli_num_rows($result) > 0) {
          // Réutiliser l'id existant
          $row = mysqli_fetch_assoc($result);
          $_SESSION['transid'] = $row['id'];
        } else {
          // Créer un nouvel id de transaction
          $transid = uniqid('', true);
          $transid = str_replace('.', '', $transid);
          $transid = substr($transid, 0, rand(10, 24));
          $_SESSION['transid'] = $transid;

          // Insérer la nouvelle transaction
          $transQuery = "INSERT INTO transactions (id, idCommande, status) VALUES ('{$transid}', '{$_GET['commande']}', '0')";
          mysqli_query($linkDB, $transQuery);
        }

        echo $_SESSION['transid'];
        ?>>
        <input type='hidden' name='montant' value="<?= $commandes[$_GET['commande']]['total'] ?>">
        <input type='hidden' name='vendeur' value='MI-1_A'>
        <input type='hidden' name='retour' value="http://localhost:8080/api/retour_paiement.php?session=<?=$_GET['commande']?>">
        <input type='hidden' name='control' value=<?php
        

        echo md5(
$api_key
. "#" . $_SESSION['transid']
. "#" . $commandes[$_GET['commande']]['total']
. "#" . "MI-1_A"
. "#" . "http://localhost:8080/api/retour_paiement.php?session=" .$_GET['commande']. "#" );
        ?>>
        <input class="btn-payer" type='submit' value="Valider et payer">
      </form>
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