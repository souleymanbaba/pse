<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}

include_once 'nav_bar.php';
?>

       
<?php
include_once "../connexion.php";
$req_ens_mail =  "SELECT * FROM reponses, soumission, matiere,etudiant 
WHERE reponses.id_etud=etudiant.id_etud AND
    reponses.id_sous=soumission.id_sous AND 
    soumission.id_matiere=matiere.id_matiere AND
    email='$email' AND render = 1 ";
$req = mysqli_query($conn, $req_ens_mail);
$touto="select * from etudiant where etudiant.email='$email' ";
$req_tou=mysqli_query($conn,$touto);
$row_tou=mysqli_fetch_assoc($req_tou);
?>
<div class="content-wrapper">
    <div class="content">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-clipboard-text"></i>
                </span> Notes 
            </h3>
        </div>

        <div class="content">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <div class="col-md-3.5 stretch-card grid-margin" >
                <div class="card bg-gradient-danger card-img-holder text-white" >
                  <div class="card-body" >
                    <h4 class="card-title">les notes de l'etudiant : <?= $row_tou['nom']." ".$row_tou['prenom'] ?></h4>
                    </div>
                    </div>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered" style="width:100%">
                      <thead>
                      <tr>
                      <tr>
                        <th>Code matiére</th>
                        <th>Libellè de la matiére</th>
                        <th>Titre de la soumission</th>
                        <th>Note</th>
                    </tr>
                    <?php
                    if (mysqli_num_rows($req) == 0) {
                        echo "Il n'y a pas encore de dustribtion de note !";
                    } else {
                        while ($row = mysqli_fetch_assoc($req)) {
                    ?>
                            <tr>
                                <td>
                                    <?= $row['code'] ?></td>
                                <td><?= $row['libelle'] ?></td>
                                <td><?= $row['titre_sous'] ?></td>
                                <td><?= $row['note'] ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
</div>
</body>
