<?php
include('getapikey.php');
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
ob_start();
if(!isset($_SESSION)) {
    session_start();
}
$linkDB = mysqli_connect("mariadb","valerie","meilleursite2025","clickjourney");
if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$descQuery = "SELECT * FROM descVoyage ORDER BY idVoyage";
$descResult = mysqli_query($linkDB, $descQuery);
$desc = array();
while ($row = mysqli_fetch_assoc($descResult)) {
    $desc[$row['idVoyage']] = $row;
}

$voyageQuery = "SELECT * FROM voyage";
$voyageResult = mysqli_query($linkDB, $voyageQuery);
$voyage = array();
while ($row = mysqli_fetch_assoc($voyageResult)) {
    $voyage[$row['id']] = $row;
}

$etapesQuery = "SELECT * FROM etapes ORDER BY idVoyage, id";
$etapesResult = mysqli_query($linkDB, $etapesQuery);
$etapes = array();
while ($row = mysqli_fetch_assoc($etapesResult)) {
    $etapes[$row['idVoyage']][$row['id']] = $row;
}

$deroulQuery = "SELECT * FROM deroulVoyage ORDER BY idVoyage, jour";
$deroulResult = mysqli_query($linkDB, $deroulQuery);
$deroul = array();
while ($row = mysqli_fetch_assoc($deroulResult)) {
    $deroul[$row['idVoyage']][$row['jour']] = $row;
}

$etapeOptQuery = "SELECT * FROM etapesOpt ORDER BY idVoyage, idEtape, idOption";
$etapeOptResult = mysqli_query($linkDB, $etapeOptQuery);
while ($row = mysqli_fetch_assoc($etapeOptResult)) {
    $etapeOpt[$row['idVoyage']][$row['idEtape']][$row['idOption']] = $row;
}

$optionQuery = "SELECT * FROM options";
$optionResult = mysqli_query($linkDB, $optionQuery);
$option = array();
while ($row = mysqli_fetch_assoc($optionResult)) {
    $option[$row['id']] = $row;
}

$commandes = array();
$commandesOpt = array();
if(isset($_SESSION['id'])) {
    $commandesQuery = "SELECT * FROM commandes WHERE idCompte='{$_SESSION['id']}'";
    $commandesResult = mysqli_query($linkDB, $commandesQuery);
    while ($row = mysqli_fetch_assoc($commandesResult)) {
        $commandes[$row['id']] = $row;
    }

    $commandesOptQuery = "SELECT co.* FROM commandesOpt co JOIN commandes c ON co.idCommande = c.id WHERE c.idCompte='{$_SESSION['id']}'";
    $commandesOptResult = mysqli_query($linkDB, $commandesOptQuery);
    while ($row = mysqli_fetch_assoc($commandesOptResult)) {
        $commandesOpt[$row['idCommande']][$row['idEtape']] = $row;
    }
}


$api_key = getAPIKey("MI-1_A");
