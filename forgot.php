<?php 
    include_once ("controller.php"); 
?>

<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth">
      <div class="row flex-grow">
        <div class="col-lg-4 mx-auto">
          <div class="auth-form-light text-left p-5">
            <form action="" method="POST" >
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
                    <input type="email" name="email" required placeholder="Enter your email" class="form-control form-control-lg">
              </div>
              <div class="mt-3">
                <center>
                <input type="submit" name="submit" value="verifier" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                </center>
              </div>
              <div class=" mt-4 font-weight-light">
               <a href="authentification.php" class="text-primary">connectez-vous</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>