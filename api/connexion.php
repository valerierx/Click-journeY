<?php
include('linkDB.php');
// Check if data exists
if ( !isset($_POST['mail'], $_POST['mdp']) ) {
    // Data doesn't exist
    exit('Please fill both the email and password fields!');
}

$mail = mysqli_real_escape_string($linkDB, $_POST['mail']);
$password = mysqli_real_escape_string($linkDB, $_POST['mdp']);

$query = "SELECT * FROM login WHERE mail='$mail'";
$result = mysqli_query($linkDB, $query);
$row = mysqli_fetch_array($result);
if ($row) {
    // Account exists
    if (password_verify($_POST['mdp'], $row["motdepasse"])) {
        $id = $row['id'];
        $profileQuery = "SELECT * FROM comptes WHERE idCompte='$id'";
        $profileResult = mysqli_query($linkDB, $profileQuery);
        $profileRow = mysqli_fetch_array($profileResult);
        session_regenerate_id();
        $_SESSION['connecte'] = TRUE;
        $_SESSION['mail'] = $_POST['mail'];
        $_SESSION['id'] = $id;
        $_SESSION['nom'] = $profileRow["nom"];
        $_SESSION['prenom'] = $profileRow["prenom"];
        $_SESSION['role'] = $profileRow["role"];
        header('Location: ../index.php');
    } else {
        echo 'Incorrect email or password!';
    }
} else {
    echo 'Incorrect email or password!';
}
?>