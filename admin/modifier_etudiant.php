<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:../authentification.php");
}

?>

<?php
            $id_etud = $_GET['id_etud'];

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
                $annee = test_input($_POST['annee']);
                $nom =  test_input($_POST['nom']);
                $prenom = test_input($_POST['prenom']); 
                $Date_naiss = test_input($_POST['Date_naiss']); 
                $lieu_naiss =  test_input($_POST['lieu_naiss']);
                $email =  test_input($_POST['email']);
                
            if( !empty($matricule) && !empty($semestre)  && !empty($annee) && !empty($nom) && !empty($prenom) && !empty($Date_naiss) && !empty($lieu_naiss)  && !empty($email) ){
                $req = mysqli_query($conn, "UPDATE etudiant SET  matricule = '$matricule' , id_semestre = '$semestre'  , annee = '$annee' , nom = '$nom', prenom = '$prenom', Date_naiss = '$Date_naiss', lieu_naiss = '$lieu_naiss', email = '$email' WHERE id_etud = '$id_etud'");
                if($req){
                    $_SESSION['modifier_reussi'] = true;
                    header("location: etudiant.php");
                    
                }else {
                    $message = $semestre."etudiant non modifié";
                }

            }else {
                $message = "Veuillez remplir tous les champs !";
            }
            }
            $semestre = "SELECT * FROM semestre ";
            $req = mysqli_query($conn , "SELECT * FROM etudiant inner join semestre using(id_semestre) WHERE id_etud = $id_etud");
            $row = mysqli_fetch_assoc($req);
?>

<?php 
include_once 'nav_bar.php';
?>
<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Modifier un etudiant : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputName1">Matricule</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Matricule" name="matricule" value="<?=$row['matricule']?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Nom</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Nom" name="nom" value="<?=$row['nom']?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Prénom</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Prénom" name="prenom" value="<?=$row['prenom']?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Lieu de naissance</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Lieu de naissance" name="lieu_naiss" value="<?=$row['lieu_naiss']?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date de naissance</label>
                        <input type="date" class="form-control" id="exampleInputName1" placeholder="Date de naissance" name="Date_naiss" value="<?=$row['Date_naiss']?>">
                      </div>
                        <div class="form-group">
                            <label class="col-md-1" >Semester</label>
                            <div class="col-md-6" >
                            <?php
                                    // Exécuter à nouveau la requête pour récupérer les résultats
                                    $semestre_qry = mysqli_query($conn, $semestre);
                            ?>
                            <select class = "form-control" id="academic" value="Semestres" name="semestre">
                                    <option selected disabled> Semesters </option>
                                            <?php while ($row = mysqli_fetch_assoc($semestre_qry)) : ?>
                                        <option value="<?= $row['id_semestre']; ?>"> <?= $row['nom_semestre']; ?> </option>
                                    <?php endwhile; ?> 
                                </select>            
                            </div>
                        </div>
                        <?php
                            $req = mysqli_query($conn , "SELECT * FROM etudiant inner join semestre using(id_semestre) WHERE id_etud = $id_etud");
                            $row = mysqli_fetch_assoc($req);
                        ?>
                        <div class="form-group">
                            <label for="exampleInputName1">Année</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Année" name="annee" value="<?=$row['annee']?>">
                        </div>
         
                      <div class="form-group">
                        <label for="exampleInputEmail3">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" name="email" value="<?=$row['email']?>">
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


