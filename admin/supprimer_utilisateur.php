<?php
  include_once "../connexion.php";
  $id_user= $_GET['id_user'];
  $req = mysqli_query($conn , "DELETE FROM utilisateur WHERE id_user = $id_user");
  header("Location:utilisateurs.php")
?>