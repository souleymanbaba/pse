<?php
include_once "../connexion.php";
    $file_name = $_GET['file_name'];
    $id_rep = $_GET['id_rep'];
    $id_sous = $_GET['id_sous'];
    if(isset($id_rep)){
        $sql2 = "select * from fichiers_reponses where id_rep='$id_rep' and nom_fichiere='$file_name' ";
        $req2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($req2);
        $file_chemin = $row2['chemin_fichiere']; 
    }else{
        $sql2 = "select * from fichiers_soumission where id_sous='$id_sous' and nom_fichier='$file_name' ";
        $req2 = mysqli_query($conn,$sql2);
        $row2=mysqli_fetch_assoc($req2);
        $file_chemin = $row2['chemin_fichier']; 
    }
    header('content-type: application/pdf ');
    header('content-Disposition: inline; filename="' . $file_chemin . '"');
    header('content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    @readfile($file_chemin);

?>