<?php

session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:../authentification.php");
}
include_once "../connexion.php";
$id_rep = $_GET['id_etud'];
if (isset($_POST['fin']) && $_POST['Note'] <= 20 && $_POST['Note'] >= 0) {
    $note = $_POST['Note'];
    $sql = "UPDATE `reponses` SET note=$note WHERE id_rep=$id_rep";
    $req_rep = mysqli_query($conn, $sql);
    //$row_rep = mysqli_fetch_assoc($req_rep);
    if ($req_rep) {
        header("location:consiltation_de_reponse.php");
        $_SESSION['id_rep'] = $id_rep;
    }
} else {
    $message = "<p class='text-danger'>Donner une note entre 0 et 20 !😒😒</p>";
}

include "nav_bar.php";
?>


    <?php

    $sql = "select * from reponses ,etudiant, soumission where id_rep='$id_rep' and reponses.id_sous=soumission.id_sous and etudiant.id_etud=reponses.id_etud";
    $req = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($req);
    ?>
    <div class="content-wrapper">
    <div class="content">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-calendar-clock"></i>
            </span> Soumission / <?php echo $row['titre_sous']; ?> / <?php echo $row['nom'] . " " . $row['prenom'] ?> ( <?php echo $row['matricule'] ?> ) / Note
            </h3>
        </div>

        <div class="content">
        <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Note :</h4>
                            <br>

                            <?php if (isset($_POST['Note']) && $message != "") {
                                echo $message;
                            }
                            ?>
                            <form action="" method="POST">
                                <div class="form-group col-md-12">
                                    <div style="display:flex;justify-content:space-bettwen;">
                                        <div class="col-md-2">
                                            <input type="float" name="Note" style="font-size: 22px;" class="form-control" value="<?= $row['note'] ?>">
                                        </div>
                                            <input type="submit" value="Affecter" name="fin" class="btn btn-primary ">
                                    </div>
                            </form>
<br>
                            <p>NB : Virgule dans le nombre représentée par un point ( . )</p>
                    </div>
                </div>
            </div>
        </div>