<?php
  include_once 'header.php';
  include_once 'navbar.php';
?>

<div class="container" id="signup">
	<div class="row">
		<div class="panel col-lg-4 col-md-6 col-sm-8 mx-auto">
			<div class="panel-heading text-center ">
				<h1 class="animate__animated animate__bounceInDown"> Bejelentkezés</h1>
				<img class="mx-auto mt-4 animate__animated animate__heartBeat " id="logo2" src="img\mkc_logo.png"
					alt="logo">
			</div>
			<div class="panel-body">
				<form action="includes/login.inc.php" method="post">
					<div class="form-group mt-5 ">
						<label class="animate__animated animate__bounceInLeft" for="Uid">Felhasználónév*</label>
						<input id="Uid" class="form-control mb-3 fs-5 animate__animated animate__bounceInRight"
							type="text" pattern="^[a-zA-Z0-9 \@]*$"
							title="A felhasználónév csak betűket, számokat és @ jelet tartalmazhat!" name="uid"
							placeholder="Felhasználónév/E-mail" required>
					</div>
					<div class="form-group ">
						<label class="animate__animated animate__bounceInRight" for="Pass">Jelszó*</label>
						<input id="Pass" class="form-control mb-3 fs-5 animate__animated animate__bounceInLeft"
							type="password" name="pwd" placeholder="Jelszó" required>
					</div>
					<div class="panel-footer m-auto row ">
						<button type="submit " name="submit"
							class="btn btn-outline-primary mb-3 col-auto animate__animated animate__bounceInUp">Bejelentkezés</button>
						<div class="ms-auto mt-2 col-auto animate__animated animate__bounceInUp"><small>&copy;
								Mosonmagyaróvári
								KC</small></div>
					</div>
					<div class="text-center animate__animated animate__zoomInUp">
						<?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"]== "wronglogin") {
                        echo "<p class='red'>Hibás felhasználónév, vagy jelszó!</p>";
                    }
                }
              ?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
  include_once 'footer.php';
