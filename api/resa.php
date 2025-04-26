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
    if (!isset($_POST['voyage'], $_POST['passengers'], $_POST['start_date'], $_POST['etape_1'])) {
        header("Content-Type: application/json");
        echo json_encode(array("status_code" => "400", "message" => "Requête incorrecte", "status_message" => "Bad Request", "time" => $datetime->format(DateTime::ATOM)));
        http_response_code(400);
        exit();
    }

    // Ajout de la commande
    $total = $voyage[$_POST["voyage"]]['prix'];
    foreach ($etapes[$_POST['voyage']] as $id => $row) {
        $total = $total + $option[$_POST["etape_".$id]]['prix'];
    }
    $etapeQuery = "";

    $commandeQuery = "INSERT INTO commandes (idCompte, idVoyage, nVoyageurs, debut, total, paye, creation) VALUES ('{$_SESSION["id"]}', '{$_POST["voyage"]}', '{$_POST["passengers"]}', '{$_POST["start_date"]}', '$total', '0', NOW())";
    if (mysqli_query($linkDB, $commandeQuery)) {
        $idCommande = mysqli_insert_id($linkDB);

        foreach ($etapes[$_POST['voyage']] as $id => $row) {
            $etapeQuery = "INSERT INTO commandesOpt (idCommande, idEtape, idOption) VALUES ('{$idCommande}', '{$id}', '{$_POST["etape_".$id]}')";
            if(!mysqli_query( $linkDB, $etapeQuery)) {
                header("Content-Type: application/json");
                echo json_encode(array("status_code" => "500", "message" => "Erreur serveur", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
                http_response_code(500);
                exit();
            };
        }

        header("Location: ../recapitulatif.php?commande=". $idCommande);
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