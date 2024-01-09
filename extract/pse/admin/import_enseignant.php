<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
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
                    <h4 class="card-title">Importer des enseignants : </h4>
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
                      <a href="enseignant.php" class="btn btn-light">Cancel</a>
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
			$nom = $row[0];
			$prenom = $row[1];
			$Date_naiss = $row[2];
			$lieu_naiss = $row[3];
			$email = $row[4];
			$num_tel = $row[5];
			$num_wts = $row[6];
			$diplome = $row[7];
			$grade = $row[8];
			


		if(mysqli_query($conn, "INSERT INTO enseignant( `nom`, `prenom`,`Date_naiss`,`lieu_naiss` ,`email`,`num_tel`, `num_whatsapp`,`diplome`, `grade`,`id_role`)VALUES('$nom','$prenom','$Date_naiss', '$lieu_naiss', '$email','$num_tel', '$num_wts','$diplome', '$grade', 2)")){
			echo "<script>window.location.href = 'enseignant.php';</script>";
		}	
		}

		echo
		"
		<script>
		alert('Succesfully Imported');
		document.location.href = '';
		</script>
		";
	}

	?>

