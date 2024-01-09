
<?php
     if($_SESSION["role"]=="ens"){
        //session_start();
        $email = $_SESSION['email'];
        include("../connexion.php");
        $req = mysqli_query($conn, "SELECT * FROM enseignant WHERE email = '$email'");
        $row = mysqli_fetch_assoc($req);
     
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Balises meta requises -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Accueil</title>
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <!-- Styles de mise en page -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Fin des styles de mise en page -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <!-- css for table-data -->
    <link rel="stylesheet" type="text/css" href="CSS/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="CSS/data_table.css">
    <link rel="stylesheet" href="CSS/data_table_boostrapp.css">
    <!-- end css for table-data -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
       
       .logo{
           display: flex;
           align-items: center;
           justify-content: center;
           height: 60%;
           margin-bottom: 10px;
           flex-direction: column;
           width: 200px;
           margin-top: 10px;
       }
    
       </style>
  </head>
  <body>
 
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="" alt="logo" /></a> -->
          <!-- <a class="navbar-brand brand-logo-mini" href="index.html"><img src="" alt="logo" /></a> -->
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="search-field d-none d-md-block">
            <form class="d-flex align-items-center h-100" action="#">
              <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" placeholder="Rechercher.... ">
              </div>
            </form>
          </div>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-block full-screen-link">
              <a class="nav-link">
                <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="mdi mdi-email-outline"></i>
                <span class="count-symbol bg-warning"></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                <h6 class="p-3 mb-0">Messages</h6>
                <?php
                
                $req2 = mysqli_query($conn, "SELECT demande.id_sous,demande.id_etud,nom,prenom,titre_sous,matricule FROM demande ,soumission,etudiant where soumission.id_sous=demande.id_sous and etudiant.id_etud = demande.id_etud ORDER BY id_demande DESC LIMIT 1 ;");
                while ($row2 = mysqli_fetch_array($req2)) {
                  ?>
                <div class="dropdown-divider"></div>
                <a href="detail_message.php?id_sous=<?=$row2['id_sous']?>&id_etud=<?=$row2['id_etud']?>"   class="dropdown-item text-black btn-fw ">
                  <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                    <p ><?php echo $row2['nom'] . ' ' . $row2['prenom']. '(' .$row2['matricule'].')'; ?><br> demande de faire une modification <br> sur la soumission <?php echo $row2['titre_sous'] ; ?> </p>
                    <p class="text-gray mb-0">  </p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="messages.php" class="dropdown-item text-black btn-fw "><h6 class="p-3 mb-0 text-center">Voir tous les messages</h6></a>
                <?php 
                }
                ?>
                <div class="dropdown-divider"></div>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="../images/supnum.jpg" alt="image" title="<?=$row['nom']." ".$row['prenom']?>">
                 
                  <span class="availability-status online"></span>
                </div>
                <div class= "nav-profile-text">
                  <p class="mb-1 text-black"><?php echo $row['nom'] ." ".$row['prenom'] ?></p>
                  <center><b>(Enseignant)</b></center>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                                               
                  <!-- <div class="container mt-12"> </div> -->


                  <div class="logo">
                     
                             <img title="<?=$row['nom']." ".$row['prenom']?>" 
                              id="myButton" class="style-scope yt-img-shadow" 
                              src="../images/supnum.jpg" draggable="false" 
                              style="width: 40px; height: 40px; border-radius: 50%;">
                              <p></p>
                              <a> <strong class='font-weight-bold'><?=$row['nom']." ".$row['prenom']?></strong></a>
                              
                              <p><?=$row['email']?></p>
                        </a>
                      </div>
                <a class="dropdown-item text-black btn-fw" href="#">
                    Gérer votre compte
                </a>
                <a class="dropdown-item text-black btn-fw" href="../supprimer_session.php">
                  <i class="mdi mdi-logout me-2 text-primary"></i>Se déconnecte 
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">

            <li class="nav-item" >
              <a class="nav-link" href="choix_semester.php">
                <span class="menu-title"id="display">Accueil</span>
                <i class="mdi mdi-home menu-icon"></i>
              </a>
            </li>
            <li class="nav-item"class="display">
              <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
              <span class="menu-title" >Soumissions</span>
                <i class="mdi mdi-calendar-clock menu-icon"></i>
                <!-- <i class="mdi mdi-medical-bag menu-icon"></i> -->
              </a>
              <div class="collapse" id="general-pages">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="cree_soumission.php"> Crée une soumission </a></li>
                  <li class="nav-item"> <a class="nav-link" href="soumission_en_ligne.php"> Soumissions en ligne </a></li>
                  <li class="nav-item"> <a class="nav-link" href="soumission_limite.php"> Soumissions terminées </a></li>
                  <li class="nav-item"> <a class="nav-link" href="soumission_archiver.php"> Soumissions archivées </a></li>
                </ul>
              </div>
            </li>
          </ul>
        </nav>
        <!-- partiel -->





    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js pour cette page -->
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <!-- Fin du plugin js pour cette page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- JS personnalisé pour cette page -->
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- Fin du JS personnalisé pour cette page -->

    <!-- JS for table-data -->
    <script src="JS/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" charset="utf8" src="JS/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="JS/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <!-- end JS for table-data -->
    <?php
            
          }
     ?>
  </body>
</html>
