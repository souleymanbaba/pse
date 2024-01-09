<?php
include_once "../connexion.php";

if (isset($_GET['semestre_id'])) {
    $semestre_id = $_GET['semestre_id'];

    $matiere_query = "SELECT m.*
                    FROM matiere m
                    INNER JOIN matiere_semestre ms ON m.id_matiere = ms.id_matiere
                    WHERE ms.id_semestre = '$semestre_id'";
    $matiere_result = mysqli_query($conn, $matiere_query);

    $options = '<option selected disabled> Les codes </option>';
    while ($row_matiere = mysqli_fetch_assoc($matiere_result)) {
        $options .= '<option value="' . $row_matiere['id_matiere'] . '">' . $row_matiere['code']." " .$row_matiere['libelle']. '</option>';
    }

    echo $options;
}
?>


