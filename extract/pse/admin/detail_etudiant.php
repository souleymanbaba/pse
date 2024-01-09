<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"] != "admin"){
    header("location:authentification.php");
}

?>

    
<?php  
include_once "nav_bar.php"; 
include_once "../connexion.php";
$id_etud = $_GET['id_etud'];


$req_detail = "SELECT * FROM etudiant INNER JOIN semestre USING(id_semestre) INNER JOIN groupe USING(id_groupe) WHERE id_etud = $id_etud";
$req = mysqli_query($conn , $req_detail);
while($row=mysqli_fetch_assoc($req)){
?>
<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
          <div class="col-md-9 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4>Détails sur l'etudiant <?= $row['nom']." ".$row['prenom']?> : </h4>
                    <br>
                    <h4 class="font-weight-normal mb-3">
                            <?php echo "<strong class='font-weight-bold'><p>Matricule : ". $row['matricule'] ."</p></strong>" ?>
                            <?php echo "<strong class='font-weight-bold'><p>Nom : </strong>". $row['nom']."</p></strong>" ?>
                            <?php echo " <strong class='font-weight-bold'>Prénom : </strong>" . $row['prenom']."</p></strong>" ?><br>
                            <?php echo "<strong class='font-weight-bold'>Date de naissance : </strong>".$row['Date_naiss']; ?><br>
                            <?php echo "<strong class='font-weight-bold'>Lieu de naissance : </strong>". $row['lieu_naiss']; ?><br>
                            <?php echo "<strong class='font-weight-bold'>E-mail : </strong>".$row['email']; ?><br>
                            <?php echo "<strong class='font-weight-bold'>Semestre : </strong>".$row['nom_semestre']; ?><br>                                                            
                            <?php echo "<strong class='font-weight-bold'>Année : </strong>".$row['annee']; ?><br>
                            <?php echo "<strong class='font-weight-bold'>Groupe : </strong>".$row['libelle']; ?>
                    </h4>
                    <p>
                    <a href="etudiant.php" class="btn btn-primary" >Retour</a>
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

</body>
</html>

