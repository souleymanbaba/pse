<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "admin") {
  header("location:authentification.php");
}
include_once "../connexion.php";
$searched = false;


$sql = "SELECT * FROM groupe g, departement d WHERE g.id_dep = d.id";
$req = mysqli_query($conn, $sql);
include "nav_bar.php";

?>


<!-- sweetalert2 links -->

<script src="../JS/sweetalert2.js"></script>


<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Gestion des groupes :</h4>
            <div style="display: flex ; justify-content: space-between;">
              <a href="ajouter_groupe.php" class="btn btn-primary">Nouveau</a>
              <a href="import_groupe.php" class="btn btn-primary ml-25">importer</a>
            </div>
            <br>
            <table id="example" class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Libelle</th>
                  <th>Filière</th>
                  <th>Actions</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (mysqli_num_rows($req) == 0) {
                  echo "Il n'y a pas encore des groupes ajouter !";
                } else {
                  while ($row = mysqli_fetch_assoc($req)) {
                ?>
                    <tr>
                      <td><?php echo $row['libelle']; ?></td>
                      <td><?php echo $row['nom'] . " (" . $row['code'] . ")"; ?></td>
                      <td><a href="modifier_groupe.php?id_groupe=<?= $row['id_groupe'] ?>">Modifier</a></td>
                      <td><a href="supprimer_groupe.php?id_groupe=<?= $row['id_groupe'] ?>" id="supprimer"> Supprimer</a></td>
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
        text: 'Le groupe a été ajouté avec succès.',
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
        text: 'Le groupe a été supprimer avec succès.',
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
        text: 'Le groupe a été modifier avec succès.',
        icon: 'success',
        confirmButtonColor: '#3099d6',
        confirmButtonText: 'OK'
    });
    </script>";

  // Supprimer l'indicateur de succès de la session
  unset($_SESSION['modifier_reussi']);
}

?>



<script>
  var liensArchiver = document.querySelectorAll("#supprimer");

  // Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
  liensArchiver.forEach(function(lien) {
    lien.addEventListener("click", function(event) {
      event.preventDefault();
      Swal.fire({
        title: "voulez-vous vraiment supprimé ce groupe ?",
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
          //Swal.fire({
          //   title: "Suppression réussie !",
          //   text: "L'inscription a été supprimée avec succès.",
          //   icon: "success",
          //   confirmButtonColor: "#3099d6",
          //   confirmButtonText: "OK",
          //timer: 3000, // Durée d'affichage de la boîte de dialogue en millisecondes
          //timerProgressBar: true,
          // showConfirmButton: true
          // }).then(() => {
          // Redirection après le délai
          window.location.href = this.href;
        }
      });
    });
  });
  //   });
  // });


  $(document).ready(function() {
    $('.search-text').on('input', function() {
      var search = $(this).val();
      if (search != '') {
        $.ajax({
          url: 'groupe.php',
          method: 'POST',
          data: {
            search: search
          },
          success: function(response) {
            $('tbody').html(response);
          }
        });
      } else {
        $.ajax({
          url: 'groupe.php',
          method: 'POST',
          success: function(response) {
            $('tbody').html(response);
          }
        });
      }
    });
  });
</script>