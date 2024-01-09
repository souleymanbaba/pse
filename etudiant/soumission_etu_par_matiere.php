<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}

include_once "nav_bar.php";
include_once "../connexion.php";

if (isset($_GET['id_matiere'])) {
    $_SESSION['id_mat'] = $_GET['id_matiere'];
    $id_matiere = $_GET['id_matiere'];
}
$id_matiere = $_SESSION['id_mat'];

if (isset($_GET['color'])) {
    $_SESSION['color'] = $_GET['color'];
    $color = $_GET['color'];
}
$color = $_SESSION['color'];

$id_matiere = $_SESSION['id_mat'];

$sql1 = "select * from matiere where id_matiere=$id_matiere";
$sql2 = mysqli_query($conn, $sql1);
$row1 =  mysqli_fetch_assoc($sql2);
$id_semestre = $_GET['id_semestre'];

?>

    <style>
        /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
        #tou:hover {
            cursor: pointer;
            background-color: aliceblue;
            text-decoration: none;
        }

        .div-hover:hover {
            background-color: #dfe9f7;
            cursor: pointer;
            /* Changer le curseur de la souris */
        }

        .div-hover {
            border: 1px solid rgb(209, 206, 206);
            border-radius: 5px;
        }

        */
    </style>


        <?php
            $enline = "outline-dark";
            $cloture = "outline-dark";

            $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and status in (1,0) ";

            if (isset($_POST['cloture'])) {
                $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and  status=1";
                $enline = "outline-dark";
                $cloture = "dark";
            } else if (isset($_POST['enline'])) {
                $req_detail = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and status=0";

                $enline = "dark";
                $cloture = "outline-dark";
            }
            ?>
<div class="content-wrapper">
    <div class="content">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> <a href="choix_semestre.php">Accueil</a>  / <a href="index_etudiant.php?id_semestre=<?php echo $id_semestre; ?>"><?php echo "S" . $id_semestre;?></a>  / <a href="#"><?php echo $row1['libelle'] ; ?></a> 
            </h3>
        </div>

        <div class="content">
            <div class="row">

                <div class="col-md-3.5 stretch-card grid-margin">
                    <div class="card bg-gradient-<?php echo $color ?> card-img-holder text-white">
                        <div class="card-body">
                            <h4 class="mb-5"> <?php echo " " . $row1['libelle'] . "" . " "; $_SESSION['nom_mat'] = $row1['libelle']; ?></h4>
                            <form method="post">
                                <input type="submit" id="statu" class="btn btn-<?php echo $enline; ?> p-2" name="enline" value="Les soumissions en ligne">
                                <input type="submit" id="statu" class="btn btn-<?php echo $cloture; ?> p-2 " name="cloture" value="Les soumissions terminées">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $req = mysqli_query($conn, $req_detail);
            if (mysqli_num_rows($req) > 0) {

                while ($row = mysqli_fetch_assoc($req)) {
                    $m = $row['id_ens'];
                    $sqt = "select * from enseignant where id_ens='$m'";
                    $red = mysqli_query($conn, $sqt);
                    $rot = mysqli_fetch_assoc($red);
            ?>
                    <tr>
                        <a style="text-decoration: none" href="soumission_etu.php?id_sous=<?php echo $row['id_sous']?>&id_matiere=<?=$id_matiere?>&color=<?=$color?>&id_semestre=<?php echo $id_semestre; ?>">
                        <div class="col-md-14 stretch-card grid-margin">
                            <div class="card bg-gradient card-img-holder text-black" id="tou">
                                <div class="card-body div-hover" class="div-hover" style="display: flex;justify-content: left;padding: 15px; ">
                                    <div class="btn-gradient-info" style="width: 37px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;" onclick="redirectToDetails(<?php echo $row['id_sous']; ?>)">
                                        <i class="mdi mdi-book-open-page-variant " style="font-size: 20px;"></i>
                                    </div>
                                    <div >
                                        <p class="m-0"><?= $rot['nom'] . " " . $rot['prenom'] ?> a publié un nouveau <?= $row['titre_sous'] ?> </p>
                                        <p style="margin: 0%;">De &nbsp;<?= $row['date_debut'] ?> &nbsp; à &nbsp; <?= $row['date_fin']  ?> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>

                    <?php
                }
            } else {
                    ?>
                <?php
            }
                ?>
        </div>
    </div>
    </div>
    </div>

    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>

