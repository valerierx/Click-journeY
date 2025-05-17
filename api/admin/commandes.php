<?php
require '../linkDB.php';
$datetime = new DateTime();

function traiterMulti(false|mysqli $linkDB, string $paye, DateTime $datetime): void
{
    if (mysqli_multi_query($linkDB, $paye)) {
        echo json_encode(array("status_code" => 200, "message" => "Modifié avec succès", "status_message" => "OK", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(200);
        exit();
    } else {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 500, "message" => "Erreur BDD", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(500);
        exit();
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_SESSION["role"] != 0) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 401, "message" => "Permission non accordée", "status_message" => "Unauthorized", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(401);
        exit();
    }
    sleep(3); // délai de 3 secondes
    header("Content-Type: application/json");
    $body = json_decode(file_get_contents('php://input'));
    $paye = "";
    if(!empty($body)) {
        foreach($body as $item) {
            if(!empty($item) && !empty($item->id) && isset($item->paye)) {
                $tmp = intval($item->paye);
                $paye .= "UPDATE commandes SET paye='{$tmp}' WHERE id={$item->id};";
            } else {
                header("Content-Type: application/json");
                echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
                http_response_code(400);
                exit();
            }
        }
        traiterMulti($linkDB, $paye, $datetime);
    } else {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }

} else if($_SERVER["REQUEST_METHOD"] == "GET") {
    $commandesAdmQuery = "SELECT c.*, v.titre, co.nom, co.prenom FROM commandes c, voyage v, comptes co WHERE c.idVoyage = v.id AND c.idCompte = co.idCompte;";
    $commandesAdmResult = mysqli_query($linkDB, $commandesAdmQuery);
    while ($row = mysqli_fetch_assoc($commandesAdmResult)) {
        $commandesAdm[$row['id']] = $row;
    }

    header("Content-Type: application/json");
    $listeCmds = array();
    $last = null;
    foreach ($commandesAdm as $id => $row) {
        $listeCmds[] = new stdClass();
        $last = end($listeCmds);
        $last->id = intval($row['id']);
        $last->idVoyage = intval($row['idVoyage']);
        $last->titre = $row['titre'];
        $last->nVoyageurs = intval($row['nVoyageurs']);
        $last->paye = intval($row['paye']);
        $last->debut = $row['debut'];
        $last->total = intval($row['total']);
        $last->creation = $row['creation'];
        $last->compte = new stdClass();
        $last->compte->id = intval($row['idCompte']);
        $last->compte->nom = $row['nom'];
        $last->compte->prenom = $row['prenom'];
    }
    $json = json_encode($listeCmds);
    echo $json;
} else {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => 404, "message" => "Not Found", "status_message" => "Not Found", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(404);
    exit();
}