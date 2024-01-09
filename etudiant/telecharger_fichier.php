<?php
include_once "../connexion.php";

    $file_name = $_GET['file_name'];
    $id_rep = $_GET['id_rep'];

    if(isset($id_rep)){
        $sql2 = "select * from fichiers_reponses where id_rep='$id_rep' and nom_fichiere='$file_name'";
        $req2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($req2);
        $file_chemin = $row2['chemin_fichiere']; 
    }else{
        $id_sous = $_GET['id_sous'];
        $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' and nom_fichier='$file_name'";
        $req2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($req2);
        $file_chemin = $row2['chemin_fichier']; 
    }
 

 
 
if(isset($file_name)) {
    $file = $file_name;
    $filepath = $file_chemin ;
    if(file_exists($filepath)) {
        // Définir les en-têtes du fichier à télécharger
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        readfile($filepath);
        exit;
    } else {
        echo "Le fichier demandé n'existe pas.";
        echo $filepath;
    }
}
?>
