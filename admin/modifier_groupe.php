<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

?>
        <?php
               function test_input($data){
                $data = htmlspecialchars($data);
                $data = trim($data);
                $data = htmlentities($data);
                $data = stripcslashes($data);
                return $data;
            }  

        include_once "../connexion.php";
        $dep = "SELECT * FROM departement ";
        $dep_qry = mysqli_query($conn, $dep);


        $id_groupe = $_GET['id_groupe'];
        $req = mysqli_query($conn , "SELECT * FROM groupe g, departement d WHERE g.id_dep = d.id AND id_groupe = '$id_groupe'");
        $row = mysqli_fetch_assoc($req);


        if(isset($_POST['button'])){ 
        
        $libelle = test_input($_POST['libelle']);
        $filiere = test_input($_POST['Filiere']); 
        
        if( !empty($libelle) && !empty($filiere) ){
            $req = mysqli_query($conn, "UPDATE groupe SET  libelle = '$libelle', 
            id_dep = '$filiere' WHERE  id_groupe = $id_groupe");
            if($req){
                //header("Location: groupe.php");
                echo "<script>window.location.href='groupe.php';</script>";
                $_SESSION['modifier_reussi'] = true;

            }else {
                $message = "groupe non modifié";
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
                    <h4 class="card-title">Modifier un groupe : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                            <label >Libellé</label>
                            <div class="col-md-12">
                                <input type="text" name="libelle" class = "form-control" value="<?=$row['libelle']?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label >Filiére</label>
                            <div class="col-md-12">
                            <select class = "form-control" id="academic" value="Filiere" name="Filiere">
                                    <option selected disabled> Filiére </option>
                                            <?php while ($row = mysqli_fetch_assoc($dep_qry)) : ?>
                                        <option value="<?= $row['id']; ?>"> <?= $row['nom']; ?> </option>
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

