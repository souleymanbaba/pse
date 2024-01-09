<?php

include '../../../connection.php';
$academic_id =   $_POST['academic_data'];
$semester_qry= "SELECT libelle FROM semestre where id_semestre = $academic_id";
$semester = mysqli_query($conn, $semester_qry);
$semester_row = mysqli_fetch_assoc($semester);

if($semester_row['libelle'] != 'S1' && $semester_row['semestere'] != 'S6'){
    $deppartement = "SELECT * FROM `departement`;";
    $deppartement_qry = mysqli_query($conn, $deppartement);
    $output = '<option value="" selected disabled> departement</option>';
    while ($deppartement_row = mysqli_fetch_assoc($deppartement_qry)) {
        $output .= '<option value="' . $deppartement_row['id'] . '">' . $deppartement_row['code'] .'</option>';
    }
    echo $output;
}elseif($semester_row['libelle'] == 'S1'){

    $deppartement = "SELECT * FROM `departement` where `code` = 'TC'";
    $deppartement_qry = mysqli_query($conn, $deppartement);
    $output = '<option value="" selected disabled> departement</option>';
    while ($deppartement_row = mysqli_fetch_assoc($deppartement_qry)) {
        $output .= '<option value="' . $deppartement_row['id'] . '">' . $deppartement_row['code'] .'</option>';
    }
    echo $output;

}
else{
    $deppartement = "SELECT * FROM `departement` where `code` != 'TC'";
    $deppartement_qry = mysqli_query($conn, $deppartement);
    $output = '<option value="" selected disabled> departement</option>';
    while ($deppartement_row = mysqli_fetch_assoc($deppartement_qry)) {
        $output .= '<option value="' . $deppartement_row['id'] . '">' . $deppartement_row['code'] .'</option>';
    }
    echo $output;
}
?>