<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<br><br><br>
<?php 
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }
  
include "../nav_bar.php";

?>
</br></br></br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
            <li><a href="#">Acceuil</a></li>
            <li>Reclemation</li>
            </ol>
        </div>
    </div>
<form action="" method="POST" >
        <div class="form-group">
            <label class="col-md-1">Description </label>
            <div class="col-md-6">
                <textarea name="description_sous" id="" class = "form-control" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="form-group">
            
                    <div class="col-md-offset-2 col-md-10">
                    <br>
        <br>
                        <input type="submit" name="button" value="Reclamer" class="btn-primary" />
                    </div>
                </div>
</form>
</div>
</body>
</html>