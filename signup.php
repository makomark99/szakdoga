<?php
  include_once 'header.php';
  include_once 'navbar.php';
?>
<script defer>
	function pwdMatchCheck() {
		let pwd1 = document.getElementById('Pass');
		let pwd2 = document.getElementById('PassR');
		result = false;
		if (pwd1.value != pwd2.value) {
			result = true;
			pwd1.setAttribute("style", "background-color:red;color:white;")
			pwd1.setAttribute("title", "Az értékek megegyeznek!")
			pwd2.setAttribute("style", "background-color:red;color:white;")
			pwd2.setAttribute("title", "Az értékek megegyeznek!")
		} else {
			result = false;
		}
		if (result) {
			Swal.fire({
				position: "center",
				type: "warning",
				title: "A két jelszó nem azonos!",
				showConfirmButton: false,
				icon: "warning",
				background: "#343a40",
				color: "#fff",
				timer: 3000
			})
			document.getElementById('btn').setAttribute("disabled", "")
		} else {
			document.getElementById('btn').removeAttribute("disabled", "")
			pwd1.removeAttribute("style", "border:2px solid red;")
			pwd2.removeAttribute("style", "border:2px solid red;")
			pwd1.removeAttribute("title", "Az értékek megegyeznek!")
			pwd2.removeAttribute("title", "Az értékek megegyeznek!")
		}
	}
</script>
<div class="container" id="signup">
	<div class="row ">
		<div class="panel panel-danger col-md-4 col-xs-10 col-sm-9 mx-auto">
			<div class="panel-heading text-center">
				<h1>Regisztrációs űrlap</h1>
			</div>
			<div class="panel-body">
				<form action="includes/signup.inc.php" method="post">
					<div class="form-group">
						<label class="mt-5" for="Wname">Teljes név*</label>
						<input id="Wname" class="form-control mb-3" type="text" name="name"
							placeholder="Vezetéknév Keresztnév" required>
					</div>
					<div class="form-group">
						<label for="Email">E-mail cím*</label>
						<input id="Email" class="form-control mb-3" type="email" name="email"
							placeholder="pelda@pelda.com" required>
					</div>
					<div class="form-group">
						<label for="Uid">Felhasználónév*</label>
						<input id="Uid" class="form-control mb-3" pattern="^[a-zA-Z0-9áéíóöőúüűÁÉÍŰÚŐÖÜÓ_-]*$"
							type="text" name="uid" placeholder="felhasznalonev" required>
					</div>
					<div class="form-group">
						<label for="Pass">Jelszó*</label>
						<input id="Pass" name="pwd" type="password" class="form-control mb-3" minlength="8"
							maxlength="30" placeholder="Jelszó" required>
					</div>
					<div class="form-group">
						<label for="PassR">Jelszó ismét*</label>
						<input onblur="pwdMatchCheck()" id="PassR" class="form-control mb-3" minlength="8"
							maxlength="30" type="password" name="pwdrepeat" placeholder="Jelszó ismét" required>
					</div>
					<div class="form-group">
						<label for="Token">Regisztrációs token*</label>
						<input id="Token" class="form-control mb-3" type="password" name="token"
							placeholder="Regisztrációs token" required>
					</div>
					<div class="panel-footer m-auto row  ">
						<button type="submit" name="submit" id="btn"
							class="btn btn-outline-primary  mb-2 col-auto">Regisztráció</button>
						<div class=" ms-auto mt-2 col-auto"><small>&copy; Mosonmagyaróvári KC</small></div>

					</div>
					<div id="error" class="text-center">
						<?php
                if (isset($_GET["error"])) { //olyan adatot ellenőriz, amit látunk az URL-ben
                    if ($_GET["error"]== "invaliduid") {
                        echo "<p class='red'> Válassz más felhasználónevet!</p>";
                    }
                    if ($_GET["error"]== "passworderror") {
                        echo "<p class='red'> A két jelszó nem azonos!</p>";
                    }
                   
                    if ($_GET["error"]== "usernametaken") {
                        echo "<p class='red'>A megadot felhasználónév, vagy e-mail cím már foglalt!</p>";
                    }
                    if ($_GET["error"]== "stmtfailed") {
                        echo "<p class='red'>Valami nem stimmel, próbálkozzon újra!</p>";
                    }
                    if ($_GET["error"]== "none") {
                        echo "<p class='green'>Sikeres regisztráció!</p>";
                    }
                    if ($_GET["error"]=="wrongtoken") {
                        echo "<p class='red'>A megadott token helytelen, vagy már nem érvényes!</p>";
                    }
                    if ($_GET["error"]=="weakpassword") {
                        echo "<p class='red'>A jelszónak tartalmaznia kell kisbetűt, nagybetűt és számot. A jelszó hossza 8-30 karakter!</p>";
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
?>