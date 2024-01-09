<?php
session_start();
if(count($_POST)>0)
{   include_once "../connexion.php";
     $alert1='';
     $codematieres = $_POST['codematieres'];
     $module = $_POST['module'];
     $nommatieres = $_POST['nommatieres'];
     $departement= $_POST['departement'];
     $id_semestre=$_POST['semester'];
   
   $query= "INSERT INTO `matiere`(`code`, `libelle` ,`specialite`, `id_module`, `id_semestre`)
     VALUES ('$codematieres','$nommatieres' ,'$departement','$module','$id_semestre')";
 
     if (mysqli_query($conn, $query)) {
        $msg = 1;
        $_SESSION['alert']=$msg;
        
     } else {
        $msg = 4;
     }
}
  
 header ("Location: matiere.php");
 ?>