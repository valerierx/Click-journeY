<?php
require '../linkDB.php';
$datetime = new DateTime();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json");
    $body = json_decode(file_get_contents('php://input'));
    if(!empty($body) || !empty($body->nom) || !empty($body->prenom) || !empty($body->naissance) || !empty($body->idCompte) || !empty($body->newsletter)) {
        $tmp = intval($body->newsletter);
        $profileQuery = "UPDATE comptes SET nom='{$body->nom}', prenom='{$body->prenom}', naissance='{$body->naissance}', newsletter='{$tmp}'  WHERE idCompte={$body->idCompte};";
        $profileQuery .= "UPDATE login SET mail='{$body->mail}' WHERE id={$body->idCompte};";
        if (mysqli_multi_query($linkDB, $profileQuery)) {
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