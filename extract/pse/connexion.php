<?php
$servername = "localhost";
$username = "chahztvt_chahztvt_test";
$password = "3991Eyem";
$dbname = "chahztvt_pse1";

// Connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("La connexion a échoué : " . mysqli_connect_error());
}
