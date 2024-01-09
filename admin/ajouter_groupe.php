<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
?>

<?php
        include_once "../connexion.php";
        $dep = "SELECT * FROM departement ";
        $dep_qry = mysqli_query($conn, $dep);

    function test_input($data){
            $data = htmlspecialchars($data);
            $data = trim($data);
            $data = htmlentities($data);
            $data = stripcslashes($data);
            return $data;
        }
    if(isset($_POST['button'])){
    $libelle = test_input($_POST['libelle']);
    $filiere = test_input($_POST['Filiere']); 
        if( !empty($libelle) && !empty($filiere) ){
            $req = mysqli_query($conn , "INSERT INTO groupe(`libelle`, `id_dep`) VALUES('$libelle', '$filiere')");
            if($req){
                header("location: groupe.php");
                $_SESSION['ajout_reussi'] = true;
            }else {
                $message = "groupe non ajouté";
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
                    <h4 class="card-title">Ajouter  groupe : </h4>
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
                                <input type="text" name="libelle" class = "form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  >Filiére</label>
                            <div class="col-md-12">
                            <select class = "form-control" id="academic" value="Filiere" name="Filiere">
                                    <option selected disabled> Semesters </option>
                                            <?php while ($row = mysqli_fetch_assoc($dep_qry)) : ?>
                                        <option value="<?= $row['id']; ?>"> <?= $row['nom']; ?> </option>
                                    <?php endwhile; ?> 
                                </select>   
                            </div>
                        </div>
                      <button type="submit" name="button" class="btn btn-gradient-primary me-2">Enregistrer</button>
                      <a href="groupe.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>

