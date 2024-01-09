<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }
 $id_sous = $_GET['id_sous'];
 $id_matiere = $_GET['id_matiere'];
 $color = $_GET['color'];
 $id_semestre = $_GET['id_semestre'];

 include_once "../connexion.php";
 $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
 $req3 = mysqli_query($conn , $req_detail3);
 if(   mysqli_num_rows($req3) > 0 ){
    $_SESSION['id_sous'] = $id_sous;
    header("location:reponse_etudiant.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
 }
 else{
    $_SESSION['id_sous'] = $id_sous;
    header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
    $_SESSION['temp_fin'] = true;
 }
