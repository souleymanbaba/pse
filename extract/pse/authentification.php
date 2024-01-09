<?php
include_once("controller.php");
?>
<title>Connexion</title>
<!-- Liens pour SweetAlert2 -->
<script src="JS/sweetalert2.js"></script>

<!-- <span id="element"></span> -->

<!-- bibliothèque d'animation du texte  -->
<script src="JS/typed.umd.js"></script>



<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-2">
                        <center>
                            <div class="brand-logo ">
                                <img src="images/logo-supnum2.png">
                            </div>
                            <h4>Institut supérieur du numérique</h4>
                            <h6 class="font-weight-light">Plateforme de soumission des évaluations</h6>
                        </center>
                        <form action="" method="POST">

                        <?php
                            if (count($errors) > 0) {
                                foreach ($errors as $displayErrors) {
                            ?>
                                    <div class="form-group me-4 ms-4"><?php echo $displayErrors; ?></div>
                            <?php
                                }
                            }
                            ?>

                            <div class="form-group me-4 ms-4">
                                <input type="email" name="email" class="form-control form-control-sm " id="exampleInputEmail1" placeholder="Adresse e-mail" required>
                            </div>
                            <div class="form-group  me-4 ms-4">
                                <input type="password" name="password" class="form-control form-control-sm " id="exampleInputPassword1" placeholder="Mot de passe" required>
                            </div>
                            <div class="mt-3">
                                <center>
                                    <input type="submit" name="entrer" value="Se connecter" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                </center>
                            </div>
                            <div class="text-center mt-4 font-weight-light ">
                                Créer un compte <a href="verification.php" class="text-primary">S'inscrire</a>
                            </div><br>
                            <div class="text-center font-weight-light">
                                <a href="forgot.php" class=" text-primary">Mot de passe oublié ?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>