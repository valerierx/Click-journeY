<?php
include('linkDB.php');
$datetime = new DateTime();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Utilisateur non connecté
    if (!isset($_SESSION['id'])) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "401", "message" => "", "status_message" => "Unauthorized", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(401);
        exit();
    }
    // Vérification du formulaire
    if (!isset($_POST['nom'], $_POST['prenom'], $_POST['naissance'], $_POST['rue'], $_POST['codePostal'], $_POST['commune'])) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "400", "message" => "Requête incorrecte", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }

    $profileQuery = "UPDATE comptes SET nom='{$_POST['nom']}', prenom='{$_POST['prenom']}', naissance='{$_POST['naissance']}' WHERE idCompte={$_SESSION['id']}";

    // mise à jour du profil utilisateur dans la BDD
    if (mysqli_query($linkDB, $profileQuery)) {
        $adresseQuery = "INSERT INTO adresses (idCompte, numero, rue, complement, codePostal, commune) VALUES ('{$_SESSION["id"]}', '{$_POST["numero"]}', '{$_POST["rue"]}', '{$_POST["complement"]}', '{$_POST["codePostal"]}', '{$_POST["commune"]}') ON DUPLICATE KEY UPDATE numero='{$_POST["numero"]}', rue='{$_POST["rue"]}', complement='{$_POST["complement"]}', codePostal='{$_POST["codePostal"]}', commune='{$_POST["commune"]}'";
        if (mysqli_query($linkDB, $adresseQuery)) {
            $_SESSION["nom"] = $_POST["nom"];
            $_SESSION["prenom"] = $_POST["prenom"];
            $_SESSION["naissance"] = $_POST["naissance"];
            $_SESSION["numero"] = $_POST["numero"];
            $_SESSION["rue"] = $_POST["rue"];
            $_SESSION["complement"] = $_POST["complement"];
            $_SESSION["codePostal"] = $_POST["codePostal"];
            $_SESSION["commune"] = $_POST["commune"];

            header("Location: ../profil.php?succes");
        } else {
            header("Content-Type: application/json");
            echo json_encode(array("status_code" => "500", "message" => "Erreur serveur", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
            http_response_code(500);
            exit();
        }
    } else {
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