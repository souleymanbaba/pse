<?php
include_once "../connexion.php";

if(isset($_GET['id_sous'])) {
    $id_sous = $_GET['id_sous'];
    $sql2 = "SELECT * FROM fichiers_reponses, reponses WHERE id_sous='$id_sous' AND fichiers_reponses.id_rep = reponses.id_rep";
    $req2 = mysqli_query($conn, $sql2);

    // Créer un dossier temporaire pour stocker les fichiers avant de les compresser
    $temp_folder = 'temp_folder';
    if (!file_exists($temp_folder)) {
        mkdir($temp_folder);
    }

    // Parcourir les résultats de la requête pour copier les fichiers dans le dossier temporaire
    while ($row2 = mysqli_fetch_assoc($req2)) {
        $file_chemin = $row2['chemin_fichiere'];
        $file_name = basename($file_chemin);
        $destination = $temp_folder . '/' . $file_name;
        copy($file_chemin, $destination);
    }

    // Créer le fichier ZIP
    $zip_name = 'reponses_etudiants.zip';
    $zip_path = $temp_folder . '/' . $zip_name;
    $zip = new ZipArchive();
    if ($zip->open($zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        $files = glob($temp_folder . '/*');
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
    }

    // Définir les en-têtes du fichier à télécharger
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $zip_name . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($zip_path));
    readfile($zip_path);

    // Supprimer le dossier temporaire et le fichier ZIP après le téléchargement
    array_map('unlink', glob($temp_folder . '/*'));
    rmdir($temp_folder);

    exit;
} else {
    echo "ID sous non spécifié.";
}
?>
