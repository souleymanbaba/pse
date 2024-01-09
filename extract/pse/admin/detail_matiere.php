
<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

?>
<?php
include_once "nav_bar.php";
include_once "../connexion.php";
$id_matiere = $_GET['id_matiere'];


$req_detail = "SELECT DISTINCT id_matiere, code, matiere.libelle,
specialite, charge, nom_semestre,
nom_module FROM matiere INNER JOIN 
semestre USING(id_semestre) INNER JOIN
module USING(id_module) WHERE id_matiere = $id_matiere";
$req = mysqli_query($conn , $req_detail);
while($row=mysqli_fetch_assoc($req)){
?>

<div class="main-panel">
    <div class="content-wrapper">
    <div class="row">
            <div class="col-md-6 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <h4>Détails sur la matière <?=$row['libelle']?> : </h4>
                    <br>
                    <h4 class="font-weight-normal mb-3">
                    <?php echo "<strong class='font-weight-bold'>Code de la matiere : </strong>". $row['code']; ?><br><br>
                        <?php echo "<strong class='font-weight-bold'>Libellè : </strong>". $row['libelle']; ?><br><br>
                        <?php echo "<strong class='font-weight-bold'> Specialite : </strong>" . $row['specialite']; ?><br><br>
                        <?php echo "<strong class='font-weight-bold'> Charge de la matière : </strong>" . $row['charge']; ?><br><br>
                        <?php echo "<strong class='font-weight-bold'> Module : </strong>" . $row['nom_module']; ?><br><br>
                        <?php echo "<strong class='font-weight-bold'> Semestre : </strong>" . $row['nom_semestre']; ?><br><br>
                        
                        <?php
                        $req_detail = "SELECT DISTINCT id_matiere, groupe.libelle FROM matiere INNER JOIN groupe WHERE id_matiere = $id_matiere";
                        $req = mysqli_query($conn , $req_detail);

                        $i = 0;
                        while($row=mysqli_fetch_assoc($req)){
                          $i++;
                          if ($i === 1) {
                            echo "<strong class='font-weight-bold'> Les groupes : </strong>";
                              }
                                echo  $row['libelle'] . " ";
                        }
                            ?>
                    </h4>
                   
                  </div>
                </div>
              </div>

              <div class="col-md-6 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <h4>Le(s) enseignant(s) affecter(és) à cette matière : </h4>
                    <br>
                    <h4 class="font-weight-normal mb-3">
                    <?php
                        $req_ens_info = "SELECT *
                        FROM groupe
                        NATURAL JOIN enseigner
                        NATURAL JOIN enseignant
                        NATURAL JOIN type_matiere
                        WHERE id_matiere = $id_matiere ORDER BY nom, prenom ASC";
                        $req = mysqli_query($conn , $req_ens_info);
                        if(mysqli_num_rows($req) == 0){
                          echo "Il n'y a pas encore des enseignant affecter !" ;
                        }else{
                          $i = 0;
                          while($row=mysqli_fetch_assoc($req)){
                            $i++;
                            if ($i === 1) {
                              echo "<strong class='font-weight-bold'>  </strong>";
                                }
                                  echo  $row['nom'] ." ". $row['prenom']." ".$row['libelle']." ".$row['libelle_type']. "<br><br> ";
                          }
                            

                        }
                        ?>                    
                        </h4>
                   
                  </div>
                </div>
              </div>
              <?php
                    $req_detail = "SELECT DISTINCT id_matiere, code, matiere.libelle,
                    specialite, charge, nom_semestre,
                    nom_module FROM matiere INNER JOIN 
                    semestre USING(id_semestre) INNER JOIN
                    module USING(id_module) WHERE id_matiere = $id_matiere";
                    $req = mysqli_query($conn , $req_detail);
                    while($row=mysqli_fetch_assoc($req)){
                    ?>
                      <br>
                      <div style="display: flex ; justify-content: space-between;">
                      <a href="modifier_matiere.php?id_matiere=<?= $row['id_matiere'] ?>"  type="submit" class="btn btn-primary">Modifier</a>
                      <a href="etudiant.php" class="btn btn-light" >Retour</a>
                      </div>
            </div>
        </div>
    </div>
</div>

<?php  
    }
}
?>
