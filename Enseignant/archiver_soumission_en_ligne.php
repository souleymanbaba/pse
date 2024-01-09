<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="ens"){
    header("location:authentification.php");
}

 include_once "../connexion.php";
 $id_sous = $_GET['id_sous'];
 $req = mysqli_query($conn , "SELECT * FROM soumission WHERE id_sous ='$id_sous'");
 $row = mysqli_fetch_assoc($req);
 $req = mysqli_query($conn, "UPDATE soumission SET   status = 2 WHERE id_sous = '$id_sous'");
 if($req){
     header('location:soumission_en_ligne.php');
     $_SESSION['archive_reussi_ligne'] = true;
 }else {
     echo "soumission non archiver";
 }
?>