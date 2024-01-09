<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "admin") {
    header("location:../authentification.php");
}
include_once "../connexion.php";
include_once 'nav_bar.php';

$req = mysqli_query($conn, "SELECT * FROM etudiant INNER JOIN semestre USING(id_semestre) ORDER by matricule asc;");
?>

  <!-- end css for table-data -->
  <script src="../JS/sweetalert2.js"></script>


  
    <title>Gestion des étudiants</title>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Gestion des etudiants :</h4>
                            <div style="display: flex; justify-content: space-between;">
                                <a href="ajouter_etudiant.php" class="btn btn-primary">Nouveau</a>
                                <a href="change_semestre.php" class="btn btn-primary">Changement de semestre</a>
                                <a href="importer_etudiant.php" class="btn btn-primary ml-25">Importer</a>
                            </div>
                            <br>
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Nom et Prénom</th>
                                        <th>Semestre</th>
                                        <th>Email</th>
                                        <th></th>
                                        <th>Actions</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row = mysqli_fetch_array($req)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['matricule']; ?></td>
                                        <td><?php echo $row['nom'] . ' ' . $row['prenom']; ?></td>
                                        <td><?php echo $row['nom_semestre']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><a href="detail_etudiant.php?id_etud=<?=$row['id_etud']?>">Détails</a></td>
                                        <td><a href="modifier_etudiant.php?id_etud=<?=$row['id_etud']?>">Modifier</a></td>
                                        <td><a href="supprimer_etudiant.php?id_etud=<?=$row['id_etud']?>" id="supprimer">Supprimer</a></td>
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
    </div>
</div>



<?php
// Afficher des messages en français
if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
    echo "<script>
    Swal.fire({
        title: 'Ajout réussi !',
        text: 'L'étudiant a été ajouté avec succès.',
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
        title: 'Suppression réussie !',
        text: 'L'étudiant a été supprimé avec succès.',
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
        title: 'Modification réussie !',
        text: 'L'étudiant a été modifié avec succès.',
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
    const lienssupprimer = document.querySelectorAll("#supprimer");

    lienssupprimer.forEach(function (lien) {
        lien.addEventListener("click", function (event) {
            event.preventDefault();
            Swal.fire({
                title: "Voulez-vous vraiment supprimer cet étudiant ?",
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

    $(document).ready(function () {
        $('.search-text').on('input', function () {
            var search = $(this).val();
            if (search != '') {
                $.ajax({
                    url: 'etudiant.php',
                    method: 'POST',
                    data: {search: search},
                    success: function (response) {
                        $('tbody').html(response);
                    }
                });
            } else {
                $.ajax({
                    url: 'etudiant.php',
                    method: 'POST',
                    success: function (response) {
                        $('tbody').html(response);
                    }
                });
            }
        });
    });
</script>

