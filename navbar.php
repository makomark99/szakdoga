<?php
include_once 'check_user.php';
include_once 'includes/SweetAlert.php';

?>

<body>

	<nav class=" navbar navbar-expand-lg navbar-dark bg-dark mb-5 sticky-top ">
		<div class="container-fluid nav-tabs  ">
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			<ul class="navbar-nav ms-auto mb-0 mb-md-0 ">
				<li class="nav-item ">
					<a class="navbar-brand d-flex align-items-center" data-bs-placement="bottom"
						data-bs-toggle="tooltip" data-bs-title="logo" href="index.php">
						<div><img id="logo" src="img\mkc_logo.png" alt="Logo"></div>
						<div class="ms-2">MKC - Back Office</div>
					</a>
				</li>
			</ul>
			<div class="collapse navbar-collapse " id="navbar">
				<ul id="myTab" class="navbar-nav  ms-auto mb-0 mb-md-0  ">


					<?php
            if (isset($_SESSION["useruid"])) {
                echo '<li id="li1" class="nav-item">
              <a class="nav-link text-light "href="index.php" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Főoldal"> <img alt="Főoldal"
              src="img\house-door-fill.svg" ></a>
            </li>';
                echo '<li class="nav-item ">
              <a class="nav-link text-light " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Játékosok"  href="players.php"><img 
              src="img\handball.svg" alt="Játékosok" ></a>
            </li>';
                echo '<li class="nav-item">
              <a class="nav-link text-light  " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Munkatársak" href="staff.php"><img 
              src="img\teamwork.svg" alt="Munkatársak" ></a>
            </li>';
                if ($sadmin) {
                    echo '<li class="nav-item ">
            <a class="nav-link text-light " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Jogosultságok kezelése" href="manage_users.php"><img 
            src="img\fingerprint.svg" alt="Jogosultságok kezelése"></a>
             </li>';
                }
                echo '<li class="nav-item ">
              <a class="nav-link text-light " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kijelentkezés" href="includes/logout.inc.php"><img 
              src="img\box-arrow-right.svg" alt="Kijelentkezés" ></a>
            </li>';
            } else {
                echo ' <li class="nav-item ">
              <a class="nav-link text-light " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Regisztráció" href="signup.php"><img 
              src="img\register.svg" alt="Regisztráció" ></a>
            </li>';
                echo '<li class="nav-item ">
              <a class="nav-link text-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Bejelentkezés" href="login.php"><img 
              src="img\door-open.svg" alt="Bejelentkezés">
              </a>
            </li>';
            }
          ?>

				</ul>
			</div>
		</div>
	</nav>

	<div class="container col-sm-12 ">