<?php
ob_start();
if(!isset($_SESSION)) {
    session_start();
}
$linkDB = mysqli_connect("mariadb","valerie","meilleursite2025","clickjourney");
if ( mysqli_connect_errno() ) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
