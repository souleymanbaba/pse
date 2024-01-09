<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "ens") {
    header("location: authentification.php");
}
?>
<style>
    ul li {
        list-style: none;
    }
</style>
<title>Réponse étudiant</title>
<?php
if (isset($_GET['id_rep'])) {
    $id_rep = $_GET['id_rep'];
} else {
    $id_rep = $_SESSION['id_rep'];
}
include "nav_bar.php";
$req_detail = "SELECT matricule, id_groupe,nom, prenom, titre_sous, date_debut, date_fin, person_contact, description_sous, soumission.id_sous, description_rep, date, note FROM `reponses`, `etudiant`, `soumission`
WHERE reponses.id_etud = etudiant.id_etud  and reponses.id_rep ='$id_rep' and soumission.id_sous=reponses.id_sous";
$req = mysqli_query($conn, $req_detail);
$row = mysqli_fetch_assoc($req);

$id_sous = $row["id_sous"];

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="content-wrapper">
    <div class="content">
        <div class="page-header">
            <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
            </span>     <a href="choix_semester.php">Accuei</a>
    <?php echo" / "?>
    <a href="index_enseignant.php?id_semestre=<?php echo $_SESSION['id_semestre'] ; ?>"><?php echo "S".$_SESSION['id_semestre'];?></a>
    <?php echo" / "?><a href="soumission_par_matiere.php"><?php echo $_SESSION['libelle']?></a>
    <?php echo" / "?><a href="#"><?php echo $row['titre_sous']; ?></a>/ <a href="#"> <?php echo $row['nom'] . " " . $row['prenom'] ?> ( <?php echo $row['matricule'] ?> )</a>
            </h3>
        </div>
    <div class="content">
        <div class="row">
        <div class="col-md-12" style="display:flex;justify-content:space-around">
            <ol class="breadcrumb">
                <li>
                    <h4>Consultation de réponse de l'étudiant <a> <?php echo $row['nom'] . " " . $row['prenom'] ?> ( <?php echo $row['matricule'] ." G".$row['id_groupe']?> )</a></h4>
                </li>
            </ol>
           
        </div>

        <div class="col-md-6 grid-margin">
            <div class="card">
                <div class="card-body mb-4">
                    <h2 class="card-title">L'annonce jointe pour la soumission.</h2>
                    <h4>
                        <p><?php echo "<strong>Titre : </strong>" . $row['titre_sous']; ?></p>
                        <p><?php echo "<strong>Description : </strong>" . $row['description_sous'];  ?></p>
                        <p><?php echo "<strong>Date de début : </strong>" . $row['date_debut']; ?></p>
                        <p><?php echo "<strong>Date de fin : </strong>" . $row['date_fin']; ?></p>
                        <p><?php echo "<strong>Pour plus d'informations : </strong>" . $row['person_contact']; ?></p>
                    </h4>
                    <p class="card-title mt-4">Les fichiers de soumission.</p>
                    <?php
                    $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' ";
                    $req2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($req2) == 0) {
                    ?>
                        <?php
                        echo "Il n'y a pas de fichiers ajoutés !";
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
                    <p class="card-title">Réponse de l'étudiant :</p>

                    <h4>
                        <p><?php echo "<strong>Description de la réponse : </strong>" . $row['description_rep']; ?></p>
                        <p><?php echo "<strong>Date de la réponse : </strong>" . $row['date']; ?></p>
                    </h4>
                    
                    <?php
                    $sql2 = "SELECT * FROM fichiers_reponses, reponses, etudiant WHERE fichiers_reponses.id_rep = reponses.id_rep AND reponses.id_etud = etudiant.id_etud AND reponses.id_rep = $id_rep AND reponses.id_sous = '$id_sous';";
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
                <center>
                                <blockquote class="blockquote blockquote-info" style="border-radius:7px;width:130px;padding:10px;">
                                <h4  style='font-size: 20px;'><strong>Note</strong></h4>
                                <?php
                                if ($row['note'] != NULL) {
                                    echo "<center><b style='font-size: 20px;'>" . $row['note'] . " /20</b></center>";
                                }
                                ?>
                                <?php
                                $sql3 = "select * from reponses where id_rep='$id_rep' ";
                                $req3 = mysqli_query($conn, $sql3);
                                $row3 = mysqli_fetch_assoc($req3);
                                if ($row3['note'] > 0) {
                                ?>
                                    <a href="affecte_une_note.php?id_etud=<?= $id_rep ?>" class="btn btn-inverse-info btn-sm ms-4">Modifier</a>
                                <?php
                                } else {
                                    if($row3['confirmer']==0){
                                        ?>
                                    <a href="#" class="btn btn-inverse-warning btn-sm ">En attente de confirmation</a>
                                         <?php
                                    }
                                    else{
                                    
                                ?>
                                    <a href="affecte_une_note.php?id_etud=<?= $id_rep ?>" class="btn btn-inverse-info btn-sm ">Noter</a>
                                <?php
                                }}
                                ?>
                            </blockquote>
                </center>
            </div>
            
        </div>
        <div style="display: flex ; justify-content: space-between;">
            <div>
                <a href="reponses_etud.php?id_sous=<?= $row['id_sous'] ?>" class="btn btn-primary">Retour</a>
            </div>
        </div>
    </div>
</div>