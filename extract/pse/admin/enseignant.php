
<?php
    session_start() ;
    
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
include_once "../connexion.php";
include "nav_bar.php";


$req1 = "SELECT * FROM enseignant  ORDER BY nom ASC ;";
$req = mysqli_query($conn , $req1);
?>

<div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Gestion des enseignants :</h4>
                    <div style="display: flex ; justify-content: space-between;">
                        <a href="ajouter_enseignant.php" class = "btn btn-primary" >Nouveau</a>
                        <a href="import_enseignant.php"  class="btn btn-primary ml-25">importer</a>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered" style="width:100%">
                    <thead>
                    <tr>
                    <th>Nom et Prénom</th>
                    <th>E-mail</th>
                    <th>Tel et Whatsapp</th>
                    <th></th>
                    <th >Action</th>
                    <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(mysqli_num_rows($req) == 0){
                        echo "Il n'y a pas encore des enseignant ajouter !" ;
                    }else {
                        while($row=mysqli_fetch_assoc($req)){
                            ?>
                            <tr>
                                <td><?php echo $row['nom'];?>
                                <?php echo $row['prenom'];?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['num_tel']; ?>
                                <?php echo $row['num_whatsapp']; ?></td>
                                <td><a href="detail_enseignant.php?id_ens=<?=$row['id_ens']?>">Détails</a></td>
                                <td><a href="modifier_enseignant.php?id_ens=<?=$row['id_ens']?>">Modifier</a></td>
                                <td><a href="supprimer_enseignant.php?id_ens=<?=$row['id_ens']?>" id="supprimer">Supprimer</a></td>
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

    <!-- sweetalert2 links -->

    <script src="../JS/sweetalert2.js"></script>



<?php
//if (isset($_GET['succes']) && $_GET['succes'] == 1) {

if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Ajout réussi !',
        text: 'L\'enseignant a été ajouté avec succès.',
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
        text: 'L\'enseignant a été supprimer avec succès.',
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
        text: 'L\'enseignant a été modifier avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['modifier_reussi']);
}

?>

</div>
</body>

</html>




<script>
const lienssuprumer = document.querySelectorAll("#supprimer");

lienssuprumer.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "voulez-vous vraiment supprimé ce enseignant ?",
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

   
</script>
<script>
$(document).ready(function(){
    $('.search-text').on('input', function(){
        var search = $(this).val();
        if(search != '') {
            $.ajax({
                url:'enseignant.php',
                method:'POST',
                data:{search:search},
                success:function(response){
                    $('tbody').html(response);
                }
            });
        } else {
            $.ajax({
                url:'enseignant.php',
                method:'POST',
                success:function(response){
                    $('tbody').html(response);
                }
            });
        }
    });
});
</script>