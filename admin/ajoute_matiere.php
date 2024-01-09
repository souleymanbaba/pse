<?php 
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

include_once "../connexion.php";
$semestre = "SELECT * FROM semestre ";
$semestre_qry = mysqli_query($conn, $semestre);
$module = "SELECT * FROM module";
$module_qry = mysqli_query($conn,$module);

?>
<?php
session_start();
if(count($_POST)>0)
{   include_once "../connexion.php";
     $alert1='';
     $codematieres = $_POST['codematieres'];
     $module = $_POST['module'];
     $nommatieres = $_POST['nommatieres'];
     $departement= $_POST['departement'];
     $id_semestre=$_POST['semester'];
   



if( !empty($codematieres) && !empty($nommatieres) && !empty($departement) && !empty($module)  && !empty($id_semestre)   ){
    $query= "INSERT INTO `matiere`(`code`, `libelle` ,`specialite`, `id_module`, `id_semestre`)
    VALUES ('$codematieres','$nommatieres' ,'$departement','$module','$id_semestre')";

    if (mysqli_query($conn, $query)) {
    header('location: matiere.php');
        $_SESSION['ajout_reussi'] = true;
    }else {
        $message = "matiere non ajouté";
    }

}
}

 include_once "nav_bar.php";

 ?>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ajouter matiére : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputName1">Code de Matiere</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Code de Matiere" name="codematieres">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Libellé</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="libellé" name="nommatieres">
                      </div>
                      <div class="form-group">
                        <label  >Semesters</label>
                            <select class = "form-control" id="academic" value="Semesters" name="semester">
                                <option selected disabled> Semesters </option>
                                        <?php while ($row = mysqli_fetch_assoc($semestre_qry)) : ?>
                                    <option value="<?= $row['id_semestre']; ?>"> <?= $row['nom_semestre']; ?> </option>
                                <?php endwhile; ?> 
                            </select>            
                        </div>
                        <div class="form-group">
                            <label  >Module</label>
                            <select  name="module" id="modi" class = "form-control">
                                <option selected disabled> Modules </option>
                                        <?php while ($row = mysqli_fetch_assoc($module_qry)) :?>
                                        <option value="<?= $row['id_module']; ?>"> <?= $row['nom_module']; ?> </option>  
                                    <?php endwhile;?>
                                </select>
                        </div>
                        <div class="form-group">
                            <label >deppartement</label>
                            <select class = "form-control" id="deppartement" name="departement">
                                    <option selected disabled>deppartements</option>
                                </select>
                        </div>
                        <input type="submit" name="submit" value="Enregistrer" class="btn btn-gradient-primary me-2"  />
                      <a href="matiere.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>


<script>
    function myf(){
        document.getElementById("mod").style.display = "none";
        document.getElementById("back").style.display = "inline";
        document.getElementById("add").style.display = "block";
        document.getElementById("addn").style.display = "none";
    }
    function myf1(){
        document.getElementById("mod").style.display = "block";
        document.getElementById("back").style.display = "none";
        document.getElementById("add").style.display = "none";
        document.getElementById("addn").style.display = "inline";
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // County State  
    $('#academic').on('change',function() {
        var academic_id = this.value;
        // console.log(country_id);
        $.ajax({
            url: 'departement.php',
            type: "POST",
            data: {
                academic_data: academic_id
            },
            success: function(result) {
                $('#deppartement').html(result);
                // console.log(result);
                // alert(result);
            }
        })
    });


</script>
