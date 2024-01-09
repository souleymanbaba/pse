<?php
include_once "../connexion.php";
function test_input($data){
    $data = htmlspecialchars($data);
    $data = trim($data);
    $data = htmlentities($data);
    $data = stripcslashes($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sous = test_input($_POST['id_sous']);
    $nouvelle_date_fin = test_input($_POST['nouvelle_date_fin']);
    $update_query = "UPDATE soumission SET date_fin = '$nouvelle_date_fin' WHERE id_sous = $id_sous";
    $req = mysqli_query($conn, $update_query);
    if ($req) {
        echo json_encode(array('status' => 'success', 'message' => 'La date de fin a été mise à jour avec succès'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => "Une erreur s'est produite lors de la mise à jour de la date de fin"));
    }
}
?>
