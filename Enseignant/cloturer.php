
<br><br><br>
<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:authentification.php");
 }
 include_once "../connexion.php";
 $id_sous = $_GET['id_sous'];
//  $req = mysqli_query($conn , "SELECT * FROM soumission WHERE id_sous ='$id_sous'");
//  $row = mysqli_fetch_assoc($req);
 $req = mysqli_query($conn, "UPDATE soumission SET status = 1 WHERE id_sous = '$id_sous'");
        if($req){
            header('location:soumission_en_ligne.php');
            $_SESSION['cloture_reussi'] = true;
            }else {
            $message = "Soumission non modifié";
            }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <?php
    


        // if(isset($_POST['button'])){ 
        // extract($_POST);
        // if( !empty($fin)  ){
        //     $req = mysqli_query($conn, "UPDATE soumission SET cloturer = 1 WHERE id_sous = '$id_sous'");
        //     if($req){
        //         header('location:soumission_en_ligne.php');
        //     }else {
        //         $message = "Soumission non modifié";
        //     }

        // }else {
        //     $message = "Veuillez remplir tous les champs !";
        // }
        // }
        //include "../nav_bar.php";


        ?>    



</body>
</html>

