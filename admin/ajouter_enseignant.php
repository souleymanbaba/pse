<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
?>

<?php

    include_once "../connexion.php";
    function test_input($data){
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = htmlentities($data);
    $data = stripcslashes($data);

    return $data;
    }
    if(isset($_POST['button'])){
    $nom = test_input($_POST['nom']); 
    $prenom = test_input($_POST['prenom']); 
    $Date_naiss = test_input($_POST['Date_naiss']); 
    $lieu_naiss =  test_input($_POST['lieu_naiss']);
    $email =  test_input($_POST['email']);
    $numtel =  test_input($_POST['numtel']);
    $numwhatsapp =  test_input($_POST['numwhatsapp']);
    $diplome =  test_input($_POST['diplome']);
    $grade =  test_input($_POST['grade']);
        
        if( !empty($nom) && !empty($prenom) && !empty($Date_naiss) && !empty($lieu_naiss)  && !empty($email) && !empty($numtel) && !empty($diplome) && !empty($grade)  ){
            $req = "INSERT INTO `enseignant`(`nom`, `prenom`, `Date_naiss`, `lieu_naiss`, `email`,`num_tel`,`num_whatsapp`, `diplome`, `grade`, `id_role`) values ('$nom','$prenom','$Date_naiss', '$lieu_naiss' ,'$email' ,'$numtel' ,'$numwhatsapp' , '$diplome', '$grade', 2)";
        
            if(mysqli_query($conn , $req)){
                header('location:enseignant.php');
                $_SESSION['ajout_reussi'] = true;
            }else {
                $message = "Enseignant non ajouté";
            }

        }
  }
?>

<?php
   include "nav_bar.php"; 
?>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ajouter un enseignant : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputName1">Nom</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Nom" name="nom">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Prénom</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Prénom" name="prenom">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Lieu de naissance</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Lieu de naissance" name="lieu_naiss">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Date de naissance</label>
                        <input type="date" class="form-control" id="exampleInputName1" placeholder="Date de naissance" name="Date_naiss">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" name="email">
                      </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Numéro de téléphone</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Numéro de téléphone" name="numtel">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Numéro de WhatsApp</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Numéro de WhatsApp" name="numwhatsapp">
                        </div>  <div class="form-group">
                            <label for="exampleInputName1">Diplôme</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Diplôme" name="diplome">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Grade</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Grade" name="grade">
                        </div>
                      <button type="submit" name="button" class="btn btn-gradient-primary me-2">Enregistrer</button>
                      <a href="enseignant.php" class="btn btn-light">Annuler</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>
