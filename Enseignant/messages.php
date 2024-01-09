<?php
 session_start() ;
 $email = $_SESSION['email'];
 if($_SESSION["role"]!="ens"){
     header("location:../authentification.php");
 }

 include_once "../connexion.php";

include "nav_bar.php";

if(isset($_POST['button'])){
  if( !empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
    $id_etud = $_POST['id_etud'];
    $id_sous = $_POST['id_sous'];
  
    $req = mysqli_query($conn, "UPDATE demande SET  autoriser = 1  WHERE  id_etud = $id_etud and id_sous = $id_sous ");
    
    if($req){
        echo "<script>window.location.href='detail_message.php?id_sous=".$id_sous."&id_etud=".$id_etud.";</script>";
    }else {
        $message = "erreur";
    }
  
  }
}  

if(isset($_POST['annuler'])){
  if( !empty($_POST['id_etud']) && !empty($_POST['id_sous'])) {
    $id_etud = $_POST['id_etud'];
    $id_sous = $_POST['id_sous'];
  
    $req = mysqli_query($conn, "UPDATE demande SET  autoriser = 0  WHERE  id_etud = $id_etud and id_sous = $id_sous ");
    
    if($req){
      echo "<script>window.location.href='messages.php';</script>";
    }else {
        $message = "erreur";
    }
  
  }
}  
?>


    <?php
                
                $req2 = mysqli_query($conn, "SELECT demande.autoriser,demande.id_sous,demande.id_etud,nom,prenom,titre_sous,matricule,demande.description FROM demande ,soumission,etudiant where soumission.id_sous=demande.id_sous and etudiant.id_etud = demande.id_etud ORDER BY id_demande DESC   ;");
                while ($row2 = mysqli_fetch_array($req2)) {
                  ?>
          <div class="row">
              <div class="col-md-18 stretch-card grid-margin">
                <div class="card bg-gradient card-img-holder text-black">
                  <div class="card-body div-hover" style="display: flex;justify-content:space-around;">
                    <div class="btn-gradient-info" style="width: 40px;border-radius: 100%;height: 40px;display: flex;justify-content: center;align-items: center;margin-right: 10px;">
                      <i class="mdi mdi-email-outline " style="font-size: 20px;"></i>  
                    </div>
                    <div>
                    <div style="display:flex;justify-content:space-around;">
                        <div >
                            <p ><?php echo $row2['nom'] . ' ' . $row2['prenom']. '(' .$row2['matricule'].')'; ?> demande de faire une modification   sur la soumission <?php echo $row2['titre_sous'] ; ?></p> 
                        </div>
                        <div>
                            <form action="" method="POST" class="forms-sample">
                              <input type="text" name="id_sous" style="display:None;" value="<?=$row2['id_sous']?>">
                              <input type="text" name="id_etud" style="display:None;" value="<?=$row2['id_etud']?>">
                              <div style="display: flex;justify-content: space-bettwen;">

                              <?php 
                                if( $row2['autoriser'] == 0 ){
                                  ?>
                                  <button type="submit" name="button" class="btn btn-gradient-primary me-2">Autorisez a modifier</button>
                                  <?php  
                                }else{
                                  ?>
                                    <button type="submit" name="annuler" class="btn btn-gradient-primary me-2">Annuler l'autorisation</button>
                                  <?php
                                }
                              ?>
                                                    
                              </div>
                            </form>
                        </div>
                    </div>
                        <p style="margin: 0%;">Justification :  <?php echo $row2['description']?></p> 

                    </div>

                    
                </div>
            </div>
          </div>
          <?php
                }
          ?>
    </div>
</div>