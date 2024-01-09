<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"] != "admin"){
    header("location:authentification.php");
}
include_once "../connexion.php";
$id_user= $_GET['id_user'];

$sql_condition = "SELECT * FROM utilisateur WHERE id_user = $id_user AND active = 1" ;
$req_condition = mysqli_query($conn, $sql_condition);


$sql_role = "SELECT id_role FROM utilisateur WHERE id_user = $id_user";
$req_role = mysqli_query($conn, $sql_role);
$row_role = mysqli_fetch_assoc($req_role);
$role = $row_role['id_role'];

// Vérifier que l'utilisateur n'est pas un administrateur (rôle 1)
if ($role != 1) {

      if(mysqli_num_rows($req_condition) > 0){

        $sql2="UPDATE utilisateur SET utilisateur.active = 0 WHERE `utilisateur`.`id_user`= $id_user";
        $req1=mysqli_query($conn,$sql2);
        if($req1){
            header("location:utilisateurs.php");
            $_SESSION['desactive_reussi'] = true;
        }
    }else{
          
        $sql2= "UPDATE utilisateur SET utilisateur.active = 1 WHERE `utilisateur`.`id_user`= $id_user";
        $req1=mysqli_query($conn,$sql2);
        if($req1){
            header("location:utilisateurs.php");
            $_SESSION['active_reussi'] = true;
        }
    }

  
} else {
    header("location: utilisateurs.php");
    $_SESSION['desactive_non_autorise'] = true;
}


?>