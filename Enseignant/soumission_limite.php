<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
  header("location:../authentification.php");
}
?>
<title>Les Soumissions terminées</title>
<style>
  /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
  tr:hover {
    cursor: pointer;
    background-color: aliceblue;
  }
</style>

<?php
include "nav_bar.php";

$ens = "SELECT DISTINCT matiere.* FROM matiere 
INNER JOIN soumission ON soumission.id_matiere = matiere.id_matiere ";
$matiere_filtre_qry = mysqli_query($conn, $ens);

$type_sous = "SELECT * FROM type_soumission";
$type_sous_qry = mysqli_query($conn, $type_sous);

$req_sous =  "SELECT DISTINCT soumission.*, matiere.* FROM soumission , matiere, enseignant WHERE  soumission.id_ens=enseignant.id_ens AND soumission.id_matiere=matiere.id_matiere and  status = 1  and matiere.id_matiere IN (SELECT enseigner.id_matiere FROM enseigner, enseignant WHERE enseigner.id_ens=enseignant.id_ens and enseignant.email='$email')  ORDER BY date_fin DESC  ";
$req = mysqli_query($conn, $req_sous);
?>
<div class="content-wrapper">
    <div class="content">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-calendar-clock"></i>
            </span> Soumission / Soumissions terminées 
            </h3>
        </div>

    <div class="content">
        <div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Les Soumissions terminées :</h4>
        <br>
        <table id="example" class="table table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>Code</th>
              <th>Titre </th>
              <th>Date de début </th>
              <th>Date de fin </th>
              <th></th>
              <th>Actions</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($req)) {
            ?>
              <tr>
                <td class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?php echo $row['code'] ?></td>
                <td class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?php echo $row['titre_sous'] ?></td>
                <td class="click" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)"><?php echo $row['date_debut'] ?></td>
                <td <?php if (strtotime($row['date_fin']) - time() <= 600) echo 'style="color: red;"'; ?>>
                  <input type="datetime-local" id="date-fin-<?= $row['id_sous'] ?>" value="<?= $row['date_fin'] ?>" onchange="modifierDateFin(<?= $row['id_sous'] ?>, this.value)" style="border: none;">
                </td>
                <td><a href="detail_soumission.php?id_sous=<?php echo $row['id_sous'] ?>">Détail</a></td>
                <td><a href="archiver_soumission_terminer.php?id_sous=<?php echo $row['id_sous'] ?>" id="archiver">Archiver</a></td>
                <td><a href="prolonger_soumission.php?id_sous=<?php echo $row['id_sous'] ?>" id="prolonger">Prolonger</a></td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<script src="../JS/sweetalert2.js"></script>

<?php
if (isset($_SESSION['archive_reussi']) && $_SESSION['archive_reussi'] === true) {
  echo "<script>
  Swal.fire({
      title: 'Archivage réussi !',
      text: 'La soumission a été archivée avec succès.',
      icon: 'success',
      confirmButtonColor: '#3099d6',
      confirmButtonText: 'OK'
  });
  </script>";

  // Supprimer l'indicateur de succès de la session
  unset($_SESSION['archive_reussi']);
}

if (isset($_SESSION['prolongement_reussi']) && $_SESSION['prolongement_reussi'] === true) {
  echo "<script>
  Swal.fire({
      title: 'Prolongement réussi !',
      text: 'La soumission a été prolongée avec succès.',
      icon: 'success',
      confirmButtonColor: '#3099d6',
      confirmButtonText: 'OK'
  });
  </script>";

  // Supprimer l'indicateur de succès de la session
  unset($_SESSION['prolongement_reussi']);
}
?>

<script>
  var liensArchiver = document.querySelectorAll("#archiver");

  // Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
  liensArchiver.forEach(function(lien) {
    lien.addEventListener("click", function(event) {
      event.preventDefault();
      Swal.fire({
        title: "Voulez-vous vraiment archiver cette soumission ?",
        text: "",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3099d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Archiver"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = this.href;
        }
      });
    });
  });

  // Fonction pour modifier la date de fin
  function modifierDateFin(id_sous, nouvelle_date_fin) {
    // Créer un objet FormData pour envoyer les données via AJAX
    var formData = new FormData();
    formData.append('id_sous', id_sous);
    formData.append('nouvelle_date_fin', nouvelle_date_fin);

    // Envoyer la requête AJAX
    fetch('modifier_date_fin.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Vérifier le statut de la réponse JSON
        if (data.status === 'success') {
          // Afficher une boîte de dialogue de succès
          Swal.fire({
            title: 'Succès',
            text: data.message,
            icon: 'success',
            confirmButtonColor: '#3099d6'
          });
        } else {
          // Afficher une boîte de dialogue d'erreur
          Swal.fire({
            title: 'Erreur',
            text: data.message,
            icon: 'error',
            confirmButtonColor: '#3099d6'
          });
        }
      })
      .catch(error => {
        console.error('Une erreur s\'est produite lors de la requête AJAX :', error);
      });
  }

  function redirectToDetails(id_sous) {
    window.location.href = "reponses_etud.php?id_sous=" + id_sous;
  }

  var liensProlonger = document.querySelectorAll("#prolonger");

  // Parcourir chaque lien de prolongation et ajouter un écouteur d'événements
  liensProlonger.forEach(function(lien) {
    lien.addEventListener("click", function(event) {
      event.preventDefault();
      Swal.fire({
        title: "Voulez-vous vraiment prolonger cette soumission ?",
        text: "",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3099d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Annuler",
        confirmButtonText: "Prolonger"
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = this.href;
        }
      });
    });
  });
</script>