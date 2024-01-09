<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

  include_once "../connexion.php";
  $id_groupe= $_GET['id_groupe'];
  $req = mysqli_query($conn , "DELETE FROM groupe WHERE id_groupe = $id_groupe");
  header("Location:groupe.php");
  $_SESSION['supp_reussi'] = true;
?>