<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:../authentification.php");
}
$id_semestre = $_GET['id_semestre'];
include_once "../connexion.php";
echo $id_semestre;
$sql_ens = "SELECT * FROM enseignant WHERE enseignant.email ='$email'";
$req_ens = mysqli_query($conn, $sql_ens);
$row_ens = mysqli_fetch_assoc($req_ens);
include "nav_bar.php";
if (isset($_GET["id_semestre"])){
    $_SESSION['id_semestre']=$_GET["id_semestre"];
}
$id_sem = $_SESSION;

?>
<style>
    /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
    tr:hover {
        cursor: pointer;
        background-color: aliceblue;
    }
</style>
<div class="content-wrapper">
    <div class="content">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> <a href="choix_semester.php">Accuei</a><?php echo" / "?><a href="#"><?php echo "S".$_SESSION['id_semestre'];?></a>
            </h3>
        </div>

    <div class="content">
        <div class="row">

            <?php
            $req_ens_mail =  "SELECT DISTINCT matiere.*, semestre.*
            FROM matiere
            JOIN enseigner ON matiere.id_matiere = enseigner.id_matiere
            JOIN enseignant ON enseigner.id_ens = enseignant.id_ens
            JOIN semestre ON matiere.id_semestre = semestre.id_semestre
            WHERE
                enseignant.email = '$email'
                AND semestre.id_semestre = $id_semestre";

            $i = 0;
            $list_colors = array("success", "info", "secondary", "primary");
            $list_colors_hover = array("#24b2d016", "#dfe9f7", "#dfe9f7", "rgba(163, 93, 255, 0.15)");

            $req = mysqli_query($conn, $req_ens_mail);

            if (mysqli_num_rows($req) == 0) {
                echo "Il n'y a pas encore de matières ajoutées !";
            } else {
                while ($row = mysqli_fetch_assoc($req)) {
            ?>
                    <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $list_colors[$i] ?> card-img-holder text-white">
                            <a href="soumission_par_matiere.php?id_matiere=<?php echo $row['id_matiere'] ?>&color=<?php echo $list_colors[$i] ?>&color_hover=<?php echo $list_colors_hover[$i] ?>" style="text-decoration: none;" class="text-white">
                                <div class="card-body">
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h4 class="mb-5" onclick="redirectToDetails(<?php echo $row['id_matiere']; ?>)">
                                        <?= $row['libelle'] ?>
                                    </h4>
                                    <h6 class="card-text" onclick="redirectToDetails(<?php echo $row['id_matiere']; ?>)"><?= $row['specialite'] ?></h6>
                                </div>
                            </a>
                        </div>
                    </div>
            <?php
                    if ($i == 3) {
                        $i = 0;
                    }
                    $i++;
                }
            }
            ?>
        </div>
    </div>
</div>

<script>
    function redirectToDetails(id_matiere) {
        window.location.href = "soumission_par_matiere.php?id_matiere=" + id_matiere;
    }
</script>
</body>
</html>
