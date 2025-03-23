<?php
ob_start();
// Set sessions
if(!isset($_SESSION)) {
    session_start();
}
// Open a new connection to the MySQL server
$linkDB = mysqli_connect("mariadb","valerie","meilleursite2025","clickjourney");
if ( mysqli_connect_errno() ) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
/* Vérification de la connexion */
/* Fermeture de la connexion */
?>