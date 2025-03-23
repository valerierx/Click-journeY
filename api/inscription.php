<?php
include('linkDB.php');

// Check if the data exists.
if (!isset($_POST['nom'], $_POST['prenom'], $_POST['mdp'], $_POST['mdp2'], $_POST['mail'])) {
    // Data doesn't exist
    exit('Please complete the registration form!');
}
// Check if any field are empty
if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mdp']) || empty($_POST['mail'])) {
    // there is an empty field
    exit('Please complete the registration form');
}
// Check whether password and confPassword are the same or not
if ($_POST['mdp'] !== $_POST['mdp2']) {
    // passwords aren't the same
    exit("Passwords don't match");
}
// Check if email is valid
if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    // email isn't valid
    exit('Email is not valid!');
}

// Check if password is too short or long
//if (strlen($_POST['pass']) > 20 || strlen($_POST['pass']) < 5) {
    // password is too short or too long
    //exit('Password must be between 5 and 20 characters long!');
//}

// Check if email is used
if ($stmt = $linkDB->prepare('SELECT * FROM login WHERE mail = ?')) {

    $stmt->bind_param('s', $_POST['mail']);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows > 0) {
        // email already in use
        echo 'email exists, please choose another!';
    } else {
        $passwordHashed = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        $mail = $_POST['mail'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $newsletter = isset($_POST['newsletter']) && $_POST['newsletter'] == '1' ? 1 : 0;

        $query = "INSERT INTO login (mail, motdepasse) VALUES ('$mail', '$passwordHashed')";
        // email not in use, insert new account
        if (mysqli_query($linkDB, $query)) {
            // Protect password
            $id = mysqli_insert_id($linkDB);
            $profileQuery = "INSERT INTO comptes (idCompte, nom, prenom, role, newsletter) VALUES ('$id', '$nom' , '$prenom', 1, '$newsletter')";
            mysqli_query($linkDB, $profileQuery);

            // Account created, redirect to login page
            header("Location: ../index.php");
        } else {
            // Error with SQL Query
            echo 'Could not prepare statement!';
        }
    }
    $stmt->close();
} else {
    // Error with SQL Query
    echo 'Could not prepare statement!';
}
?>