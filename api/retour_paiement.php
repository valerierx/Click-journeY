<?php
include('linkDB.php');

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

if (mysqli_query($linkDB, $sql)) {
    if($status == "1") {
        header("Location: ../confirmation.php?succes");
    } else {
        header(header: "Location: ../confirmation.php?commande=" . $_GET['session']);
    }
}

?>