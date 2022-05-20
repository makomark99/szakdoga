<?php include_once 'check_user.php'; ?>

<body onload="Javascript:AutoRefresh(120000);">

  <nav class=" navbar navbar-expand-md navbar-dark bg-dark mb-5 sticky-top ">
    <div class="container-fluid nav-tabs  ">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="navbar-nav ms-auto mb-0 mb-md-0 ">
        <li class="nav-item ">
          <a class="navbar-brand " data-bs-placement="bottom" title="Logo" href="index.php"><img id="logo"
              src="img\mkc_logo.png" alt="Logo"></a>
        </li>
      </ul>
      <div class="collapse navbar-collapse " id="navbar">
        <ul id="myTab" class="navbar-nav  ms-auto mb-0 mb-md-0  ">


          <?php
            if (isset($_SESSION["useruid"])) {
                echo '<li id="li1" class="nav-item ">
              <a class="nav-link text-light "href="index.php"><img 
              src="img\house-door-fill.svg" alt="Főoldal" title="Főoldal"></a>
            </li>';
                echo '<li class="nav-item ">
              <a class="nav-link text-light "   href="players.php">Játékosok</a>
            </li>';
                echo '<li class="nav-item">
              <a class="nav-link text-light  "  href="staff.php">Munkatársak</a>
            </li>';
                echo '<li class="nav-item">
              <a class="nav-link text-light "  href="equipment.php">Felszerelések</a>
            </li>';
                echo '<li class="nav-item ">
              <a class="nav-link text-light"  href="profil.php"><img 
              src="img\person-square.svg" alt="Profil" title="Profil"></a>
            </li>';
                if ($sadmin) {
                    echo '<li class="nav-item ">
            <a class="nav-link text-light "  href="manage_users.php"><img 
            src="img\fingerprint.svg" alt="Jogosultságok kezelése" title="Jogosultságok kezelése"></a>
             </li>';
                }
                echo '<li class="nav-item ">
              <a class="nav-link text-light "  href="includes/logout.inc.php"><img 
              src="img\box-arrow-right.svg" alt="Kijelentkezés" title="Kijelentkezés"></a>
            </li>';
            } else {
                echo ' <li class="nav-item ">
              <a class="nav-link text-light " href="signup.php">Regisztráció</a>
            </li>';
                echo '<li class="nav-item ">
              <a class="nav-link text-light" href="login.php"><img 
              src="img\door-open.svg" alt="Bejelentkezés" title="Bejelentkezés">
              </a>
            </li>';
            }
          ?>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container col-sm-12 ">