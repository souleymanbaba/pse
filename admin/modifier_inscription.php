<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

?>

<?php
            $id_insc = $_GET['id_insc'];

            function test_input($data){
                $data = htmlspecialchars($data);
                $data = trim($data);
                $data = htmlentities($data);
                $data = stripcslashes($data);

                return $data;
            }

            include_once "../connexion.php";
            if(isset($_POST['button'])){ 
                $matricule = test_input($_POST['matricule']);
                $semestre = test_input($_POST['semestre']);
                $code =  test_input($_POST['code']);
                
            if( !empty($matricule) && !empty($semestre) && !empty($code) ){
                $req = mysqli_query($conn, "UPDATE inscription SET  id_etud = '$matricule' , id_semestre = '$semestre'  ,id_matiere = '$code' WHERE id_insc = '$id_insc'");
                if($req){
                    header("location: inscription.php");
                    $_SESSION['modifier_reussi'] = true;
                }else {
                    $message = $semestre."Inscription non modifié";
                }

            }else {
                $message = "Veuillez remplir tous les champs !";
            }
            }
            include "nav_bar.php";
            $semestre = "SELECT * FROM semestre ";
            $req = mysqli_query($conn , "SELECT * FROM etudiant inner join semestre using(id_semestre) WHERE id_etud = $id_insc");
            $row = mysqli_fetch_assoc($req);

                        
            $etudiant = "SELECT * FROM etudiant";
            $etudiant_qry = mysqli_query($conn, $etudiant); 
            $semestre = "SELECT * FROM semestre ";
            $semestre_qry = mysqli_query($conn, $semestre);
            $matiere = "SELECT * FROM matiere ";
            $matiere_qry = mysqli_query($conn, $matiere);

?>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Modifier une inscription : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                            <label >Matricule</label>
                            <div class="col-md-12">
                            <select class = "form-control" id="academic" value="Matricules" name="matricule">
                                    <option selected disabled> Matricules </option>
                                            <?php while ($row_etudiant = mysqli_fetch_assoc($etudiant_qry)) : ?>
                                        <option value="<?= $row_etudiant['id_etud']; ?>"> <?= $row_etudiant['matricule']; ?> </option>
                                    <?php endwhile; ?> 
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label  >Semester</label>
                            <div class="col-md-12" >
                            <?php
                                    // Exécuter à nouveau la requête pour récupérer les résultats
                                    $semestre_qry = mysqli_query($conn, $semestre);
                            ?>
                            <select class = "form-control" id="academic" value="Semestres" name="semestre">
                                    <option selected disabled> Semesters </option>
                                            <?php while ($row_semestre = mysqli_fetch_assoc($semestre_qry)) : ?>
                                        <option value="<?= $row_semestre['id_semestre']; ?>"> <?= $row_semestre['nom_semestre']; ?> </option>
                                    <?php endwhile; ?> 
                                </select>            
                            </div>
                        </div>
                        <?php
                            $req = mysqli_query($conn , "SELECT * FROM etudiant inner join semestre using(id_semestre) WHERE id_etud = $id_insc");
                            $row = mysqli_fetch_assoc($req);
                        ?>
                    
                        <div class="form-group">
                            <label  >Code</label>
                            <div class="col-md-12" >
                                <select class = "form-control" id="academic" value="Code" name="code">
                                    <option selected disabled> Codes </option>
                                            <?php while ($row_matiere = mysqli_fetch_assoc($matiere_qry)) : ?>
                                        <option value="<?= $row_matiere['id_matiere']; ?>"> <?= $row_matiere['code']; ?> </option>
                                    <?php endwhile; ?> 
                                </select> 
                            </div>
                        </div>
                        <button type="submit" name="button" class="btn btn-gradient-primary me-2">Enregistrer</button>
                        <a href="etudiant.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>

