<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location:authentification.php");
}

include_once "../connexion.php";

$semestre = "SELECT matiere.*, enseigner.*, enseignant.* FROM matiere, enseigner, enseignant 
    WHERE matiere.id_matiere = enseigner.id_matiere AND
    enseigner.id_ens = enseignant.id_ens AND email='$email'";
$semestre_qry = mysqli_query($conn, $semestre);

$type_sous = "SELECT * FROM type_soumission";
$type_sous_qry = mysqli_query($conn, $type_sous);

$persone_contact = "SELECT * FROM enseignant";
$persone_contact_qry = mysqli_query($conn, $persone_contact);

if($_GET["id_sous"] != null){
    $id_sous = $_GET["id_sous"];
}else{
    $id_sous = $_SESSION['id_sous'];
}


function test_input($data)
{
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = htmlentities($data);
    $data = stripslashes($data);
    return $data;
}

if (isset($_POST['button'])) {
    $id_matiere = test_input($_POST['matiere']);
    $date_debut = test_input($_POST['debut']);
    $date_fin = test_input($_POST['fin']);
    $type = test_input($_POST['type']);
    $personC = test_input($_POST['personC']);
    $files = $_FILES['file'];

    $titre = test_input($_POST['titre_sous']);
    $descri = test_input($_POST['description_sous']);


            // Vérifiez si la date de début est supérieure ou égale à la date de fin
            if (strtotime($date_debut) >= strtotime($date_fin)) {
                $message = "La date de début doit être antérieure à la date de fin. Veuillez corriger les dates.";
            } else {
                $sql1 = "Update  `soumission`  set `titre_sous` = '$titre', `description_sous` = '$descri',`person_contact`= '$personC', `id_ens` = (SELECT id_ens FROM enseignant WHERE email = '$email'), `date_debut` = '$date_debut', `date_fin` = '$date_fin',  `id_matiere` = $id_matiere,`id_type_sous`='$type' where id_sous = '$id_sous' ";
                $req1 = mysqli_query($conn, $sql1);

                // $id_sous = mysqli_insert_id($conn);
                foreach ($files['tmp_name'] as $key => $tmp_name) {
                    $file_name = $files['name'][$key];
                    $file_tmp = $files['tmp_name'][$key];
                    $file_size = $files['size'][$key];
                    $file_error = $files['error'][$key];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                    if ($file_error === 0) {
                        $new_file_name = uniqid('', true) . '.' . $file_ext;

                        $sql3 = "SELECT code FROM matiere WHERE matiere.id_matiere = '$id_matiere'";
                        $code_matiere_result = mysqli_query($conn, $sql3);
                        $row = mysqli_fetch_assoc($code_matiere_result);
                        $code_matire = $row['code'];
                        $matiere_directory = '../files/' . $code_matire;

                        // Créer le dossier s'il n'existe pas
                        if (!is_dir($matiere_directory)) {
                            mkdir($matiere_directory, 0777, true);
                        }
                        $destination = $matiere_directory . '/' . $new_file_name;
                        move_uploaded_file($file_tmp, $destination);
                        echo $destination;
                        echo $file_name;
                        // Insérer les infos dans la base de données
                        $sql2 = "INSERT INTO `fichiers_soumission` (`id_sous`, `nom_fichier`, `chemin_fichier`) VALUES ($id_sous, '$file_name', '$destination')";
                        $req2 = mysqli_query($conn, $sql2);
                        if ($req1 || $req2) {
                            $sql_tou = "SELECT * FROM `inscription` WHERE inscription.id_matiere='$id_matiere'";
                            $req_tou = mysqli_query($conn, $sql_tou);
                            header("location:soumission_en_ligne.php");
                            $_SESSION['modifier_reussi'] = true;
                        }
                    }
                }
            }
    }

include "nav_bar.php";
$sql = "SELECT * ,matiere.libelle as libelle_matiere FROM soumission,matiere,enseignant,type_soumission WHERE soumission.id_ens = enseignant.id_ens and soumission.id_matiere = matiere.id_matiere and soumission.id_type_sous = type_soumission.id_type_sous and id_sous = $id_sous;";
$req = mysqli_query($conn, $sql);
$row_glob = mysqli_fetch_assoc($req);
?>

<script type="text/JavaScript">
    var i = 1;
    function ToAction(url) {
        window.location.href = url;
    }
</script>
<div class="content-wrapper">
    <div class="row">
        <div class="col lg-6-md-6-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Modifier la soumission : </h4>

                    <p class="erreur_message">
                        <?php
                        if (isset($message)) {
                            ?>
                            <div class="alert alert-danger" id="success-alert">
                                <?php echo $message; ?>
                            </div>
                        <?php
                        }
                        ?>
                    </p>

                    <form action="" method="POST" enctype="multipart/form-data" class="forms-sample">
                        <div class="form-group">
                            <label>Titre :</label>
                            <div class="col-md-12">
                                <input type="text" name="titre_sous" class="form-control" value="<?=$row_glob['titre_sous'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Matière:</label>
                            <div class="col-md-12">
                                <select class="form-control" id="academic" value="Semesters" name="matiere">
                                    <option value="<?= $row_glob['id_matiere']; ?>"><?= $row_glob['code']; ?> <?= $row_glob['libelle_matiere']; ?></option>
                                    <?php while ($row = mysqli_fetch_assoc($semestre_qry)) : ?>
                                        <option value="<?= $row['id_matiere']; ?>"><?= $row['code']; ?> <?= $row['libelle']; ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Date de début :</label>
                            <div class="col-md-12">
                                <input type="datetime-local" name="debut" class="form-control" value="<?=$row_glob['date_debut'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Date de fin:</label>
                            <div class="col-md-12">
                                <input type="datetime-local" name="fin" class="form-control" value="<?=$row_glob['date_fin'];?>"> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Type de soumission:</label>
                            <div class="col-md-12">
                                <select class="form-control" id="academic" value="Semesters" name="type">
                                    <option value="<?= $row_glob['id_type_sous']; ?>"> <?= $row_glob['libelle']; ?> </option>
                                    <?php while ($row_type_sous = mysqli_fetch_assoc($type_sous_qry)) : ?>
                                        <option value="<?= $row_type_sous['id_type_sous']; ?>"> <?= $row_type_sous['libelle']; ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Personne à contacter:</label>
                            <div class="col-md-12">
                                <select class="form-control" id="academic" value="<?php echo $email; ?>" name="personC">
                                    <option value="<?= $row_glob['id_ens']; ?>"> <?= $row_glob['email']; ?> </option>
                                    <?php while ($row_persone_contact = mysqli_fetch_assoc($persone_contact_qry)) : ?>
                                        <option value="<?= $row_persone_contact['id_ens']; ?>"> <?= $row_persone_contact['email']; ?> </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description: </label>
                            <div class="col-md-12">
                                <input name="description_sous"  class="form-control"  value="<?=$row_glob['description_sous'];?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sélectionnez un ou plusieurs fichier(s) : </label>
                            <div class="col-md-12">
                                <input type="file" id="fichier" name="file[]" class="form-control" multiple >
                            </div>
                        </div>
                        <div id="newElementId"></div>
                        <br><br><br>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <input type="submit" name="button" value="Enregistrer" class="btn btn-gradient-primary me-2" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title">lesfichiers du soumission:</p>
                                <?php
                                $sql2 = "SELECT * FROM fichiers_soumission, soumission, enseignant WHERE fichiers_soumission.id_sous = soumission.id_sous AND soumission.id_ens = enseignant.id_ens AND email = '$email' AND soumission.id_sous = '$id_sous';";
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
                                            $file_name = $row2['nom_fichier'];
                                            $id_sous = $row2['id_sous'];
                                            ?>
                                            <blockquote class="blockquote blockquote-info" style="border-radius:10px;">
                                                <p><strong><?= $row2['nom_fichier'] ?> </strong></p>
                                                <?php
                                                $test = explode(".", $file_name);

                                                $test = explode(".", $file_name);
                                                if ($test[1] == "pdf") {
                                                ?>
                                                    &nbsp;<a class="btn btn-inverse-info btn-sm" href="open_file.php?file_name=<?= $file_name ?>&id_sous=<?= $id_sous ?>">Visualiser</a>
                                                <?php
                                                } else {
                                                ?>
                                                    <a class="btn btn-inverse-info btn-sm" title="Les fichiers d'extension pdf sont les seuls que vous pouvez visualiser 😒😒.">Visualiser</a>
                                                <?php
                                                }
                                                ?>
                                                <a class="btn btn-inverse-info btn-sm ms-4" href="telecharger_fichier.php?file_name=<?= $file_name ?>&id_sous=<?= $id_sous ?>">Télécharger</a>
                                                <a class="btn btn-inverse-danger btn-sm ms-4" href="supprime_fichier.php?file_name=<?= $file_name ?>&id_sous=<?= $id_sous ?>">Supprimer</a>
                                            </blockquote>
                                            <br>
                                    <?php
                                        }
                                    }
                                    ?>
                            </div>
                        </div>
                    </div>
    </div>
</div>
