<?php

?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- Balises meta requises -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <!-- Styles de mise en page -->
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Fin des styles de mise en page -->
  <link rel="shortcut icon" href="assets/images/favicon.ico" />


  <!-- jQuery UI CSS Reference -->
  <link href="Content/themes/base/jquery-ui.min.css" rel="stylesheet" />
  <script src="Scripts/jquery-1.12.4.js"></script>
  <script src="Scripts/jquery-ui-1.12.1.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/commun.js"></script>
  <script src="js/sweetalert2.js"></script>



  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="CSS/style.css" rel="stylesheet">

</head>

<body>
  <?php
  if ($_SESSION["role"] == "ens") {
    $email = $_SESSION['email'];
    include("connexion.php");
    $req = mysqli_query($conn, "SELECT * FROM enseignant WHERE email = '$email'");
    $row = mysqli_fetch_assoc($req);
  ?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right">

            <li id="potfolio" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="index_enseignant.php">Matieres</a>
            </li>
            <li id="potfolio" class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#">Soumission</a>
              <ul class="dropdown-menu">
                <li>
                  <a href="cree_soumission.php">Crée une soumission </a>
                </li>
                <li>
                  <a href="soumission_en_ligne.php">Soumission en ligne</a>
                </li>
                <li>
                  <a href="soumission_limite.php">Soumission terminer</a>
                </li>
                <li>
                  <a href="soumission_archiver.php">Soumission archifer</a>
                </li>
              </ul>
            <li class="dropdown">

              <!-- <div class="container mt-12"> </div> -->
              <a href="#"><img title="<?= $row['nom'] . " " . $row['prenom'] ?>" id="myButton" class="style-scope yt-img-shadow" src="../images/supnum.jpg" draggable="false" style="width: 32px; height: 32px; border-radius: 50%;"></a>

              <ul class="dropdown-menu">
                <li>
                  <br>
                  <div class="logo">
                    <img title="<?= $row['nom'] . " " . $row['prenom'] ?>" id="myButton" class="style-scope yt-img-shadow" src="../images/photo_ens.jpg" draggable="false" style="width: 40px; height: 40px; border-radius: 50%;">
                    <p></p>
                    <a> <strong class='font-weight-bold'><?= $row['nom'] . " " . $row['prenom'] ?></strong></a>

                    <p><?= $row['email'] ?></p>
                  </div>
                </li>
                <li>
                  <a href="#">Gérer votre compte</a>
                </li>
                <li>
                  <a href="#"></a>
                </li>
                <li>
                  <a href="supprimer_session.php">Se déconnecte</a>
                </li>
              </ul>
            </li>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    <br><br>

  <?php

  } else if ($_SESSION["role"] == "admin") {
  ?>
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
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
                <img src="assets/images/faces/face1.jpg" alt="image">
                <span class="availability-status online"></span>
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">Bechir Mady</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="#">
                <i class="mdi mdi-logout me-2 text-primary"></i> Déconnexion </a>
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

          <li class="nav-item">
            <a class="nav-link" href="index.html">
              <span class="menu-title">Accueil</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/icons/mdi.html">
              <span class="menu-title">À faire</span>
              <i class="mdi mdi-calendar-clock menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/icons/mdi.html">
              <span class="menu-title">Notes</span>
              <i class="mdi mdi-clipboard-text menu-icon"></i>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partiel -->

      <!-- Fin de la zone du corps de la page -->
    </div>
  <?php
  } else {
    include("connexion.php");
    $email = $_SESSION['email'];
    $req_etud = mysqli_query($conn, "SELECT * FROM etudiant WHERE email = '$email'");
    $row_etud = mysqli_fetch_assoc($req_etud);

  ?>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar">hello</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav navbar-right">


            <li id="potfolio" class="dropdown">
              <a href="index_etudiant.php">Accueil</a>
            </li>

            <li class="dropdown">

              <a href="#"><img title="<?= $row_etud['nom'] . " " . $row_etud['prenom'] ?>" id="myButton" class="style-scope yt-img-shadow" src="../images/supnum.jpg" draggable="false" style="width: 32px; height: 32px; border-radius: 50%;"></a>

              <ul class="dropdown-menu">
                <li>
                  <br>
                  <div class="logo">
                    <img title="<?= $row_etud['nom'] . " " . $row_etud['prenom'] ?>" id="myButton" class="style-scope yt-img-shadow" src="../images/photo_ens.jpg" draggable="false" style="width: 40px; height: 40px; border-radius: 50%;">
                    <p></p>
                    <a> <strong class='font-weight-bold'><?= $row_etud['nom'] . " " . $row_etud['prenom'] ?></strong></a>

                    <p><?= $row_etud['email'] ?></p>
                  </div>
                </li>
                <li>
                  <a href="#">Gérer votre compte</a>
                </li>
                <li>
                  <a href="#"></a>
                </li>
                <li>
                  <a href="supprimer_session.php">Se déconnecte</a>
                </li>
              </ul>
            </li>
          </ul>
          </ul>


          <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
  <?php
  }
  ?>
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js pour cette page -->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- Fin du plugin js pour cette page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/misc.js"></script>
  <!-- endinject -->
  <!-- JS personnalisé pour cette page -->
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- Fin du JS personnalisé pour cette page -->
</body>

</html>