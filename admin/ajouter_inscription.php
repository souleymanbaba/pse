<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

include_once "../connexion.php";

$etudiant = "SELECT * FROM `etudiant` ORDER by `matricule`ASC;";
$etudiant_qry = mysqli_query($conn, $etudiant); 
$semestre = "SELECT * FROM semestre ";
$semestre_qry = mysqli_query($conn, $semestre);
$code="SELECT * FROM matiere order by code";
$code_qry = mysqli_query($conn, $code);

?>



    <?php
   
             
            function test_input($data){
                $data = htmlspecialchars($data);
                $data = trim($data);
                $data = htmlentities($data);
                $data = stripcslashes($data);

                return $data;
            }

       if(isset($_POST['button'])){
                $matricule = test_input($_POST['matricule']);
                $semestre = test_input($_POST['semestre']);
                $code =  test_input($_POST['code']);

                        echo $matricule;
                    // Vérification si l'étudiant est déjà inscrit pour cette matière dans ce semestre 
                    $verification = "SELECT * FROM inscription WHERE id_etud = '$matricule' AND id_semestre = '$semestre' AND id_matiere = '$code'";
                    $verification_qry = mysqli_query($conn, $verification);
                
                    if (mysqli_num_rows($verification_qry) > 0) {
                        // Étudiant déjà inscrit pour la matière dans le semestre donné
                        $message = "Cet étudiant est déjà inscrit à cette matière dans ce semestre.";
                } else {

                            if( !empty($matricule) && !empty($semestre)  && !empty($code)){
                                    $req = "INSERT INTO `inscription`( `id_etud`, `id_semestre`, `id_matiere`) VALUES('$matricule','$semestre','$code')";
                                                    
                                    $req = mysqli_query($conn , $req);
                                    if($req){
                                        header("location: inscription.php");
                                        //header("location: inscription.php?succes=1");
                                        $_SESSION['ajout_reussi'] = true;
                                    }else {
                                        $message = "Inscription non ajouté";
                                    }

                            }else {
                                $message = "Veuillez remplir tous les champs !";
                            }
                        }
                    }
                        include "nav_bar.php";

    ?>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ajouter inscription : </h4>
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
                            <select class = "form-control"  id="matriculeSelect" value="Matricules" name="matricule">
                                <option selected disabled> Les Matricules </option>
                                        <?php while ($row_etudiant = mysqli_fetch_assoc($etudiant_qry)) : ?>
                                    <option value="<?= $row_etudiant['id_etud']; ?>"> <?= $row_etudiant['matricule']; ?> </option>
                                <?php endwhile; ?> 
                            </select>        
                        </div>
                    </div>
                    <div class="form-group">
                        <label  >Semester</label>
                        <div class="col-md-12">
                            <!-- id="academic" -->
                            <select class = "form-control" id="semestreSelect"  value="Semestres" name="semestre">
                                <option selected disabled> Semesters </option>
                                        <?php while ($row_semestre = mysqli_fetch_assoc($semestre_qry)) : ?>
                                    <option value="<?= $row_semestre['id_semestre']; ?>"> <?= $row_semestre['nom_semestre']; ?> </option>
                                <?php endwhile; ?> 
                            </select>             
                        </div>
                    </div>
                    <div class="form-group">
                            <label >Code</label>
                            <div class="col-md-12">
                                <select class="form-control" id="matiereSelect" value="Codes" name="code">
                                    <option selected disabled> Les codes </option>
                                    <?php while ($row_code = mysqli_fetch_assoc($code_qry)) : ?>
                                    <option value="<?= $row_code['id_matiere']; ?>"> <?=" ".$row_code['libelle']; ?> </option>
                                <?php endwhile; ?>
                                </select>
                            </div>
                    </div>
                      <button type="submit" name="button" class="btn btn-gradient-primary me-2">Enregistrer</button>
                      <a href="enseignant.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>




<script>
        document.addEventListener('DOMContentLoaded', function() {
            var semestreSelect = document.getElementById('semestreSelect');
            var matiereSelect = document.getElementById('matiereSelect');

            semestreSelect.addEventListener('change', function() {
                var semestre_id = this.value;

                // Requête AJAX pour récupérer les matières du semestre sélectionné
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        matiereSelect.innerHTML = xhr.responseText;
                    }
                };
                xhr.open('GET', 'get_matiere.php?semestre_id=' + semestre_id, true);
                xhr.send();
            });
        });
    </script>