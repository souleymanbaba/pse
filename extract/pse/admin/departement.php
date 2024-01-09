<?php

include_once "../connexion.php";
$academic_id =   $_POST['academic_data'];
$semester_qry= "SELECT nom_semestre FROM `semestre` where id_semestre = $academic_id";
$semester = mysqli_query($conn, $semester_qry);
$semester_row = mysqli_fetch_assoc($semester);


if($semester_row['nom_semestre'] != 'S1' && $semester_row['nom_semestre'] != 'S6'){
    $deppartement = "SELECT * FROM `departement`;";
    $deppartement_qry = mysqli_query($conn, $deppartement);
    $output = '<option value="" selected disabled> departement</option>';
    while ($deppartement_row = mysqli_fetch_assoc($deppartement_qry)) {
        $output .= '<option value="' .$deppartement_row['code'] . '">' . $deppartement_row['code'] .'</option>';
    }
    echo $output;
}elseif($semester_row['nom_semestre'] == 'S1'){

    $deppartement = "SELECT * FROM `departement` where `code` = 'TC'";
    $deppartement_qry = mysqli_query($conn, $deppartement);
    $output = '<option value="" selected disabled> departement</option>';
    while ($deppartement_row = mysqli_fetch_assoc($deppartement_qry)) {
        $output .= '<option value="' . $deppartement_row['code'] . '">' . $deppartement_row['code'] .'</option>';
    }

    echo $output;

}
else{
    $deppartement = "SELECT * FROM `departement` where `code` != 'TC'";
    $deppartement_qry = mysqli_query($conn, $deppartement);
    $output = '<option value="" selected disabled> departement</option>';
    while ($deppartement_row = mysqli_fetch_assoc($deppartement_qry)) {
        $output .= '<option value="' .$deppartement_row['code'] . '">' . $deppartement_row['code'] .'</option>';
    }
    echo $output;
}