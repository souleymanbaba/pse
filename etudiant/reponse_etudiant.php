<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
}

include_once "../connexion.php";

date_default_timezone_set('GMT');



$id_sous = $_GET['id_sous'];
$id_matiere = $_GET['id_matiere'];
$color = $_GET['color'];
$id_semestre = $_GET['id_semestre'];


if (!isset($_SESSION['autorisation']) && $_SESSION['autorisation'] != true) {
    $_SESSION['id_sous'] = $id_sous;
    header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
}

$req_detail = "SELECT * FROM soumission  WHERE id_sous = $id_sous ";
$req = mysqli_query($conn, $req_detail);
$row_titre = mysqli_fetch_assoc($req);
?>



<?php
$sql = "select * from reponses where id_sous = ' $id_sous' and id_etud = (select id_etud from etudiant where email = '$email') ";
$req = mysqli_query($conn, $sql);

if (mysqli_num_rows($req) == 0) {

    function test_input($data)
    {
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = stripslashes($data);
        return $data;
    }

    if (isset($_POST['button'])) {
        

        $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
        $req3 = mysqli_query($conn, $req_detail3);
       

        if (mysqli_num_rows($req3) > 0) {
            
            $descri = test_input($_POST['description_sous']);
            $files = $_FILES['file'];
            if (!empty($descri) or !empty($files)) {
                date_default_timezone_set('GMT');
                $date = gmdate('Y-m-d H:i:s');
                $sql = "INSERT INTO `reponses`(`description_rep`,`date`, `id_sous`, `id_etud`) VALUES('$descri',$date,'$id_sous',(select id_etud from etudiant where email = '$email')) ";

                $req1 = mysqli_query($conn, $sql);

                $id_rep = mysqli_insert_id($conn);
                foreach ($files['tmp_name'] as $key => $tmp_name) {
                    $file_name = $files['name'][$key];
                    $file_tmp = $files['tmp_name'][$key];
                    $file_size = $files['size'][$key];
                    $file_error = $files['error'][$key];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                    if ($file_error === 0) {
                        $new_file_name = uniqid('', true) . '.' . $file_ext;

                        $sql3 = "SELECT matricule FROM etudiant WHERE etudiant.email = '$email'";
                        $code_matiere_result = mysqli_query($conn, $sql3);
                        $row = mysqli_fetch_assoc($code_matiere_result);
                        $matricule = $row['matricule'];
                        $matricule_directory = '../files/reponses/' . $matricule;

                        // Créer le dossier s'il n'exist pas
                        if (!is_dir($matricule_directory)) {
                            mkdir($matricule_directory, 0777, true);
                        }

                        // Chemin complet 
                        $destination = $matricule_directory . '/' . $new_file_name;
                        move_uploaded_file($file_tmp, $destination);

                        // Insérer les info dans la base de donnéez
                        $sql2 = "INSERT INTO `fichiers_reponses` (`id_rep`, `nom_fichiere`, `chemin_fichiere`) VALUES ($id_rep, '$file_name', '$destination')";
                        $req2 = mysqli_query($conn, $sql2);
                        if ($req1 and $req2) {

                            $_SESSION['id_sous'] = $id_sous;
                            $_SESSION['ajout_reussi'] = true;
                            $_SESSION['enregistre'] = true;
                            header("location:reponse_etudiant.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
                        }
                    }
                }
            }
        } else {
            $_SESSION['id_sous'] = $id_sous;
            header("location:soumission_etu.php?$id_sous&$id_matiere&$color&$id_semestre");
            $_SESSION['temp_finni'] = true;
        }
    }


    include "nav_bar.php";



?>
    <div class="content-wrapper">
        <div class="content">

            <div class="page-header">
                <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white me-2">
                        <i class="mdi mdi-home"></i>
                    </span> <a href="choix_semestre.php">Accueil</a> / <a href="index_etudiant.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo "S" . $id_semestre ?></a> / <a href="soumission_etu_par_matiere.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo $_SESSION['nom_mat'] ?></a> / <a href="soumission_etu.php?id_sous=<?= $id_sous ?>&id_matiere=<?= $id_matiere ?>&color=<? $color ?>&id_semestre=<?= $id_semestre ?>"><?php echo $row_titre['titre_sous']; ?></a> / <a href="#">Réponse</a>
                </h3>
            </div>

            <div class="content">
                <div class="row">
                    <h3 class="page-title"> Mettez votre réponse ici </h3>

                    <div class="form-horizontal">
                        <p class="erreur_message">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            }
                            ?>

                        </p>
                    </div>


                    <div class="col-md-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Description : </label>
                                        <div class="col-md-6">
                                            <textarea id="exampleInputUsername1" name="description_sous" id="" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label>Sélectionnez un fichier : </label>
                                        <div class="col-md-6">
                                            <input type="file" id="fichier" name="file[]" class="form-control" multiple required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <input type="submit" name="button" value="Enregistrer" class="btn btn-primary" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    <?php


} else {
    function test_input($data)
    {
        $data = htmlspecialchars($data);
        $data = trim($data);
        $data = htmlentities($data);
        $data = stripcslashes($data);
        return $data;
    }

    if (isset($_POST['button'])) {
        $req_detail3 = "SELECT  *   FROM soumission   WHERE id_sous = $id_sous and (status=0 or status=1)  and date_fin > NOW()  ";
        $req3 = mysqli_query($conn, $req_detail3);
        if (mysqli_num_rows($req3) > 0) {
            $descri = test_input($_POST['description_sous']);
            $files = $_FILES['file'];
            if (!empty($descri) or !empty($files)) {
                $sql = "UPDATE reponses set description_rep = '$descri' ,  `date` = NOW() where id_sous = $id_sous and id_etud=(select id_etud from etudiant where email = '$email') ";

                $req1 = mysqli_query($conn, $sql);

                $id_rep = mysqli_insert_id($conn);
                foreach ($files['tmp_name'] as $key => $tmp_name) {
                    $file_name = $files['name'][$key];
                    $file_tmp = $files['tmp_name'][$key];
                    $file_size = $files['size'][$key];
                    $file_error = $files['error'][$key];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                    if ($file_error === 0) {
                        $new_file_name = uniqid('', true) . '.' . $file_ext;

                        $sql3 = "SELECT matricule FROM etudiant WHERE etudiant.email = '$email'";
                        $code_matiere_result = mysqli_query($conn, $sql3);
                        $row = mysqli_fetch_assoc($code_matiere_result);
                        $matricule = $row['matricule'];
                        $matricule_directory = '../files/reponses/' . $matricule;

                        // Créer le dossier s'il n'exist pas
                        if (!is_dir($matricule_directory)) {
                            mkdir($matricule_directory, 0777, true);
                        }

                        // Chemin complet 
                        $destination = $matricule_directory . '/' . $new_file_name;
                        move_uploaded_file($file_tmp, $destination);

                        // Insérer les info dans la base de donnéez
                        $sql2 = "INSERT INTO `fichiers_reponses` (`id_rep`, `nom_fichiere`, `chemin_fichiere`) VALUES ((SELECT reponses.id_rep FROM reponses,etudiant WHERE reponses.id_etud=etudiant.id_etud and email='$email' and reponses.id_sous=$id_sous), '$file_name', '$destination')";
                        $req2 = mysqli_query($conn, $sql2);


                        if ($req1 && $req2) {
                            // unset($_SESSION['autorisation']);
                            $_SESSION['ajout_reussi'] = true;
                            header("location:reponse_etudiant.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
                        } else {
                            mysqli_connect_error();
                        }
                    }
                }
            }
        } else {
            $_SESSION['id_sous'] = $id_sous;
            header("location:soumission_etu.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
            $_SESSION['temp_finni'] = true;
        }
    }


    include "nav_bar.php";

    $sql = "SELECT * FROM reponses  WHERE  id_sous = '$id_sous' and id_etud = (select id_etud from etudiant where email = '$email')";
    $req1 = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($req1);

    ?>
        <div class="content-wrapper">
            <div class="content">

                <div class="page-header">
                    <h3 class="page-title">
                        <span class="page-title-icon bg-gradient-primary text-white me-2">
                            <i class="mdi mdi-home"></i>
                        </span> <a href="choix_semestre.php">Accueil</a> / <a href="index_etudiant.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo "S" . $id_semestre ?></a> / <a href="soumission_etu_par_matiere.php?id_semestre=<?php echo  $id_semestre ?>"><?php echo $_SESSION['nom_mat'] ?></a> / <a href="soumission_etu.php?id_sous=<?= $id_sous ?>&id_matiere=<?= $id_matiere ?>&color=<? $color ?>&id_semestre=<?= $id_semestre ?>"><?php echo $row_titre['titre_sous']; ?></a> / <a href="#">Réponse</a>
                    </h3>
                </div>

                <div class="content">
                    <div class="row">
                        <h3 class="page-title"> Modifier votre réponse </h3><br><br>
                        <div class="col-md-5 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="exampleInputUsername1" class="col-md-4">Description : </label>
                                            <textarea id="exampleInputUsername1" name="description_sous" class="form-control" cols="30" rows="10"><?= $row['description_rep'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Sélectionnez un fichier : </label>
                                            <input type="file" id="fichier" name="file[]" class="form-control" multiple>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title">Votre réponse : </p>
                                    <?php
                                    $sql2 = "SELECT * FROM fichiers_reponses, reponses, etudiant WHERE fichiers_reponses.id_rep = reponses.id_rep AND reponses.id_etud = etudiant.id_etud AND email = '$email' AND reponses.id_sous = '$id_sous';";
                                    $req2 = mysqli_query($conn, $sql2);
                                    if (mysqli_num_rows($req2) == 0) {
                                    ?>
                                        <?php
                                        echo "Il n'y a pas de fichier ajouté !";
                                        ?>
                                        <ul style="list-style: none;">
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
                                                    <a class="btn btn-inverse-danger btn-sm ms-4" href="supprime_fichier.php?id_file=<?= $row2['id_fich_rep'] ?>&id_sous=<?= $id_sous ?>&id_matiere=<?= $id_matiere ?>&color=<?= $color ?>&id_semestre=<?= $id_semestre ?>" id="supprimer">Supprimer</a>
                                                </blockquote>
                                                <br>
                                        <?php
                                            }
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12" style="display: flex; justify-content: space-between;">
                                <input type="submit" name="button" value="Enregistrer" class="btn btn-primary" />

                                <a href="confirmer.php?id_sous=<?php echo $row['id_sous']?>&id_matiere=<?=$id_matiere?>&color=<?=$color?>&id_semestre=<?php echo $id_semestre; ?>"  id="confirmer" class="btn btn-gradient-danger btn-icon-text">
                                    <i class="mdi mdi-upload btn-icon-prepend"></i> Envoyer ton travail
                                </a>
                            </div>
                        </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
        if (isset($_SESSION['suppression_reussi']) && $_SESSION['suppression_reussi'] === true) {
            echo "<script>
            Swal.fire({
                title: 'Suppression réussie !',
                text: 'Le fichier a été supprimé avec succès 🎉🎉',
                icon: 'success',
                confirmButtonColor: '#3099d6',
                confirmButtonText: 'OK'
            });
            </script>";

            // Supprimer l'indicateur de succès de la session
            unset($_SESSION['suppression_reussi']);
        }

        if (isset($_SESSION['enregistre']) && $_SESSION['enregistre'] === true) {
            echo '<script>
        Swal.fire({
            position: "top-start",
            icon: "success",
            text: "Votre travail a été enregistré avec succès 🎉🎉",
            showConfirmButton: false,
            timer: 2000
          });
        </script>';

            // Supprimer l'indicateur de succès de la session
            unset($_SESSION['enregistre']);
        }
        ?>

        <script>



            
            var liensConfirmer = document.querySelectorAll("#confirmer");

            // Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
            liensConfirmer.forEach(function(lien) {
                lien.addEventListener("click", function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Voulez-vous vraiment confirmer votre travail ?",
                        text: "Une fois que vous aurez confirmé votre travail, vous ne pourrez pas revenir en arrière. Êtes-vous sûr de vouloir procéder ?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#3099d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Annuler",
                        confirmButtonText: "Confirmer"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = this.href;
                        }
                    });
                });
            });


            var liensSupprimer = document.querySelectorAll("#supprimer");

            // Parcourir chaque lien d'archivage et ajouter un écouteur d'événements
            liensSupprimer.forEach(function(lien) {
                lien.addEventListener("click", function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Voulez-vous vraiment supprimer ce fichier ?",
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
        </script>

    <?php
}
?>