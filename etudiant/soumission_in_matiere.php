<?php
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
include "../nav_bar.php";
include_once "../connexion.php";
$id_matiere = $_GET['id_matiere'];
$sql1 =  "SELECT * FROM  matiere WHERE id_matiere = '$id_matiere'";
$req1 = mysqli_query($conn, $sql1);
$row1 = mysqli_fetch_assoc($req1);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <style>
        /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
        tr:hover {
            cursor: pointer;
            background-color: aliceblue;
        }
    </style>
</head>

<body>
<br><br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="acceuil.php">Accueil</a></li>
                    <li>Les Soumissions dans la matiere : <?php echo $row1['libelle'] ?></li>
                </ol>
            </div>
        </div>
        <div style="overflow-x:auto;">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Titre de la soumission</th>
                    <th>Date de debut</th>
                    <th>Date de fin</th>
                </tr>
                <?php
                    $sql2 = "SELECT * FROM soumission inner join matiere using(id_matiere) WHERE id_matiere = $id_matiere and status=0 ";
                    $req2 = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($req2) == 0) {
                    echo "Il n'y a pas encore de matières ajoutées !";
                } else {
                    while ($row2 = mysqli_fetch_assoc($req2)) {
                        ?>
                        <tr onclick="redirectToDetails(<?php echo $row2['id_sous']; ?>)">
                            <td><?= $row2['titre_sous'] ?></td>
                            <td><?= $row2['date_debut'] ?></td>
                            <td><?= $row2['date_fin'] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        function redirectToDetails(id_sous) {
            window.location.href = "soumission_etu.php?id_sous=" + id_sous;
        }
    </script>

</body>

</html>
