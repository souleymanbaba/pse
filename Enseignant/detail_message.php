<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location: ../authentification.php");
}

include_once "../connexion.php";

$sql_ens = "SELECT * FROM enseignant WHERE enseignant.email = '$email'";
$req_ens = mysqli_query($conn, $sql_ens);
$row_ens = mysqli_fetch_assoc($req_ens);

if (!empty($_GET['id_etud']) && !empty($_GET['id_sous'])) {
    $id_etud = $_GET['id_etud'];
    $id_sous = $_GET['id_sous'];
}

if (isset($_POST['button'])) {
    if (!empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
        $id_etud = $_POST['id_etud'];
        $id_sous = $_POST['id_sous'];

        $req = mysqli_query($conn, "UPDATE demande SET autoriser = 1 WHERE id_etud = $id_etud and id_sous = $id_sous");

        $req2 = mysqli_query($conn, "UPDATE reponses SET confirmer = 0 WHERE id_etud = $id_etud and id_sous = $id_sous");

        if ($req && $req2) {
            echo "<script>window.location.href='detail_message.php?id_sous=" . $id_sous . "&id_etud=" . $id_etud . ";</script>";
        } else {
            $message = "erreur";
        }
    }
}

if (isset($_POST['annuler'])) {
    if (!empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
        $id_etud = $_POST['id_etud'];
        $id_sous = $_POST['id_sous'];

        $req = mysqli_query($conn, "UPDATE demande SET autoriser = 0 WHERE id_etud = $id_etud and id_sous = $id_sous");

        $req2 = mysqli_query($conn, "UPDATE reponses SET confirmer = 1 WHERE id_etud = $id_etud and id_sous = $id_sous");

        if ($req && $req2) {
            echo "<script>window.location.href='detail_message.php?id_sous=" . $id_sous . "&id_etud=" . $id_etud . ";</script>";
        } else {
            $message = "erreur";
        }
    }
}

if (isset($_POST['refuser'])) {
    if (!empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
        $id_etud = $_POST['id_etud'];
        $id_sous = $_POST['id_sous'];

        $req = mysqli_query($conn, "delete from demande WHERE id_etud = $id_etud and id_sous = $id_sous");

        if ($req) {
            echo "<script>window.location.href='index_enseignant.php';</script>";
        } else {
            $message = "erreur";
        }
    }
}

include "nav_bar.php";
?>

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <?php
                $req2 = mysqli_query($conn, "SELECT autoriser, nom, prenom, titre_sous, matricule, `description`, demande.id_sous, id_matiere FROM demande, soumission, etudiant where soumission.id_sous = demande.id_sous and etudiant.id_etud = demande.id_etud and demande.id_sous = $id_sous and demande.id_etud = $id_etud ;");
                $row2 = mysqli_fetch_assoc($req2);
                ?>

                <h4 class="col-md-12">
                    <?php echo $row2['nom'] . ' ' . $row2['prenom'] . ' (' . $row2['matricule'] . ')'; ?> demande de faire une modification sur la soumission <?php echo "<a style='text-decoration:none;' href='detail_soumission.php?id_sous=" . $row2['id_sous'] . "&id_matiere=" . $row2['id_matiere'] . "'>" . $row2['titre_sous'] . "</a>"; ?>
                </h4>
                <br><br><br>
                <form action="" method="POST" class="forms-sample">
                    <input type="text" name="id_sous" style="display:none;" value="<?= $id_sous ?>">
                    <input type="text" name="id_etud" style="display:none;" value="<?= $id_etud ?>">
                    <div class="col-md-12" style="display: flex; justify-content: space-between;">

                        <?php
                        if ($row2['autoriser'] == 0) {
                        ?>
                            <div class="col-md-10">
                                <button type="submit" name="button" class="btn btn-gradient-success btn-fw">Autoriser à modifier</button>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div>
                                <button type="submit" name="annuler" class="btn btn-gradient-success btn-fw">Annuler l'autorisation</button>
                            </div>
                        <?php
                        }
                        ?>
                        <div>
                            <button type="submit" name="refuser" class="btn btn-gradient-danger btn-fw">Refuser</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
