<?php
require 'linkDB.php';
if($_SERVER["REQUEST_METHOD"] == "GET") {
    header("Content-Type: application/json");
    $listeOptions = array();
    if(isset($_GET["id"])){
        foreach ($etapes[$_GET['id']] as $id => $row) {
            $listeOptions[$id] = array();
            foreach ($etapeOpt[$_GET['id']][$id] as $idOpt => $row2) {
                $optionData = $option[$row2['idOption']];
                $optionData['id'] = intval($optionData['id']);
                $optionData["prix"] = intval($optionData['prix']);
                $optionData["personnesMax"] = intval($optionData["personnesMax"]);
                $listeOptions[$id][] = $optionData;
            }
        }
        $json = json_encode($listeOptions);
        echo $json;

    } else {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }
}