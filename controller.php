
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="search.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"> -->
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="" name="descriptison">
    <meta content="" name="keywords">
  
    <link rel="stylesheet" href=".assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
</head>



  <script>
    $(document).ready(function() {
  $("#success-alert").hide();

    $("#success-alert").slideDown(300).delay(2000).slideUp(400);
});

$('#success-alert .close').click(function() {
  $(this).parent().hide();
});
  </script>
<body>
    

<?php
$alert = "";
    include_once("connexion.php");
    // Connection Created Successfully
        session_start();

    // Store All Errors
    $errors = [];



        //verifier:
            if(isset($_POST['verifier'])){
                $role =  $_POST['role'];
                $email = $_POST['email'];
                if($role=="enseignant"){
                    $sql_ens=mysqli_query($conn,"select * from enseignant where email='$email'");
                    $query1="select id_role from enseignant where email='$email' limit 1";
                    $query=mysqli_query($conn,$query1);
                    $droit=mysqli_fetch_assoc($query); 
                }
                else{
                    $sql_etud=mysqli_query($conn,"select * from etudiant where email='$email'");
                    $query1="select id_role from etudiant where email='$email' limit 1";
                    $query=mysqli_query($conn,$query1);
                    $droit=mysqli_fetch_assoc($query);
                }
                $sql = "SELECT * FROM utilisateur WHERE login = '$email'";
                $res = mysqli_query($conn, $sql) or die('échec de la requête');


                if(mysqli_num_rows($query)==0){
                    $errors['password'] = "Vous n'avez pas les droits pour crée un compt !"; 
                }else if (mysqli_num_rows($res) > 0) {
                    $errors['login'] = 'L’e-mail est déjà pris !';
                }else{
                    if(isset($role) && isset($email)){
                        if($role == "etudiant"){
                            session_start();
                            $_SESSION['nom']= "etudiant";
                            $_SESSION['email']= $email; 
                            header('location:registration.php');
                        }
                        else if($role == "enseignant"){
                            session_start();
                            $_SESSION['nom']= "enseignant";
                            $_SESSION['email']= $email;   
                            header('location: registration.php');    
                        }
                        }else {
                        $message = "Veuillez remplir tous les champs !";
                    }
                }  
            }



    // When Sign Up Button Clicked
    if (isset($_POST['signup'])) {
        function test($data){
        $data=htmlspecialchars($data) ;
        $data=trim($data) ;
        $data=strtolower($data) ;
    return $data ;
    }
    $role = $_SESSION['nom'];
    $email = $_SESSION['email'];

    if($role == "enseignant"){
        $id_role = 2;
    }else{
        $id_role = 3;
    }
        $_SESSION['role']=$id_role;
        $_SESSION['email']=$email;
       

        $fname = test(mysqli_real_escape_string($conn, $_POST['fname']));
        $lname = test(mysqli_real_escape_string($conn, $_POST['lname']));
        @$test=explode("@", test($email));

 
        if($test[1]=='supnum.mr'){
            if (strlen(trim($_POST['password'])) < 8) {
                $errors['password'] = 'Utilisez 8 caractères ou plus avec un mélange de lettres, de chiffres et de symboles';
            } else {
                // if password not matched so
                if ($_POST['password'] != $_POST['confirmPassword']) {
                    $errors['password'] = 'Mot de passe ne correspondant pas !';
                } else {
                    $password = md5($_POST['password']);
                }
            }
        // generate a random Code
        $code = rand(999999, 111111);
        // set Status
        $status = 0;
        $_SESSION['pwd']=$password;
        $_SESSION['code']= $code;
        // count erros
        if (count($errors) === 0) {
          

            // Send Varification Code In Gmail
            
                $subject = 'Code de vérification des e-mails';
                $message = "Notre code de vérification est $code";
                $sender = "From: 22014@supnum.mr";
                 $url =  "https://script.google.com/macros/s/AKfycbz1KWjBC8wx3Ay9fYYg6pW_1dcS-07rYT07Xxq0SscKOgUXpiPcq5zqgfTsR7PZFr4j/exec";
                    $ch = curl_init($url);
               curl_setopt_array($ch, [
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_POSTFIELDS => http_build_query([
                  "recipient" => $test[0],
                  "subject"   =>$subject,
                  "body"      =>$message
               ])
            ]); 
               $result = curl_exec($ch);
                if ($result) {
                    $message = '<div class="alert alert-success row-md-12" id="success-alert">
                                <span aria-hidden="true">&times;</span>
                                <strong>Nous avons envoyé un code de vérification à votre adresse e-mail   </strong>
                                </div>';

                    $_SESSION['message'] = $message;
                    header('location: verifier_code.php');
                } 
                    else {
                    $errors['otp_errors'] = 'Échec lors de l’envoi du code!';
                }
             
        }
    }
}



    // if Verify Button Clicked
    if (isset($_POST['verify'])) {
        $_SESSION['message'] = "";
        $code=$_SESSION['code'];
        // $otp = mysqli_real_escape_string($conn, $_POST['otp']);
        if($_POST['otp']==$code){
            $email=$_SESSION['email'];
            $password=$_SESSION['pwd'];
            $id_role=$_SESSION['role'];
            $insertQuery = "INSERT INTO utilisateur (`login`,pwd,id_role,active,code)
            VALUES ('$email','$password',$id_role,1,0);";
            $insertInfo = mysqli_query($conn, $insertQuery) or die("Erreur lor de la création du compte !");

       

            if ($insertInfo) {
                header('location: authentification.php');
                $_SESSION['cree_reussi'] = true;
            } else {
                $errors['db_error'] = "Impossible d’insérer des données dans la base de données!";
            }
        } else {
            $errors['otp_error'] = '<div class="alert alert-danger row-md-15" id="success-alert">
                                <span aria-hidden="true">&times;</span>
                                <strong>Vous entrez un code de vérification non valide !</strong>
                                </div>';
        }
    }
    

    // if login Button clicked so
    if (isset($_POST['entrer'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']);
        $matricule = explode("@", $email);
        $_SESSION['matricule'] = $matricule[0];
        $Query = "SELECT * FROM utilisateur WHERE login = '$email' AND pwd = '$password'";
        $Query_check = mysqli_query($conn, $Query) or die("erreur"); // Erreur en cas d'échec de la requête
    
        $row = mysqli_fetch_assoc($Query_check);
        if (mysqli_num_rows($Query_check) > 0) {
            $status = $row['active'];
            if ($status == 1) {
                if ($row['id_role'] == 1) {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = "admin";
                    header("location:admin/acceuil.php");
                } elseif ($row['id_role'] == 2) {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = "ens";
                    header("location:Enseignant/choix_semester.php");
                } elseif ($row['id_role'] == 3) {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = "etudiant";
                    header("location:etudiant/choix_semestre.php");
                }
            } else {
                $errors['email'] = '<div class="alert alert-danger row-md-15" id="success-alert">
                                        <span aria-hidden="true">&times;</span>
                                        <strong>Ce compte n\'est pas activé, vous pouvez contacter l\'administrateur pour l\'activer</strong>
                                    </div>';
            }
        } else {
            $errors['email'] = '<div class="alert alert-danger row-md-15" id="success-alert">
                                <span aria-hidden="true">&times;</span>
                                <strong>Mot de passe ou Email incorrect !</strong>
                                </div>';
        }
    


}

    // if forgot button will clicked

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $_SESSION['email'] = $email;

        $emailCheckQuery = "SELECT * FROM utilisateur WHERE login= '$email'";
        $emailCheckResult = mysqli_query($conn, $emailCheckQuery);

        // if query run
        if ($emailCheckResult) {
            // if email matched
            if ($emailCheckResult ->num_rows > 0) {
                $code = rand(999999, 111111);
                $updateQuery = "UPDATE utilisateur SET code = $code WHERE login = '$email'";
                $updateResult = mysqli_query($conn, $updateQuery) or die("hh");
                if ($updateResult) {
                       $subject = 'Code de vérification des e-mails';
                        $message = "Notre code de vérification est $code";
                        $url = "https://script.google.com/macros/s/AKfycbw2MsBGjkJ7hzw_cnE5jW-CmqHZbibaNjrEz_DNXZZgCXfptPo5B1yy7x37kFrwSZkeFg/exec";
                        $ch = curl_init($url);
                        curl_setopt_array($ch, [
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_POSTFIELDS => http_build_query([
                            "recipient" => $email,
                            "subject"   =>$subject,
                            "body"      =>$message
                        ])
                        ]);   

                         $result = curl_exec($ch);
                 
                    if ($result) {
                        $message = "Nous avons envoyé un code de vérification à votre adresse e-mail <br> $email";

                        $_SESSION['message'] = $message;
                        header('location: verifyEmail.php');
                    } else {
                        $errors['otp_errors'] =  '<div class="alert alert-danger row-md-15" id="success-alert">
                                                    <span aria-hidden="true">&times;</span>
                                                    <strong>Échec lors de l’envoi du code ! </strong>
                                                </div>';
                    }
                } else {
                    $errors['db_errors'] = "Échec lors de l’insertion de données dans la base de données !";
                }
            }
            else{
                $errors['invalidEmail'] = '<p style ="color:red">Adresse e-mail non valide</p>';
            }
        }else {
            $errors['db_error'] = "Échec lors de la vérification des e-mails de la base de données!";
        }
    } 
if(isset($_POST['verifyEmail'])){
    $_SESSION['message'] = "";
    $otpverify = mysqli_real_escape_string($conn, $_POST['otpverify']);
    $verifyQuery = "SELECT * FROM utilisateur WHERE code = $otpverify";
    $runVerifyQuery = mysqli_query($conn, $verifyQuery);
    if($runVerifyQuery){
        if(mysqli_num_rows($runVerifyQuery) > 0){
            $newQuery = "UPDATE utilisateur SET code = 0";
            $run = mysqli_query($conn,$newQuery);
            header("location: newPassword.php");
        }else{
            $errors['verification_error'] = "Code de vérification non valide";
        }
    }else{
        $errors['db_error'] = "Échec lors de la vérification du code dans la base de données!";
    }
}
 
// change Password
if(isset($_POST['changePassword'])){
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirmPassword']);
    
    if (strlen($_POST['password']) < 8) {
        $errors['password_error'] = 'Utilisez 8 caractères ou plus avec un mélange de lettres, de chiffres et de symboles';
    } else {
        // if password not matched so
        if ($_POST['password'] != $_POST['confirmPassword']) {
            $errors['password_error'] = 'Mot de passe ne correspondant pas';
        } else {
            $email = $_SESSION['email'];
            $updatePassword = "UPDATE utilisateur SET pwd = '$password' WHERE login = '$email'";
            $updatePass = mysqli_query($conn, $updatePassword) or die("Query Failed");
           // session_unset($email);
            session_destroy();
            header('location: authentification.php');
        }
    }
}
?>

    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>


    <!-- ... Votre contenu existant ... -->

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
        // Désactivez le comportement par défaut du formulaire
        $('#monFormulaire').submit(function (event) {
            event.preventDefault();

            // Ajoutez ici vos conditions d'authentification
            var email = $('#exampleInputEmail1').val();
            var password = $('#exampleInputPassword1').val();

            // Exemple de condition : si l'email et le mot de passe sont valides
            if (email === 'email_valide@example.com' && password === 'mot_de_passe_valide') {
                // Soumettez automatiquement le formulaire
                $(this).unbind('submit').submit();
            } else {
                // Affichez un message d'erreur ou effectuez d'autres actions en cas d'échec de l'authentification
                alert('Authentification échouée. Veuillez vérifier vos informations.');
            }
        });
    });
</script>

</body>
</html>
