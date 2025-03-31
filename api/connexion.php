<?php
include 'linkDB.php';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ( !isset($_POST['mail'], $_POST['mdp']) ) {
        // Requête vide
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "400", "message" => "Requête incorrecte", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }

    $mail = mysqli_real_escape_string($linkDB, $_POST['mail']);
    $password = mysqli_real_escape_string($linkDB, $_POST['mdp']);

    $query = "SELECT * FROM login WHERE mail='$mail'";
    $result = mysqli_query($linkDB, $query);
    $row = mysqli_fetch_array($result);
    if ($row) {
        // compte existant
        if (password_verify($_POST['mdp'], $row["motdepasse"])) {
            $id = $row['id'];
            $profileQuery = "SELECT * FROM comptes WHERE idCompte='$id'";
            $profileResult = mysqli_query($linkDB, $profileQuery);
            $profileRow = mysqli_fetch_array($profileResult);
            session_regenerate_id();
            
            $_SESSION['connecte'] = TRUE;
            $_SESSION['mail'] = $_POST['mail'];
            $_SESSION['id'] = $id;
            $_SESSION['nom'] = $profileRow["nom"];
            $_SESSION['prenom'] = $profileRow["prenom"];
            $_SESSION['role'] = $profileRow["role"];
            $_SESSION['naissance'] = $profileRow["naissance"];
            $_SESSION['derniereConnexion'] = $profileRow["derniereConnexion"];
            $_SESSION["inscription"] = $profileRow["inscription"];

            $adresseQuery = "SELECT * FROM adresses WHERE idCompte='$id'";
            $adresseResult = mysqli_query($linkDB, $adresseQuery);
            $adresseRow = mysqli_fetch_array($adresseResult);
            if(!empty($adresseRow)) {
                $_SESSION["numero"] = $adresseRow["numero"];
                $_SESSION["rue"] = $adresseRow["rue"];
                $_SESSION["complement"] = $adresseRow["complement"];
                $_SESSION["codePostal"] = $adresseRow["codePostal"];
                $_SESSION["commune"] = $adresseRow["commune"];
            }

            $connexionQuery = "UPDATE comptes SET derniereConnexion=now() WHERE idCompte='$id'";
            $connexion = mysqli_query($linkDB, $connexionQuery);
            
            // NOUVEAU COMPTE
            if($_SESSION['derniereConnexion'] == "0000-00-00 00:00:00") {
                header('Location: ../modifProfil.php?nouveau');
            }

            header('Location: ../index.php');
        } else {
            header("Location: ../connexion.php?incorrect");
        }
    } else {
        header("Location: ../connexion.php?incorrect");
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => "404", "message" => "Not Found", "status_message" => "Not Found", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(404);
    exit();
}