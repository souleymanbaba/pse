<?php
session_start();
$email = $_SESSION['email'];
$id_matiere = $_GET['id_matiere'];
$color = $_GET['color'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
}


include "nav_bar.php";


?>

<title>Detaille de la soumission</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../JS/sweetalert2.js"></script>

<?php
include_once "../connexion.php";
if (!empty($_GET['id_sous'])) {
    $id_sous = $_GET['id_sous'];
} else {
    $id_sous = $_SESSION['id_sous'];
}
// biblioteque de message email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


$id_semestre = $_GET['id_semestre'];


// ferification si touts les eturdient sont rapondu a le somission 



$req_num_rep = mysqli_query($conn, "select count(*) as num_rep from reponses where id_sous = $id_sous ");

$req_num_insc = mysqli_query($conn, "select count(*) as num_insc from  inscription,matiere,soumission where inscription.id_matiere=matiere.id_matiere and matiere.id_matiere=soumission.id_matiere and  id_sous = $id_sous");
if ($req_num_rep && $req_num_insc) {

    $row_num_rep = mysqli_fetch_assoc($req_num_rep);
    $row_num_insc = mysqli_fetch_assoc($req_num_insc);

    $ens_email = mysqli_query($conn, "select email from enseignant WHERE enseignant.id_ens=(SELECT soumission.id_ens FROM soumission WHERE id_sous =$id_sous)");
    $email_ens = mysqli_fetch_assoc($ens_email);
    if ($row_num_insc['num_insc'] == $row_num_rep['num_rep']) {
        $is_somission_valid = mysqli_fetch_assoc(mysqli_query($conn, "SELECT valide FROM `soumission` WHERE id_sous = $id_sous"));
        if ($is_somission_valid != 0) {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nodenodeemail@gmail.com';
            $mail->Password = 'dczxmfqzwjqjeuzp';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('nodenodeemail@gmail.com');
            // $mail->addAddress("$email_ens");
            $mail->addAddress("22086@supnum.mr");
            $mail->isHTML(true);
            $mail->Subject = "reponse des etudients";
            $mail->Body = "tout les etudiants ont repondu a les soumission ";
            $mail->send();
            if ($mail->send()) {
                mysqli_query($conn, "UPDATE `soumission` SET `valide`=1 WHERE id_sous =$id_sous");
            }
        }
    }
}

// ******  

$req_detail = "SELECT * FROM soumission  WHERE id_sous = $id_sous and (status=0 or status=1)  ";
$req = mysqli_query($conn, $req_detail);
mysqli_num_rows($req);
$row = mysqli_fetch_assoc($req);


?>
<div class="content-wrapper">
    <div class="content">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> <a href="choix_semestre.php">Accueil</a>  / <a href="index_etudiant.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo "S" . $id_semestre ?></a>   / <a href="soumission_etu_par_matiere.php?id_semestre=<?php echo  $id_semestre ?>""><?php echo $_SESSION['nom_mat'] ?></a>  / <a href="#"><?php echo $row['titre_sous']; ?></a> 
            </h3>
        </div>

    <div class="content">
        <div class="row">
        <h3 class="page-title">Dètails sur la soumission <?php echo $row['titre_sous']; ?> : </h3><br><br>
            <?php

             if (isset($_SESSION['temp_fin']) && ($_SESSION['temp_fin'] === true)) {
            echo "<div class='alert alert-danger' id='success-alert' >
                L'heure spécifiée pour l'examen est déjà écoulée.
                                            </div>";

                // Supprimer l'indicateur de succès de la session
                unset($_SESSION['temp_fin']);
            }
            if (isset($_SESSION['temp_finni']) && ($_SESSION['temp_finni'] === true)) {
                echo "<div class='alert alert-danger' id='success-alert' >
                                L'enregistrement précédent n'a pas été pris en compte car le temps imparti était écoulé.
                                </div>";

                // Supprimer l'indicateur de succès de la session
                unset($_SESSION['temp_finni']);
            }
            if (isset($_SESSION['modification_fin']) && ($_SESSION['modification_fin'] === true)) {
                echo "<div class='alert alert-danger' id='success-alert' >
                            L'envoi du message a échoué car le temps a expiré.
                            </div>";

                // Supprimer l'indicateur de succès de la session
                unset($_SESSION['modification_fin']);
            }
            ?>

            <div class="col-md-6 grid-margin">
                <div class="card">
                    <div class="card-body mb-4">
                        <h2 class="card-title">L'annonce jointe pour la soumission.</h2>
                        <?php

                        if (strtotime(gmdate("Y-m-d H:i:s")) >= strtotime($row['date_fin'])) {
                            echo ' <div class="alert alert-danger mt-3" id="success-alert">
                                <strong>La date spécifiée pour cette soumission à été terminé.</strong>
                                </div>';
                        }
                        ?>
                        <h4>
                            <p><?php echo "<strong>Titre : </strong>" . $row['titre_sous']; ?></p>
                            <p><?php echo "<strong>Description : </strong>" . $row['description_sous'];  ?></p>
                            <p><?php echo "<strong>Date de  début : </strong>" . $row['date_debut']; ?></p>
                            <p><?php echo "<strong>Date de  fin : </strong>" . $row['date_fin']; ?></p>
                            <p><?php echo "<strong>Pour plus des informations : </strong>" . $row['person_contact']; ?></p>
                        </h4>
                        <p class="card-title mt-4">Les fichier(s) de soumission.</p>
                        <?php
                        $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' ";
                        $req2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($req2) == 0) {
                        ?>
                            <?php
                            echo "Il n'y a pas des fichier ajouter !";
                            ?>
                            <?php
                        } else {
                            while ($row2 = mysqli_fetch_assoc($req2)) {
                                $file_name = $row2['nom_fichier'];
                            ?>
                                <blockquote class="blockquote blockquote-info" style="border-radius:10px;">
                                    <p><strong><?= $file_name ?> </strong></p>

                                    <?php
                                    $test = explode(".", $file_name);
                                    if ($test[1] == "pdf") {
                                    ?>
                                        <a class="btn btn-inverse-info btn-sm " href="open_file.php?file_name=<?= $file_name ?>&id_sous=<?= $id_sous ?>" style="text-decoration: none;">Visualiser</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a class="btn btn-inverse-info btn-sm" title="Les fichiers d'extension pdf sont les seuls que vous pouvez visualiser 😒😒.">Visualiser</a>
                                    <?php
                                    }

                                    ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a class="btn btn-inverse-info btn-sm " href="telecharger_fichier.php?file_name=<?= $file_name ?>&id_sous=<?= $id_sous ?>" style="text-decoration: none;">Télécharger</a>
                                </blockquote>
                                <br>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Réponce de l'etudiant à cette soumission.</p>
                        <?php
                        $sql2 = "SELECT * FROM fichiers_reponses, reponses, etudiant WHERE fichiers_reponses.id_rep = reponses.id_rep AND reponses.id_etud = etudiant.id_etud AND email = '$email' AND reponses.id_sous = '$id_sous';";
                        $req2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($req2) == 0) {
                        ?>
                            <?php
                            echo "Il n'y a pas de fichier ajouté !";
                            ?>
                            <?php
                        } else {
                            while ($row2 = mysqli_fetch_assoc($req2)) {
                            ?>
                                <?php
                                $file_name = $row2['nom_fichiere'];
                                $id_rep = $row2['id_rep'];
                                ?>
                                <blockquote class="blockquote blockquote-info" style="border-radius:10px;">

                                    <p><strong><?= $row2['nom_fichiere'] ?> </strong></p>
                                    <?php
                                    $test = explode(".", $file_name);
                                    if ($test[1] == "pdf") {
                                    ?>
                                        &nbsp;<a class="btn btn-inverse-info btn-sm" href="open_file.php?file_name=<?= $file_name ?>&id_rep=<?= $id_rep ?>">Visualiser</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a class="btn btn-inverse-info btn-sm" title="Les fichiers d'extension pdf sont les seuls que vous pouvez visualiser 😒😒.">Visualiser</a>
                                    <?php
                                    }
                                    ?>
                                    <a class="btn btn-inverse-info btn-sm ms-4" href="telecharger_fichier.php?file_name=<?= $file_name ?>&id_rep=<?= $id_rep ?>">Télécharger</a>
                                </blockquote>
                                <br>
                        <?php
                            }
                        }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php
            $req_detail = "SELECT `status`, `date_fin`   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)    ";
            $req11 = mysqli_query($conn, $req_detail);
            $row12 = mysqli_fetch_assoc($req11);
            $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
            $req3 = mysqli_query($conn, $req_detail3);
            $sql = "select * from reponses where id_sous = '$id_sous' and id_etud = (select id_etud from etudiant where email = '$email') ";
            $req = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($req);
            $req_detail2 = "SELECT  `autoriser`  FROM soumission , demande  WHERE soumission.id_sous = $id_sous and (status=0 or status=1)  and soumission.id_sous = demande.id_sous and demande.id_etud = (select id_etud from etudiant where email = '$email') and autoriser = 1 ";
            $req2 = mysqli_query($conn, $req_detail2);
            $row2 = mysqli_fetch_assoc($req2);

            if (mysqli_num_rows($req3) > 0) {
                if (mysqli_num_rows($req2) == 0 or $row2['autoriser'] == 0) {
                    if (mysqli_num_rows($req) == 0) {
                        $_SESSION['autorisation'] = true;
            ?>
                        <p>
                            <a href="automatisation.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>&id_semestre=<?php echo $id_semestre ?>" class="btn btn-primary">Rendre le travail</a>
                        </p>
                    <?php
                    } else {
                    ?>
                        <?php
                        if ($row['confirmer'] ==  1) {
                        ?>
                            <p>
                                <a href="demande_modifier.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>&id_semestre=<?php echo $id_semestre ?>" class="btn btn-primary">Demande de faire une modification</a>
                            </p>
                        <?php
                        } else {
                            $_SESSION['autorisation'] = true;
                        ?>
                            <p>
                                <a href="reponse_etudiant.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>&id_semestre=<?php echo $id_semestre ?>" class="btn btn-primary">Modifier le travail</a>
                            </p>
                        <?php
                        }
                    }
                } else {
                    if (mysqli_num_rows($req) == 0) {
                        $_SESSION['autorisation'] = true;
                        ?>
                        <p>
                            <a href="automatisation.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>&id_semestre=<?php echo $id_semestre ?>" class="btn btn-primary">Rendre le travail</a>
                        </p>
                    <?php
                    } else {
                    ?>
                        <?php
                        if ($row['confirmer'] ==  1) {
                        ?>
                            <p>
                                <a href="demande_modifier.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>&id_semestre=<?php echo $id_semestre ?>" class="btn btn-primary">Demande de faire une modification</a>
                            </p>
                        <?php
                        } else {
                            $_SESSION['autorisation'] = true;
                        ?>
                            <p>
                                <a href="reponse_etudiant.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>&id_semestre=<?php echo $id_semestre ?>" class="btn btn-primary">Modifier le travail</a>
                            </p>
                        <?php
                        }
                    }
                }
            }


            ?>
        </div>
        <?php
        if (isset($_SESSION['ajout_reussi']) && $_SESSION['ajout_reussi'] === true) {
            echo "<script>
                    Swal.fire({
                        title: 'Ajout réussi !',
                        text: 'La réponse a été ajouté avec succès.',
                        icon: 'success',
                        confirmButtonColor: '#3099d6',
                        confirmButtonText: 'OK'
                    });
                    </script>";
            // Supprimer l'indicateur de succès de la session
            unset($_SESSION['ajout_reussi']);
        }
        ?>
        <?php
        if (isset($_SESSION['demande_reussi']) && $_SESSION['demande_reussi'] === true) {
            echo "<script>
                    Swal.fire({
                        title: 'Démande réussi !',
                        text: 'La démande a été envoyer avec succès.',
                        icon: 'success',
                        confirmButtonColor: '#3099d6',
                        confirmButtonText: 'OK'
                    });
                    </script>";

            // Supprimer l'indicateur de succès de la session
            unset($_SESSION['demande_reussi']);
        }
        ?>
    </div>
</div>
</div>
</div>
</div>