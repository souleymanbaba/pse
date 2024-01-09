<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "admin") {
    header("location:authentification.php");
}
include "nav_bar.php";

?>



<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Importer des inscriptions : </h4>
                        <p class="erreur_message">
                            <?php 
                            if(isset($message)){
                                echo $message;
                            }
                            ?>
                        </p>
                      <form action="" method="POST" class="forms-sample" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputName1">Sélectionner un fichier Excel :</label>
						<input type="file" name="excel" class = "form-control" accept=".xlsx" required>
                      </div>
					  <input type="submit" name="import" value=Importer class="btn btn-gradient-primary me-2"  />
                      <a href="inscription.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>
    </div>
</div>


    <?php
include_once "../connexion.php";

if (isset($_POST["import"])) {

	$fileName = $_FILES["excel"]["name"];
	$fileExtension = explode('.', $fileName);
	$fileExtension = strtolower(end($fileExtension));
	$newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

	$targetDirectory = "uploads/" . $newFileName;
	move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

	error_reporting(0);
	ini_set('display_errors', 0);

	require 'excelReader/excel_reader2.php';
	require 'excelReader/SpreadsheetReader.php';

	$reader = new SpreadsheetReader($targetDirectory);
	foreach ($reader as $key => $row) {

            $matricule = $row[0];
            $code_matiere = $row[1];
            $semestre = $row[2];


            $sql_condition = "SELECT * FROM inscription WHERE id_etud=(SELECT id_etud FROM etudiant WHERE matricule = '$matricule') AND id_matiere=(SELECT id_matiere FROM matiere WHERE code='$code_matiere') AND id_semestre=(SELECT id_semestre FROM semestre WHERE nom_semestre = '$semestre')";
            $req_condition = mysqli_query($conn, $sql_condition);

            if (mysqli_num_rows($req_condition) == 0) {
                if (mysqli_query($conn, "INSERT INTO inscription(`id_etud`, `id_matiere`, `id_semestre`) VALUES((SELECT id_etud FROM etudiant WHERE matricule = '$matricule'), (SELECT id_matiere FROM matiere WHERE code='$code_matiere'), (SELECT id_semestre FROM semestre WHERE nom_semestre = '$semestre'))")) {
                    echo "<script>window.location.href = 'inscription.php';</script>";
                    $_SESSION['import_reussi'] = true;
                }
            } else {
                echo "erreur";
            }
        }
    }
    ?>
    

</body>
