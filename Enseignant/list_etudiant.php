<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:authentification.php");
}
?>
<?php
include_once "../connexion.php";

$id_matiere = $_GET['id_matiere'];
$id_sous = $_GET['id_sous'];
$req = mysqli_query($conn, "SELECT * FROM matiere where matiere.id_matiere ='$id_matiere' ");
$row_matiere = mysqli_fetch_assoc($req);
include "nav_bar.php";
?>
<div class="content-wrapper">
    <div class="content">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> <a href="choix_semester.php">Accuei</a>
                <?php echo " / " ?>
                <a href="index_enseignant.php?id_semestre=<?php echo $_SESSION['id_semestre']; ?>"><?php echo "S" . $_SESSION['id_semestre']; ?></a>
                <?php echo " / " ?><a href="soumission_par_matiere.php"><?php echo $_SESSION['libelle'] ?></a>
                <?php echo " / " ?><a href="reponses_etud.php?id_sous=<?= $id_sous ?>"><?php echo $_SESSION['titre_sous']; ?></a> / <a href="#">Liste des etudiants inscrient </a>
            </h3>

        </div>

        <div class="content">
            <div class="row">


                <div class="col-lg-12 grid-margin stretch-card p-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Liste des etudiants inscrient :</h4>
                            <br>
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Matricule</th>
                                        <th>Nom et Prénom</th>
                                        <th>Filière</th>
                                        <th>Semestre</th>
                                        <th>E-mail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $req = mysqli_query($conn, "SELECT etudiant.*,departement.code ,semestre.* ,inscription.* FROM etudiant,semestre,inscription,departement where etudiant.id_semestre=semestre.id_semestre and etudiant.id_etud=inscription.id_etud and etudiant.id_dep=departement.id and id_matiere=$id_matiere  ORDER by matricule asc;");


                                    if (mysqli_num_rows($req) == 0) {
                                        echo "Il n'y a pas encore des etudiants ajouter !";
                                    } else {
                                        while ($row = mysqli_fetch_assoc($req)) {
                                    ?>
                                            <tr>
                                                <td><?= $row['matricule'] ?></td>
                                                <td><?= $row['nom'] ?>
                                                <?= $row['prenom'] ?></td>
                                                <?php $row['lieu_naiss'] ?>
                                                <?php $row['Date_naiss'] ?>
                                                <td><?= $row['code'] ?></td>
                                                <td><?= $row['nom_semestre'] ?></td>
                                                <?php $row['annee'] ?>
                                                <td><?= $row['email'] ?></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>