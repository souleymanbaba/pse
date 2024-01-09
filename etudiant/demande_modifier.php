<?php
session_start();
$id_matiere = $_GET['id_matiere'];
$color = $_GET['color'];
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
$id_sous = $_GET['id_sous'];
?>
<?php
// Bibléotheque PHPMailer pour l'envoi de email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


include_once "../connexion.php";
$req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
$req3 = mysqli_query($conn, $req_detail3);
if (mysqli_num_rows($req3) > 0) {

    $email = $_SESSION['email'];
    $req = mysqli_query($conn, "SELECT * FROM etudiant WHERE email = '$email'");
    $row = mysqli_fetch_assoc($req);

    $id_etud = $row['id_etud'];


    //Rêquete de personne de contacte
    $req_personne_contacte = mysqli_query($conn, "SELECT * FROM soumission WHERE id_sous = $id_sous");
    $row_personne_contacte = mysqli_fetch_assoc($req_personne_contacte);

    function test_input($data)
    {
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = stripcslashes($data);
        return $data;
    }
    $mail = new PHPMailer(true);

    try {
        if (isset($_POST['button'])) {
            $description = test_input($_POST['description']);

            if (!empty($description)) {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nodenodeemail@gmail.com';
                $mail->Password = 'dczxmfqzwjqjeuzp';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('nodenodeemail@gmail.com');
                $mail->addAddress($_POST['email']);
                $mail->isHTML(true);
                $mail->Subject = $_POST['subject'];
                $mail->Body = $_POST['description'];
                $mail->send();
                if ($mail->send()) {
                    $req = mysqli_query($conn, "INSERT INTO `demande` (`id_sous`,`id_etud`,`description`) VALUES($id_sous, $id_etud,'$description')");
                    if ($req) {
                        $id_matiere = $_GET['id_matiere'];
                        $color = $_GET['color'];
                        header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color");
                        $_SESSION['demande_reussi'] = true;
                    } else {
                        $message = "Démande n'est pas envoyé";
                    }
                } else {
                    $message =  'Une erreur est survenue lors de l\'envoi du courriel, peut être probléme de connexion.  ';
                }
            } else {
                $message = "Veuillez remplir tous les champs !";
            }
        }
    } catch (Exception $e) {
        $message =  'Une erreur est survenue lors de l\'envoi du courriel  , peut être probléme de connexion.';
    }


    include "nav_bar.php";

    $id_sous = $_GET['id_sous'];
    $id_matiere = $_GET['id_matiere'];
    $color = $_GET['color'];
    $id_semestre = $_GET['id_semestre'];

    $req_detail = "SELECT * FROM soumission  WHERE id_sous = $id_sous ";
    $req = mysqli_query($conn, $req_detail);
    $row_titre = mysqli_fetch_assoc($req);
?>
<div class="content-wrapper">
    <div class="content">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> <a href="choix_semestre.php">Accueil</a>  / <a href="index_etudiant.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo "S" . $id_semestre ?></a>   / <a href="soumission_etu_par_matiere.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo $_SESSION['nom_mat'] ?></a>  / <a href="soumission_etu.php?id_sous=<?=$id_sous?>&id_matiere=<?=$id_matiere?>&color=<?$color?>&id_semestre=<?=$id_semestre?>"><?php echo $row_titre['titre_sous']; ?></a> / <a href="#">Demande</a>
            </h3>
        </div>

    <div class="content">
        <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <h3 class="page-title"> Demande d'autorisation de modifier le travail en question.</h3>
                            <br>
                            <p class="erreur_message">
                                <?php
                                if (isset($message)) {
                                ?>
                            <div class="alert alert-danger " id="success-alert">
                                <?php
                                    echo $message;
                                ?>
                            </div>
                        <?php
                                }
                        ?>
                        </p>
                        <form action="" method="POST" class="forms-sample">
                            <input type="hidden" name="email" value="<?php echo $row_personne_contacte['person_contact'] ?>" class="form-control">
                            <input type="hidden" name="subject" value="<?php echo "L'étudiant ".$row['nom']."de matricule  ". "(".$row['matricule'].")". "demander des modifications " ?>">
                            <div class="form-group">
                                <label>Justification : </label>
                                <div class="col-md-12">
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <button type="submit" name="button" class="btn btn-gradient-primary me-2">Envoyer</button>
                            <a href="soumission_etu.php?id_sous=<?= $id_sous ?>&id_matiere=<?php echo $id_matiere ?>&color=<?php echo $color ?>" class="btn btn-light">Annuler</a>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php
} else {
    $_SESSION['id_sous'] = $id_sous;
    header("location:soumission_etu.php");
    $_SESSION['modification_fin'] = true;
}
