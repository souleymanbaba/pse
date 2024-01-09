<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
include_once "../connexion.php";
include_once "nav_bar.php";
if (isset($_GET['id_semestre'])) {
    $id_semestre = $_GET['id_semestre'];
    $_SESSION['id_sem'] = $_GET['id_semestre'];
} else {
    $id_semestre = $_SESSION['id_sem'];
}
?>

<style>
    .card-body:hover {
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <div class="content">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span><a href="choix_semestre.php">Accueil</a>  / <a href="#"><?php echo"S".$id_semestre ?></a>
            </h3>
        </div>

        <div class="content">
            <div class="row">
                <?php
                $req_ens_mail =  "SELECT matiere.id_matiere,inscription.id_semestre,matiere.libelle,matiere.code,matiere.specialite
                 FROM inscription, matiere, etudiant WHERE inscription.id_etud=etudiant.id_etud AND inscription.id_matiere=matiere.id_matiere 
                 AND email = '$email'and inscription.id_semestre=$id_semestre";
                $req = mysqli_query($conn, $req_ens_mail);
                if (mysqli_num_rows($req) == 0) {
                    echo "Aucune matière n'a été ajoutée !";
                } else {
                    $i = 0;
                    $list_colors = array('primary', 'info', 'success', 'secondary');
                    while ($row = mysqli_fetch_assoc($req)) {
                        ?>
                        <div class="col-md-4 stretch-card grid-margin">
                            <div class="card bg-gradient-<?php echo $list_colors[$i] ?> card-img-holder text-white">
                                <a href="soumission_etu_par_matiere.php?id_matiere=<?php echo $row['id_matiere']?>&color=<?php echo $list_colors[$i] ?>&id_semestre=<?= $row['id_semestre'] ?>" style="text-decoration: none;" class="text-white">
                                    <div class="card-body"  onclick="redirectToDetails(<?php echo $row['id_matiere'] ?>)" >
                                        <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                        <h3 class="mb-5"><?= $row['libelle'] ?> <?= $row['code'] ?></h3>
                                        <h6 class="card-text"> filière : <?= $row['specialite'] ?></h6>
                                        <h3 class="card-text"> S<?= $row['id_semestre'] ?></h3>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                        if ($i == 3) {
                            $i = -1;
                        }
                        $i++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function redirectToDetails(id_matiere, test) {
        window.location.href = "soumission_etu_par_matiere.php?id_matiere=" + id_matiere;
    }
</script>
