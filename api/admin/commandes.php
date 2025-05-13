<?php
require '../linkDB.php';
$datetime = new DateTime();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json");
    $body = json_decode(file_get_contents('php://input'));
    if(!empty($body) && !empty($body->id) && isset($body->paye)) {
        $tmp = intval($body->paye);
        $paye = "UPDATE commandes SET paye='{$tmp}' WHERE id={$body->id};";
        echo $paye;
        if (mysqli_query($linkDB, $paye)) {
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
}