<?php
include('linkDB.php');
$datetime = new DateTime();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification du formulaire
    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['mdp'], $_POST['mdp2'], $_POST['mail'])) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "400", "message" => "Requête incorrecte", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }
    if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mdp']) || empty($_POST['mail'])) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "400", "message" => "Requête incorrecte (remplissez tous les champs)", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }
    // Vérification du mot de passe
    if ($_POST['mdp'] !== $_POST['mdp2']) {
        http_response_code(400);
        exit("Les mots de passe sont différents");
    }
    // Check if email is valid
    if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        header("Location: ../inscription.php?mail");
    }


    if ($stmt = $linkDB->prepare('SELECT * FROM login WHERE mail = ?')) {

        $stmt->bind_param('s', $_POST['mail']);
        $stmt->execute();
        $stmt->store_result();


        if ($stmt->num_rows > 0) {
            // mail déjà utilisé
            header("Location: ../inscription.php?mail");
        } else {
            $passwordHashed = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
            $mail = mysqli_real_escape_string($linkDB, $_POST['mail']);
            $prenom = mysqli_real_escape_string($linkDB, $_POST['prenom']);
            $nom = mysqli_real_escape_string($linkDB, $_POST['nom']);
            $newsletter = isset($_POST['newsletter']) && $_POST['newsletter'] == '1' ? 1 : 0;

            $query = "INSERT INTO login (mail, motdepasse) VALUES ('$mail', '$passwordHashed')";
            // nouvelle adresse mail, création du compte
            if (mysqli_query($linkDB, $query)) {
                // Protect password
                $id = mysqli_insert_id($linkDB);
                $profileQuery = "INSERT INTO comptes (idCompte, nom, prenom, role, newsletter, naissance, inscription, derniereConnexion) VALUES ('$id', '$nom' , '$prenom', 1, '$newsletter', '1879-10-26', NOW(), '0000-00-00 00:00:00')";
                mysqli_query($linkDB, $profileQuery);

                header("Location: ../connexion.php?nvcompte");
            } else {
                header("Content-Type: application/json");
                echo json_encode(array("status_code" => "500", "message" => "Erreur serveur", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
                http_response_code(500);
                exit();
            }
        }
        $stmt->close();
    } else {
        // Erreur SQL
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "500", "message" => "Erreur serveur", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(500);
        exit();
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => "404", "message" => "Not Found", "status_message" => "Not Found", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(404);
    exit();
}