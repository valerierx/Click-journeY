<?php
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