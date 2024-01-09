<!DOCTYPE html>
<html lang="fr">

<head>
  <!-- Balises meta requises -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
  <script src="../JS/sweetalert2.js"></script>
  <style>
    .logo {
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
  <?php
  $email = $_SESSION['email'];
  include("../connexion.php");
  $req = mysqli_query($conn, "SELECT * FROM etudiant WHERE email = '$email'");
  $row = mysqli_fetch_assoc($req);

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
              <img src="../images/supnum.jpg" alt="image" title="<?= $row['nom'] . " " . $row['prenom'] ?>">
              <span class="availability-status online"></span>
            </div>
            <div class="nav-profile-text">
              <p class="mb-1 text-black"><?php echo $row['nom'] . " " . $row['prenom'] ?></p>
              <center><b>(Etudiant)</b></center>
            </div>
          </a>
          <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">

            <!-- <div class="container mt-12"> </div> -->


            <div class="logo">

              <img title="<?= $row['nom'] . " " . $row['prenom'] ?>" id="myButton" class="style-scope yt-img-shadow" src="../images/supnum.jpg" draggable="false" style="width: 40px; height: 40px; border-radius: 50%;">
              <p></p>
              <a> <strong class='font-weight-bold'><?= $row['nom'] . " " . $row['prenom'] ?></strong></a>

              <p><?= $row['email'] ?></p>
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

        <li class="nav-item">
          <a class="nav-link" href="choix_semestre.php">
            <span class="menu-title">Accueil</span>
            <i class="mdi mdi-home menu-icon"></i>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="notes.php">
            <span class="menu-title">Notes</span>
            <i class="mdi mdi-clipboard-text menu-icon"></i>
          </a>
        </li>
        


      </ul>
    </nav>



    <!-- plugins:js -->
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