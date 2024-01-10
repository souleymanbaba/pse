<?php
$dbHost = 'localhost'; 
$dbUsername = 'root'; 
$dbPassword = ''; 
$dbName = 'pse'; 

$fileName = 'backup-' . date('Y-m-d') . '.sql';
$filePath = 'C:\\Users\\lapto\\Downloads\\' . $fileName;

// Supprimer un fichier existant avant de créer un nouveau
if (file_exists($filePath)) {
    if (!unlink($filePath)) {
        die("Une erreur est survenue lors de la suppression du fichier existant.");
    }
}

// Exporter la base de données
$command = "mysqldump --host={$dbHost} --user={$dbUsername} --password={$dbPassword} {$dbName} > {$filePath}";
system($command, $resultCode);

// Vérifier si la commande a réussi
if ($resultCode != 0) {
    die("Erreur lors de l'exportation de la base de données.");
}

// Envoyer le fichier à l'API
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://chahid.info/pse/receive_sql.php');
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, ['file' => new CURLFile($filePath)]);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

if ($response === false) {
    die(curl_error($curl));
}

curl_close($curl);

// Supprimer le fichier après l'envoi
unlink($filePath);

echo "Réponse de l'Application 2: $response";

session_start();

    $_SESSION['envoie_reussi'] = true;
    header("Location:admin/mise_a_jour.php");
?>
