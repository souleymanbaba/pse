<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}

include "nav_bar.php";

include_once "../connexion.php";

$req = mysqli_query($conn , "SELECT * FROM semestre
 INNER JOIN inscription ON inscription.id_semestre = semestre.id_semestre 
 INNER JOIN matiere ON inscription.id_matiere = matiere.id_matiere INNER JOIN 
  etudiant ON inscription.id_etud = etudiant.id_etud ;");
?>

<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Gestion des etudiant :</h4>
                    <div style="display: flex ; justify-content: space-between;">
                        <a href="ajouter_inscription.php" class = "btn btn-primary" >Nouveau</a>
                        <a href="importe_inscription.php"  class="btn btn-primary ml-25">importer</a>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                    <tr>
                    <th>Matricule de l'etudiant</th>
                    <th>Code matiere</th>
                    <th>Semestre</th>
                    <th>Actions</th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                            if(mysqli_num_rows($req) == 0){
                                echo "Il n'y a pas encore  des inscriptions ajouter !" ;
                                
                            }else {
                                while($row=mysqli_fetch_assoc($req)){
                                    ?>
                                    <tr>
                                    <td><?php echo $row['matricule']; ?></td>
                                    <td><?php echo $row['code']; ?></td>
                                    <td><?php echo $row['nom_semestre']; ?></td>
                                    <td><a href="modifier_inscription.php?id_insc=<?=$row['id_insc']?>">Modifier</a></td>
                                    <td><a href="supprimer_inscription.php?id_insc=<?=$row['id_insc']?>" id="supprimer"> Supprimer</a></td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<?php
//if (isset($_GET['succes']) && $_GET['succes'] == 1) {

if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Ajout réussi !',
        text: 'L\'inscription a été ajouté avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['ajout_reussi']);
}


if (isset($_SESSION['supp_reussi']) && $_SESSION['supp_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Suppression réussi !',
        text: 'L\'inscription a été supprimer avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['supp_reussi']);
}


if (isset($_SESSION['modifier_reussi']) && $_SESSION['modifier_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Modification réussi !',
        text: 'L\'inscription a été modifier avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['modifier_reussi']);
}

if (isset($_SESSION['import_reussi']) && $_SESSION['import_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Importation réussi !',
        text: 'Le(s) inscription(s) a été importer avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['import_reussi']);
}

?>



<script>




var liensArchiver = document.querySelectorAll("#supprimer");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchiver.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment supprimer cette inscription ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Supprimer"
    }).then((result) => {
      if (result.isConfirmed) {

            window.location.href = this.href;
            }
        });
      });
    });

$(document).ready(function(){
    $('.search-text').on('input', function(){
        var search = $(this).val();
        if(search != '') {
            $.ajax({
                url:'inscription.php',
                method:'POST',
                data:{search:search},
                success:function(response){
                    $('tbody').html(response);
                }
            });
        } else {
            $.ajax({
                url:'inscription.php',
                method:'POST',
                success:function(response){
                    $('tbody').html(response);
                }
            });
        }
    });
});
   
</script>
