<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
 

include_once "../connexion.php";

$roles = "SELECT * FROM role";
$roles_qry = mysqli_query($conn, $roles);

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
                   $login =  test_input($_POST['login']);
                   $pwd =  md5(test_input($_POST['pwd']));
                   $role =  test_input($_POST['role']);
                   
           if(  !empty($login)  && !empty($pwd)  && !empty($role) ){

                $req = "INSERT INTO utilisateur (`login`,`pwd`,`active`,`id_role`)VALUES
                                        ('$login','$pwd',1,'$role')";

                $req = mysqli_query($conn , $req);
                if($req){
                    header("location: utilisateurs.php");
                    $_SESSION['ajout_user_reussi'] = true;
                }else {
                    $message = "utilisateur non ajouté";
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
                    <h4 class="card-title">Ajouter utilisateur : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputName1">E-mail</label>
                        <input type="email" class="form-control" id="exampleInputName1" placeholder="E-mail" name="login">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Mot de passe</label>
                        <input type="password" name="pwd" class="form-control" id="exampleInputName1" placeholder="Mot de passe" >
                      </div>
                        <div class="form-group">
                            <label  >Role</label>
                            <div class="col-md-12" >
                                <select  name="role" id="modi1" class = "form-control">
                                    <option selected disabled> Rôles</option>
                                    <?php while ($row_role = mysqli_fetch_assoc($roles_qry)) : ?>
                                        <option value="<?= $row_role['id_role']; ?>"> <?= $row_role['profile']; ?> </option>
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
