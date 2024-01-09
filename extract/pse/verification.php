<?php
include_once("controller.php");
?>

<title>Vérification de rôle</title>

<div class="container-scroller">
   <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
               <div class="col-lg-4 mx-auto">
                  <div class="auth-form-light text-left p-5">
                        <form action="" method="POST">
                           <?php
                           if ($errors > 0) {
                              foreach ($errors as $displayErrors) {
                           ?>
                                    <div id="alert"><?php echo $displayErrors; ?></div>
                           <?php
                              }
                           }
                           ?>
                           <div class="form-group">
                              <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Adresse e-mail">
                           </div>
                           <div class="form-group">
                              <select name="role" class="form-control">
                                    <option value="enseignant">Enseignant</option>
                                    <option value="etudiant">Étudiant</option>
                              </select>
                           </div>
                           <div class="mt-3">
                              <center>
                                    <input type="submit" name="verifier" value="Vérifier" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                              </center>
                           </div>
                           <div class=" mt-4 font-weight-light">
                              <a href="authentification.php" class="text-primary">Connectez-vous</a>
                           </div>
                        </form>
                  </div>
               </div>
            </div>
      </div>
   </div>
</div>

