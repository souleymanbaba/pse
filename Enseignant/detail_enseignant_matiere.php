
<?php
session_start() ;
$email = $_SESSION['email'];
if($_SESSION["role"]!="ens"){
    header("location:authentification.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailler matiere par enseignant </title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
</br></br></br>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-lg-12"> 

            <ol class="breadcrumb">
                <li><a href="acceuil.php">Acceuil</a></li>
                </li>
                    <li>Gestion des matière</li>
                    <li>Détails </li>
            </ol>

    <div class="row">
        <div class="col-lg-12">
            <div class="well">
            <?php
                 include_once "../connexion.php";
                $id_matiere = $_GET['id_matiere'];
                $matiere = "SELECT DISTINCT *  FROM matiere
                INNER JOIN enseigner ON matiere.id_matiere = enseigner.id_matiere
                INNER JOIN enseignant ON enseignant.id_ens = enseigner.id_ens
                WHERE matiere.id_matiere = $id_matiere AND email = '$email'";
                $matiere_qry = mysqli_query($conn,$matiere);
               $row_matiere = mysqli_fetch_assoc($matiere_qry);
                ?>
            <fieldset class="fsStyle">
                        <legend class="legendStyle">
                            <a data-toggle="collapse" data-target="#demo" href="#" >Détails sur la matière <?php echo $row_matiere['libelle']." "." Enseigner par "." ".$row_matiere['nom']." ".$row_matiere['prenom']  ?></a>
                        </legend>
                       
                    </fieldset>
            
        </div>
    </div>
</div>

    <?php

   
    $id_matiere = $_GET['id_matiere'];

    $req_detail = "SELECT DISTINCT matiere.id_matiere, nom, prenom, code, matiere.libelle as 'libelle_matiere', groupe.libelle as 'libelle_groupe',libelle_type, specialite, email FROM matiere
                INNER JOIN enseigner ON matiere.id_matiere = enseigner.id_matiere
                INNER JOIN enseignant ON enseignant.id_ens = enseigner.id_ens
                INNER JOIN groupe ON groupe.id_groupe = enseigner.id_groupe
                INNER JOIN type_matiere ON type_matiere.id_type_matiere = enseigner.id_type_matiere
                WHERE matiere.id_matiere = $id_matiere AND email = '$email'";
    $req = mysqli_query($conn , $req_detail);
    $row=mysqli_fetch_assoc($req);
    ?>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <fieldset>
                <br><br>

                <h4>
                <?php echo "<strong>Nom de l'enseignant : </strong>". $row['nom']." ".$row['prenom']; ?><br><br>
                <?php echo "<strong>Code de la matière : </strong>". $row['code']; ?><br><br>
                <?php echo "<strong>Libellè : </strong>". $row['libelle_matiere']; ?><br><br>
                <?php echo "<strong> Specialite : </strong>" . $row['specialite']; ?><br><br>
                <?php echo "<strong> E-mail de l'enseignant : </strong>" . $row['email']; ?><br><br>
                <?php echo "<strong>Groupe : </strong>". $row['libelle_groupe']; ?><br><br>
                <?php echo "<strong>Type de la matière : </strong>". $row['libelle_type']; ?><br><br>
                </h4>
               
            </fieldset>
            <br><br>
        </div>
    </div>


    <div style="display: flex ; justify-content: space-between;">
    <div>
    <a href="list_etudiant.php?id_matiere=<?=$row['id_matiere']?>" class = "btn btn-primary" >List des etudiants inscrire</a>
    </div>
    <!-- <div>
    <a href="../index_enseignant.php" class="btn btn-primary">Retour</a>
    </div> -->
    <?php
    include "../nav_bar.php";
    ?>
  

</div> <!-- Fermeture de la div container -->

</body>
</html>