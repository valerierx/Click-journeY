<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>Page Admin</title>
</head>


<body id="haut" class="admin">

<nav>
    <div class="divmenu" >
        <div class="logo1">
            <a href="index.html"><img src="media/logo.webp" width="400" height="100" alt="Logo"></a>
        </div>
        <ul>
            <li class="limenu"><a href="index.html">Accueil</a></li>
        </ul>
        <i class='bx bx-search-alt'></i>
            <!--Loupe de recherche-->
    </div>
</nav>

<div id="haut-de-page">

    <table border="2" class="admin_warn">
        <tr>
          <td class="warn_image" ><img src="media/warn.png" width="100" height="100"  alt="triangle attention"></td>
          <td class="warn_text" >Attention, vous êtes sur une page administrateur.</td>
        </tr>
      </table>    

</div>





<nav  class="adminbar">

    <ul class="ul-adminbar">
        <li><a href="#utilisateurs" >Utilisateurs</a></li>
        <li><a href="#bannis">Liste noire</a></li>
        <li><a href="#reservation">État des réservations</a></li>
        <li><a href="#statistique">Affluence du site</a></li>
        
    </ul>

</nav>


<div class="admindiv">


    <table border="1" id="utilisateurs"  class="admintable" >
        <caption class="admintable" ><strong>Liste des utilisateurs</strong></caption>
        <thead>
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Téléphone</th>
                <th>Statut</th>
                <th>VIP</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>prenom.nom@email.com</td>
                <td>0123456789</td>
                <td>Client</td>
                <td>Oui</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Nom</td>
                <td>Prenom</td>
                <td>prenom.nom@email.com</td>
                <td>0987654321</td>
                <td>Client</td>
                <td>Non</td>
            </tr>
            <tr>
                <td>3</td>
                <td>CY</td>
                <td>Tech</td>
                <td>cy.tech@cytech.fr</td>
                <td>x</td>
                <td>Institution</td>
                <td>Oui</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>

                <td><button> <- précédent </button>  | <button>suivant -> </button> </td>
                <td>1/..</td>
                <td class="td-admin-modif"><button>Modifer</button></td>
                <td class="td-admin"><a href="#haut-de-page">Haut de page</a></td>
                <td class="td-admin" colspan="3" > <button> Bannir utilisateurs </button> </td>
            </tr>


        </tfoot>
    </table>


</div>

<div class="admindiv">

    <table border="1" id="bannis"  class="admintable">
        <caption class="admintable" ><strong>Liste des utilisateurs Bannis</strong></caption>
        <thead>
            <tr>
                <td>Identifiant</td>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Raison</th>
                <th>Date de banissement</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2345</td>
                <td>Truand</td>
                <td>Nom truand</td>
                <td>Truand@email.com</td>
                <td>0123456789</td>
                <td>Fraude</td>
                <td>10/02/2024</td>
            </tr>
            <tr>
                <td>4324</td>
                <td>Truand</td>
                <td>Nom truand</td>
                <td>Truand@email.com</td>
                <td>0987654321</td>
                <td>Impaye</td>
                <td>05/01/2024</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>

                <td><button><- précédent </button>  | <button>suivant -> </button> </td>
                <td>1/..</td>
                <td class="td-admin-modif"><button>Modifier</button></td>
                <td  class="td-admin"><a href="#haut-de-page">Haut de page</a></td>
                <td class="td-admin" colspan="3" > <button> Débannir utilisateurs </button> </td>
            </tr>
        </tfoot>
    </table>
    
</div>

<div class="admindiv">

    <table border="1" id="reservation" class="admintable">
        <caption class="admintable" ><strong>Gestion des Réservations</strong></caption>
        <thead>
            <tr>
                <th>Id réservation</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date</th>
                <th>Id compte</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>38754</td>
                <td>Nom</td>
                <td>Prenom</td>
                <td>15/05/2025</td>
                <td>2345</td>
                <td>
                    <select class="status">
                        <option value="En attente">En attente</option>
                        <option value="Confirmée">Confirmée</option>
                        <option value="Annulée">Annulée</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>38574</td>
                <td>Nom</td>
                <td>Prenom</td>
                <td>20/05/2025</td>
                <td>2345</td>
                <td>
                    <select class="status">
                        <option value="En attente">En attente</option>
                        <option value="Confirmée">Confirmée</option>
                        <option value="Annulée">Annulée</option>
                    </select>
                </td>
            </tr>
        </tbody>
        <tfoot>
        <tr>

            <td><button><- précédent </button>  | <button>suivant -> </button> </td>
            <td>1/..</td>
            <td class="td-admin-modif"><button>Modifier</button></td>
            <td  class="td-admin"><a href="#haut-de-page">Haut de page</a></td>
        </tr>
    </tfoot>
    </table>
</div>



<div class="admindiv">


    <table border="1" id="statistique" class="admintable">
        <caption class="admintable"><strong>Affluence quotidienne</strong></caption>
        <thead>
            <tr>
                <th>Date</th>
                <th>Visiteurs Uniques</th>
                <th>Pages vues</th>
                <th>Temps Moyen (min)</th>
                <th>Taux de Rebond (%)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>10/02/2025</td>
                <td>1.200</td>
                <td>4.500</td>
                <td>5.3</td>
                <td>45%</td>
            </tr>
            <tr>
                <td>11/02/2025</td>
                <td>980</td>
                <td>3.800</td>
                <td>4.9</td>
                <td>50%</td>
            </tr>
            <tr>
                <td>12/02/2025</td>
                <td>1.450</td>
                <td>5.200</td>
                <td>6.1</td>
                <td>40%</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>

                <td><button><- précédent </button>  | <button>suivant -> </button> </td>
                <td>1/..</td>
                <td class="td-admin-modif"><button>Modifier</button></td>
                <td  class="td-admin"><a href="#haut-de-page">Haut de page</a></td>
            </tr>
        </tfoot>
    </table>

</div>


<footer style="margin-top: 280px;">
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