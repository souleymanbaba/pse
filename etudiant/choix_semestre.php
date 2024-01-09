<?php 
session_start();
$email = $_SESSION['email'];
if ($_SESSION["role"] != "etudiant") {
    header("location:../authentification.php");
    exit;
}
include_once "../connexion.php";

include "nav_bar.php";

?>

<style>
    /* Ajoutez ce style pour changer le curseur en pointeur lorsqu'on survole une ligne */
    tr:hover {
        cursor: pointer;
        background-color: aliceblue;
    }
</style>
<div class="content-wrapper">
    <div class="content">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Accueil
            </h3>
        </div>

        <div class="content">
            <div class="row">
         <?php 

$i = 0;



$req="SELECT DISTINCT inscription.id_semestre FROM inscription WHERE inscription.id_etud=
(SELECT etudiant.id_etud FROM etudiant WHERE etudiant.email='$email')ORDER BY inscription.id_semestre";       



$query=mysqli_query($conn,$req);
if ($query ) { 

    while($row=mysqli_fetch_assoc($query)){
                   
                $list_colors = array("success","info","secondary","primary");
                $list_colors_hover = array("#24b2d016","#dfe9f7","#dfe9f7","rgba(163, 93, 255, 0.15)");
                    ?>
                       
                       <div class="col-md-3 stretch-card grid-margin">
                        <div class="card bg-gradient-<?php echo $list_colors[$i]?> card-img-holder text-white">
 <!--                       l'id ma kan ymchi m3a le lien ga3          -->
                            <a href="index_etudiant.php?id_semestre=<?php echo $row['id_semestre']; ?>" style="text-decoration: none;" class="text-white">
                                <div class="card-body" onclick="redirectToDetails(<?php echo $row['id_semestre']; ?>)">
                                    <img src="../assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                                    <h1 class="mb-5" onclick="redirectToDetails(<?php echo $row['id_semestre']; ?>)">
                                    <?="S".$row['id_semestre']?>
                                    </h1>
                                    
                                </div>
                            </a>
                         </div>
                    </div> 
                        
                    <?php
                    if($i== 3){
                        $i = 0;
                      }
                    
                    $i++;
                  
                    }}
            ?>
    </div></div></div>
            <script>
    function redirectToDetails(id_semester) {
        // <?php $_SESSION['id_semestre']= $id_semester ?>;
        window.location.href = "index_etudient.php?id_semestre=" + id_semester;

    }
</script>
         