<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
include "nav_bar.php";
include_once "../connexion.php";


$req = mysqli_query($conn , "SELECT * FROM utilisateur inner join role using(id_role)");

?>


    <!-- sweetalert2 links -->

    <script src="../JS/sweetalert2.js"></script>


    <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Gestion des utilisateurs :</h4>
                    <div style="display: flex ; justify-content: space-between;">
                        <a href="ajouter_utilisateur.php" class = "btn btn-primary" >Nouveau</a>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered" style="width:100%">
                      <thead>
                        <tr>
                        <th>E-mail</th>
                        <th>Rôle</th>
                        <th ></th>
                        <th>Actions</th>
                        <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        if(mysqli_num_rows($req) == 0){
                            echo "Il n'y a pas encore des utilisateur ajouter !" ;
                        }else {
                            while($row=mysqli_fetch_assoc($req)){
                                ?>
                                <tr>
                                    <td><?php echo $row['login']?></td>
                                    <td><?php echo $row['profile']?></td>
                                    <td><a href="modifier_utilisateur.php?id_user=<?=$row['id_user']?>">Modifier</a></td>
                                    <td><a href="supprimer_utilisateur.php?id_user=<?=$row['id_user']?>" id="supprimer"> Supprimer</a></td>
                                    <?php
                                        if($row['active'] == 1){
                                            ?>
                                                <td><a href="activer_ou_desactiver.php?id_user=<?=$row['id_user']?>" id="desactive"> Désactiver</a></td>
                                        <?php
                                        }else{
                                            ?>
                                            <td><a href="activer_ou_desactiver.php?id_user=<?=$row['id_user']?>" id="active"> Activer</a></td>
                                        
                                        <?php
                                        }
                                    ?>                               
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
if (isset($_SESSION['ajout_user_reussi']) && $_SESSION['ajout_user_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Ajout réussi !',
        text: 'L\'utilisateur a été ajouté avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['ajout_user_reussi']);
}


if (isset($_SESSION['mod_reussi']) && $_SESSION['mod_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Modification réussi !',
        text: 'L\'utilisateur a été modifier avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['mod_reussi']);
}

// var_dump($_SESSION['desactive_reussi']);

if (isset($_SESSION['desactive_reussi']) && $_SESSION['desactive_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Désactivation réussie !',
        text: 'L'utilisateur a été désactive avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['desactive_reussi']);
}


if (isset($_SESSION['active_reussi']) && $_SESSION['active_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Activation réussie !',
        text: 'L\'utilisateur a été activer avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

    // Supprimer l'indicateur de succès de la session
    unset($_SESSION['active_reussi']);
}
if (isset($_SESSION['desactive_non_autorise']) && $_SESSION['desactive_non_autorise'] === true) {
    echo '<script>
    Swal.fire({
        title: "Désactivation non autorisée !",
        text: "Vous ne pouvez pas désactiver le compte de l\'administrateur.",
        icon: "error",
        confirmButtonColor: "#3099d6",
        confirmButtonText: "OK"
    });
    </script>';

    // Supprimer la variable de session pour éviter qu'elle ne s'affiche à nouveau lors du rechargement de la page
    unset($_SESSION['desactive_non_autorise']);
}
?>


<script>


var liensArchiver = document.querySelectorAll("#supprimer");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchiver.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment supprimé ce utilisateur ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Supprimer"
    }).then((result) => {
      if (result.isConfirmed) {
        // Afficher la deuxième boîte de dialogue pendant 1 seconde avant la redirection
        Swal.fire({
          title: "Suppression réussie !",
          text: "L'utilisateur a été supprimée avec succès.",
          icon: "success",
          confirmButtonColor: "#3099d6",
          confirmButtonText: "OK",
          //timer: 3000, // Durée d'affichage de la boîte de dialogue en millisecondes
          //timerProgressBar: true,
          showConfirmButton: true
        }).then(() => {
          // Redirection après le délai
          window.location.href = this.href;
        });
      }
    });
  });
});


var liensArchivers = document.querySelectorAll("#active");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchivers.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment activer ce utilisateur ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Active"
    }).then((result) => {

          // Redirection après le délai
          window.location.href = this.href;
        });
      })
    });



var liensArchivers = document.querySelectorAll("#desactive");

// Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
liensArchivers.forEach(function(lien) {
  lien.addEventListener("click", function(event) {
    event.preventDefault();
    Swal.fire({
      title: "Voulez-vous vraiment désactive ce utilisateur ?",
      text: "",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3099d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Annuler",
      confirmButtonText: "Désactive"
    }).then((result) => {
    
        }).then(() => {
          // Redirection après le délai
          window.location.href = this.href;
        });
      })
    });


$(document).ready(function(){
    $('.search-text').on('input', function(){
        var search = $(this).val();
        if(search != '') {
            $.ajax({
                url:'utilisateurs.php',
                method:'POST',
                data:{search:search},
                success:function(response){
                    $('tbody').html(response);
                }
            });
        } else {
            $.ajax({
                url:'utilisateurs.php',
                method:'POST',
                success:function(response){
                    $('tbody').html(response);
                }
            });
        }
    });
});


</script>

