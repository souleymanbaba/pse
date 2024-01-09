<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="admin"){
    header("location:authentification.php");
}
include_once "nav_bar.php";
?>

<title>Importer des etudiants</title>

<div class="main-panel">
<div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Importer des etudiants : </h4>
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
						<input type="file" name="excel" class="form-control" accept=".xlsx" required>
                      </div>
					  <input type="submit" name="import" value="Importer" class="btn btn-gradient-primary me-2"  />
                      <a href="etudiant.php" class="btn btn-light">Annuler</a>
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


function test_input($data){
	$data = htmlspecialchars($data);
	$data = trim($data);
	$data = htmlentities($data);
	$data = stripcslashes($data);

	return $data;
}


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
		$nom = $row[1];
		$prenom = $row[2];
		$lieu_naiss = $row[3];
		$Date_naiss = $row[4];
		$semestre = $row[5];
		$annee = $row[6];
		$email = $row[7];
		$groupe = $row[8];
		$dep = $row[9];
		$groupe_td = $row[10];

		
		if(mysqli_query($conn, "INSERT INTO etudiant
		(`matricule`, `nom`, `prenom`, `lieu_naiss`, `Date_naiss`, `id_semestre`, `annee`, `email`,`id_role`, `id_groupe`,`id_dep`,`groupe_td`) VALUES
		('$matricule', '$nom','$prenom', '$lieu_naiss','$Date_naiss', 
		(select id_semestre from semestre where nom_semestre = '$semestre'  LIMIT 1), '$annee','$email',3,
		(SELECT id_groupe FROM groupe WHERE libelle = '$groupe'  LIMIT 1),(SELECT id FROM departement WHERE code = '$dep'  LIMIT 1),'$groupe_td' )")){
			echo "<script>window.location.href = 'etudiant.php';</script>";
		}	
		}


	}

	
	?>

