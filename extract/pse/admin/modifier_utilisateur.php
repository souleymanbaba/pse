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

        $id_user = $_GET['id_user'];
        $req = mysqli_query($conn , "SELECT * FROM utilisateur WHERE id_user = $id_user");
        $row = mysqli_fetch_assoc($req);
        if(isset($_POST['button'])){ 
            $login =  test_input($_POST['login']);
            $pwd =  md5(test_input($_POST['pwd']));
            $role =  test_input($_POST['role']);

            //test_input(extract($_POST));
            echo $role;
        if( !empty($pwd)  && !empty($login) && !empty($role)){
            $req = mysqli_query($conn, "UPDATE utilisateur SET pwd = '$pwd', login = '$login', id_role = '$role'  WHERE id_user = $id_user");

            if($req){
                header("location: utilisateurs.php");
                $_SESSION['mod_reussi'] = true;
            }else {
                $message = "utilisateur non modifié";
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
                    <h4 class="card-title">Modifier un utisateur : </h4>
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
                        <input type="email" class="form-control" id="exampleInputName1" placeholder="E-mail" name="login" value="<?=$row['login']?>">
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
                      <a href="utilisateurs.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>
