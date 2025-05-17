<?php
require 'linkDB.php';
$datetime = new DateTime();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json");
    $body = json_decode(file_get_contents('php://input'));
    if(!empty($body) || !empty($body->nom) || !empty($body->prenom) || !empty($body->naissance) || !empty($body->idCompte) || !empty($body->newsletter)) {
        $nom = mysqli_real_escape_string($linkDB, $body->nom);
        $prenom = mysqli_real_escape_string($linkDB, $body->prenom);
        $naissance = mysqli_real_escape_string($linkDB, $body->naissance);
        $rue = mysqli_real_escape_string($linkDB, $body->rue);
        $complement = mysqli_real_escape_string($linkDB, $body->complement);
        $commune = mysqli_real_escape_string($linkDB, $body->commune);
        $codePostal = mysqli_real_escape_string($linkDB, $body->codePostal);


        $tmp = intval($body->newsletter);
        $profileQuery = "UPDATE comptes SET nom='{$nom}', prenom='{$prenom}', naissance='{$naissance}' WHERE idCompte={$_SESSION["id"]};";
        $profileQuery .= "INSERT INTO adresses (idCompte, numero, rue, complement, codePostal, commune) VALUES ('{$_SESSION["id"]}', '{$body->numero}', '{$rue}', '{$complement}', '{$codePostal}', '{$commune}') ON DUPLICATE KEY UPDATE numero='{$body->numero}', rue='{$rue}', complement='{$complement}', codePostal='{$codePostal}', commune='{$commune}'";
        if (mysqli_multi_query($linkDB, $profileQuery)) {
            $_SESSION["nom"] = $body->nom;
            $_SESSION["prenom"] = $body->prenom;
            $_SESSION["naissance"] = $body->naissance;
            $_SESSION["numero"] = $body->numero;
            $_SESSION["rue"] = $body->rue;
            $_SESSION["complement"] = $body->complement;
            $_SESSION["codePostal"] = $body->codePostal;
            $_SESSION["commune"] = $body->commune;
            echo json_encode(array("status_code" => 200, "message" => "Modifié avec succès", "status_message" => "OK", "time" => $datetime->format(DateTime::ATOM)));
            http_response_code(200);
            exit();
        } else {
            header("Content-Type: application/json");
            echo json_encode(array("status_code" => 500, "message" => "Erreur BDD", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
            http_response_code(500);
            exit();
        }
    } else {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => 404, "message" => "Not Found", "status_message" => "Not Found", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(404);
    exit();
}