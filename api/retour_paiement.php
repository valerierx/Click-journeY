<?php
include('linkDB.php');
$datetime = new DateTime();
$transaction_id = $_GET['transaction'] ?? '';
$order_id = $_GET['session'] ?? '';
$status = ($_GET['status'] ?? '') === 'accepted' ? '1' : '2'; // 1=accepted, 2=denied

// 3. Basic validation
if (empty($transaction_id) || empty($order_id)) {
    die("Missing parameters");
}

// 4. Update or insert transaction
$sql = "INSERT INTO transactions (id, idCommande, status) 
        VALUES ('" . mysqli_real_escape_string($linkDB, $transaction_id) . "', 
                '" . mysqli_real_escape_string($linkDB, $order_id) . "', 
                '$status')
        ON DUPLICATE KEY UPDATE status = '$status'";

$orderQuery = "UPDATE commandes SET paye=1 WHERE id={$order_id}";

if (mysqli_query($linkDB, $sql)) {
    if($status == "1") {
        if(!mysqli_query($linkDB, $orderQuery)) {
            header("Content-Type: application/json");
            echo json_encode(array("status_code" => "500", "message" => "Erreur serveur 2", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
            http_response_code(500);
            exit();
        }
        header("Location: ../confirmation.php?commande=" . $_GET['session'] . "&transaction=" . $transaction_id . "&succes");
    } else {
        header(header: "Location: ../confirmation.php?commande=" . $_GET['session'] . "&transaction=" . $transaction_id);
    }
} else {
    header("Content-Type: application/json");
    echo json_encode(array("status_code" => "500", "message" => "Erreur serveur 1", "status_message" => "Internal Server Error", "time" => $datetime->format(DateTime::ATOM)));
    http_response_code(500);
    exit();
}

?>