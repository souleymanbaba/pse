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
                    if(isset($_SESSION['message'])){
                        ?>
                        <div id="alert" style="background:	#228B22;"><?php echo $_SESSION['message']; ?></div>
                        <?php
                    }
                ?>

                <?php
                    if($errors > 0){
                        foreach($errors AS $displayErrors){
                        ?>
                        <div id="alert"><?php echo $displayErrors; ?></div>
                        <?php
                        }
                    }
                ?> 
            <div class="form-group">
                <input type="number" name="otpverify" class="form-control form-control-lg" id="exampleInputEmail1" required placeholder="Verification Code">
            </div>
              <div class="mt-3">
                <center>
                <input type="submit" name="verifyEmail" value="verifier" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                </center>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>