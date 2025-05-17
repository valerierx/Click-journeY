<?php
require '../linkDB.php';
$datetime = new DateTime();
/*if($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_SESSION["role"] != 0) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 401, "message" => "Permission non accordée", "status_message" => "Unauthorized", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(401);
        exit();
    }
    header("Content-Type: application/json");
    $body = json_decode(file_get_contents('php://input'));
    if(!empty($body) || !empty($body->nom) || !empty($body->prenom) || !empty($body->naissance) || !empty($body->idCompte) || !empty($body->newsletter)) {
        $tmp = intval($body->newsletter);
        $profileQuery = "UPDATE comptes SET nom='{$body->nom}', prenom='{$body->prenom}', naissance='{$body->naissance}'  WHERE idCompte={$body->idCompte};";
        $profileQuery .= "UPDATE login SET mail='{$body->mail}' WHERE id={$body->idCompte};";
        traiterMulti($linkDB, $profileQuery, $datetime);
    } else {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }
} else */
if($_SERVER["REQUEST_METHOD"] == "GET") {
    sleep(1);
    if($_SESSION["role"] != 0) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 401, "message" => "Permission non accordée", "status_message" => "Unauthorized", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(401);
        exit();
    }
    //  idCompte 	nom 	prenom 	role 	newsletter 	naissance 	inscription 	derniereConnexion 	mail
    $compteQuery = "SELECT c.*, l.mail FROM comptes c, login l WHERE l.id = c.idCompte;";
    $compteResult = mysqli_query($linkDB, $compteQuery);
    while ($row = mysqli_fetch_assoc($compteResult)) {
        $comptes[$row['idCompte']] = $row;
    }

    header("Content-Type: application/json");
    $listeComptes = array();
    $last = null;
    foreach ($comptes as $id => $row) {
        $listeComptes[] = new stdClass();
        $last = end($listeComptes);
        $last->id = intval($row['idCompte']);
        $last->mail = $row['mail'];
        $last->nom = $row['nom'];
        $last->prenom = $row['prenom'];
        $last->role = intval($row['role']);
        $last->newsletter = boolval($row['newsletter']);
        $last->naissance = $row['naissance'];
        $last->inscription = $row['inscription'];
        $last->derniereConnexion = $row['derniereConnexion'];

    }
    $json = json_encode($listeComptes);
    echo $json;
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_SESSION["role"] != 0) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => 401, "message" => "Permission non accordée", "status_message" => "Unauthorized", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(401);
        exit();
    }
    header("Content-Type: application/json");
    $body = json_decode(file_get_contents('php://input'));
    $roleQuery = "";
    if(!empty($body)) {
        foreach($body as $item) {
            if(!empty($item) && !empty($item->id) && isset($item->role)) {
                $tmp = intval($item->role);
                $roleQuery .= "UPDATE comptes SET role='{$tmp}' WHERE idCompte={$item->id};";
            } else {
                header("Content-Type: application/json");
                echo json_encode(array("status_code" => 400, "message" => "Fausse requête", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
                http_response_code(400);
                exit();
            }
        }
        sleep(3);

        traiterMulti($linkDB, $roleQuery, $datetime);
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