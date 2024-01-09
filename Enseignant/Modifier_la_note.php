<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:../authentification.php");
 }
include_once "../connexion.php";
$id_rep=$_GET['id_etud'];
if(isset($_POST['fin'])){
    $note=$_POST['Note'];
    $sql="UPDATE `reponses` SET note=$note WHERE id_rep=$id_rep";
   if( mysqli_query($conn,$sql)){
    header("location:soumission_en_ligne.php");
   }
}

include "../nav_bar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        p {
    font-size: 18px;
    color: #333;
    font-family: Arial, sans-serif;
    color: red;
    margin-left: 700px;
}
    </style>
</head>
<body>
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                <li><a href="#">Acceuil</a></li>
                <li>Affectation du note </li>
            </ol>
        </div>
    </div>
<?php
$sql = "select * from reponses where id_rep='$id_rep' ";
$req = mysqli_query($conn,$sql);
$row= mysqli_fetch_assoc($req);
?>
<div class="form-horizontal">
    <form action="" method="POST">
        <div class="form-group">
            <label class="col-md-1">Note</label>
            <div class="col-md-6">
            <input type="float" name="Note" class = "form-control" value="<?=$row['note']?>">
        </div>
        <div class="col-md-2">
            <input type="submit" value="affecter" name="fin" class="btn-primary">
        </div>
    </form>
</div>
</div>
<br>
<br>
<br>
<p>NB : Virgule dans le nombre représentée par un point   (, = .)</p>
</body>
</html>
<?php

?>