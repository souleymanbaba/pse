<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
include_once "nav_bar.php";
?>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Importer des Matiéres : </h4>
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
					  <input type="submit" name="import" value="Importer" class="btn btn-gradient-primary me-2"  />
                      <a href="matiere.php" class="btn btn-light">Cancel</a>
                    </form>
                  </div>
                </div>
              </div>
			</div>
		</div>
    </div>
</div>


<?php

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

			$code = $row[0];
			$libelle = $row[1];
			$specialite = $row[2];
			$module = $row[3];
			$semestre = $row[4];
		
					
		$sql = "INSERT INTO matiere( `code`, `libelle`,`specialite`, `id_module`, `id_semestre` ) VALUES('$code','$libelle', '$specialite', (SELECT id_module FROM module WHERE nom_module = '$module') ,(SELECT id_semestre FROM semestre WHERE nom_semestre = '$semestre'))";
		if(mysqli_query($conn,$sql)){
			echo "<script>window.location.href = 'matiere.php';</script>";
		}	
		else{
			echo "Ereur lors de l'importation !";
		}
	}
}	
?>
