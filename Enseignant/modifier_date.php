<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:authentification.php");
 }
 include_once "../connexion.php";
 $id_sous = $_GET['id_sous'];
 if(isset($_POST['fin'])){
        $date_fin = $_POST['date_fin'];
        $req = mysqli_query($conn, "UPDATE soumission set date_fin='$date_fin' WHERE id_sous = '$id_sous'");
        if($req){
            header('location:soumission_en_ligne.php');
            }else {
            $message = "Soumission non modifié";
            }
        }
    include "../nav_bar.php";
    

?>

</br></br></br>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 
            <ol class="breadcrumb">
                <li><a href="#">Acceuil</a></li>
                <li>Les soumissions en ligne</li>
                   
            </ol>
        </div>
    </div>
<div class="form-horizontal">
    <?php
    $req = mysqli_query($conn,"select * from soumission where id_sous = '$id_sous'");
    $row = mysqli_fetch_assoc($req);
    ?>
    <form action="" method="POST">
        <div class="form-group">
            <label class="col-md-1">Date fin</label>
            <div class="col-md-6">
                <input type="datetime-local" name="date_fin" class = "form-control" value="<?=$row['date_fin']?>">
        </div>
        <div class="col-md-2">
                <input type="submit" value="Modifier" name="fin" class="btn-primary">
        </div>
    </form>
</div>
</div>
