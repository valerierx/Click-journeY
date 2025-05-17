<?php
include('linkDB.php');
$datetime = new DateTime();

if (empty($_GET['commande'])) {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(400);
    exit();
}

if (mysqli_query($linkDB, "UPDATE commandes SET paye=2  WHERE id={$_GET['commande']} AND paye=0")) {
        header("Location: ../confirmation.php?commande=" . $_GET['commande'] . "&cancel");
} else {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => "500", "message" => "Erreur serveur 1", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(500);
    exit();
}