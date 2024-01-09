<title>Modifier enseignant</title>

<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

?>
<?php
        include_once "../connexion.php";
        $id_ens = $_GET['id_ens'];
        $req = mysqli_query($conn , "SELECT * FROM enseignant WHERE id_ens = $id_ens");
        $row = mysqli_fetch_assoc($req);


        if(isset($_POST['button'])){ 
        extract($_POST);
        if( !empty($nom) && !empty($prenom) && !empty($Date_naiss) && !empty($lieu_naiss)  && !empty($email) && !empty($numtel) && !empty($diplome) && !empty($grade)  ){
            $req = mysqli_query($conn, "UPDATE enseignant SET   nom = '$nom', prenom = '$prenom', Date_naiss = '$Date_naiss', lieu_naiss = '$lieu_naiss', `email` = '$email', `num_tel` = '$numtel', `num_whatsapp` = '$numwhatsapp', diplome = '$diplome', grade = '$grade' WHERE id_ens = $id_ens");
            if($req){
                header('location:enseignant.php');
                $_SESSION['modifier_reussi'] = true;
            }else {
                $message = "enseignant non modifié";
            }

        }else {
            $message = "Veuillez remplir tous les champs !";
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
                    <h4 class="card-title">Modifier un enseignants : </h4>
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
                      <div class="form-group">
                        <label for="exampleInputEmail3">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" name="email" value="<?=$row['email']?>">
                      </div>
                      <div class="form-group">
                            <label for="exampleInputName1">Numéro de téléphone</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Numéro de téléphone" name="numtel" value="<?=$row['num_tel']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Numéro de WhatsApp</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Numéro de WhatsApp" name="numwhatsapp" value="<?=$row['num_whatsapp']?>">
                        </div>  <div class="form-group">
                            <label for="exampleInputName1">Diplôme</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Diplôme" name="diplome" value="<?=$row['diplome']?>">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Grade</label>
                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Grade" name="grade" value="<?=$row['grade']?>">
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







