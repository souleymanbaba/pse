<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
 
include "nav_bar.php"; 
include_once "../connexion.php";
$id_ens = $_GET['id_ens'];
$req_detail = "SELECT * FROM enseignant WHERE id_ens = $id_ens";
$req = mysqli_query($conn , $req_detail);
while($row=mysqli_fetch_assoc($req)){
?>



<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
            <div class="col-md-8 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <h4>Détails sur l'etudiant <?= $row['nom']." ".$row['prenom']?> : </h4>
                    <br>
                    <h4 class="font-weight-normal mb-3">
                    <?php echo "<strong class='font-weight-bold'>Nom : </strong>". $row['nom']; ?><br>
                    <?php echo " <strong class='font-weight-bold'>Prenom : </strong>" . $row['prenom']; ?>
                    <br><?php echo "<strong class='font-weight-bold'>Date de naissance : </strong>".$row['Date_naiss']; ?><br>
                    <?php echo "<strong class='font-weight-bold'>Lieu de naissance : </strong>". $row['lieu_naiss']; ?><br>
                    <?php echo "<strong class='font-weight-bold'>E-mail : </strong>".$row['email']; ?><br>
                    <?php echo "<strong class='font-weight-bold'>Numéro de téléphone : </strong>".$row['num_tel']; ?><br>
                    <?php echo "<strong class='font-weight-bold'>Numéro de WhatsApp : </strong>".$row['num_whatsapp']; ?><br>
                    <?php echo "<strong class='font-weight-bold'>Diplôme : </strong>".$row['diplome']; ?><br>
                    <?php echo "<strong class='font-weight-bold'>Grade : </strong>".$row['grade']; ?><br>

                    </h4>
                    <p>
                    <a href="etudiant.php" class="btn btn-light" >Retour</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<?php   
}
?>
