
<?php 
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="etudiant"){
     header("location:../authentification.php");
 }

include_once "../connexion.php";
$id_sous = $_GET['id_sous'];
$id_matiere = $_GET['id_matiere'];
$color = $_GET['color'];
$id_semestre = $_GET['id_semestre'];
$id_file=$_GET['id_file'];

$sql="DELETE FROM fichiers_reponses WHERE id_fich_rep = $id_file ";

$resul=mysqli_query($conn,$sql);
if($resul){
    $_SESSION['suppression_reussi'] = true ;
    header("location:reponse_etudiant.php?id_sous=$id_sous&id_matiere=$id_matiere&color=$color&id_semestre=$id_semestre");
}
?>
