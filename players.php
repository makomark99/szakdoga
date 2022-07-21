<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
?>
<div class="col-md-12 ">
	<div class="d-flex justify-content-end ">
		<div class=" d-flex col-md-4 col-sm-5">
			<input class="form-control me-2" type="text" name="search" id="search"
				placeholder="Játékos keresése név, vagy személy kód alapján" autofocus>
		</div>
		<a href="detailed.php" title="Szűrő" class="btn btn-outline-primary me-2">
			<?php include "img/filter.svg"?>
		</a>
		<form class="m-0" action="livesearch.php" method="post">
			<button class="btn btn-outline-primary me-2 " title=" Távozók" type="submit" name="leavers">
				<?php include "img/leave.svg"?>
			</button>
		</form>

		<!-- Button trigger modal -->
		<a title="Kinevelési költség számítása" class="btn btn-outline-primary me-2" data-bs-toggle="modal"
			data-bs-target="#calculate">
			<?php include_once 'img/calculator.svg' ?>
		</a>

		<a href="p_add.php" title="Játékos hozzáadása" class="btn btn-outline-primary me-2">
			<?php include "img/plus-lg.svg"?>
		</a>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="calculate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-dialog-centered">
		<div class="modal-content text-dark fs-5">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Kinevelési költség kalkulátor</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="palyers.php" method="post">
				<div class="modal-body">
					<div class="col-auto ">
						<label class="form-label  " for="">Játékos neve</label>
						<input name="name " type="text" class="form-control mb-2" placeholder="Vezetéknév Keresztnév">
					</div>
					<div class="row g-2 d-flex">
						<div class="col-md-6">
							<label class="form-label " for="">Játékos születési dátuma</label>
							<input name="date" value="" placeholder="éééé.hh.nn." id="d1" type="text"
								onfocus="(this.type='date')"
								max="<?php echo date("Y-m-d"); ?>"
								class="form-control mb-2">
						</div>
						<div class="col-md-6">
							<label class="form-label " for="">Előző igazolás dátuma</label>
							<input name="date" value="" placeholder="éééé.hh.nn." id="d2" type="text"
								onfocus="(this.type='date')"
								max="<?php echo date("Y-m-d"); ?>"
								class="form-control mb-2">
						</div>
					</div>
					<div class="form-check mt-2">
						<input class="form-check-input" type="checkbox" name="" id="" disabled checked>
						<label class="form-check-label" for="flexRadioDefault1">
							Legmagasabb felnőtt bajnoki osztály: NB I.
						</label>
					</div>
					<div class="form-check mt-2">
						<input class="form-check-input" type="checkbox" name="" id="" disabled>
						<label class="form-check-label" for="flexRadioDefault1">
							Válogatottság
						</label>
					</div>
					<div class="form-check mt-2">
						<input class="form-check-input" onclick="disable()" type="radio" name="ac" id="ac">
						<label class="form-check-label" for="ac">
							Akadémiába igazol
						</label>
					</div>
					<div class="form-check mt-2">
						<input class="form-check-input" onclick="enable()" type="radio" name="ac" id="other" checked>
						<label class="form-check-label" for="other">
							Egyéb sportszervezetbe igazol
						</label>
					</div>
					<table class="table mt-2">
						<thead>
							<tr>
								<th>Nettó összeg</th>
								<th>Bruttó összeg</th>
							</tr>
						</thead>
						<tr>
							<td id="out1"> Ft</td>
							<td id="out2"> Ft</td>
						</tr>
					</table>

				</div>
				<div class="modal-footer ">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
					<button type="button" id="calc" value="submit" onclick="calculate()"
						class="btn btn-primary">Számítás</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="output">

</div>

<?php
  include_once 'footer.php';
?>
<!--<script src="row_click.js"></script> -->
<script>
	function disable() {
		document.getElementById('d2').setAttribute("disabled", "")
	}

	function enable() {
		document.getElementById('d2').removeAttribute("disabled", "")
	}

	function calculate() {
		function numberWithSpaces(x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "); //reg ex
		}

		function diffYear(d) {
			let today = new Date();
			let dd = String(today.getDate()).padStart(2, '0');
			let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			let yyyy = today.getFullYear();
			today = yyyy + '-' + mm + '-' + dd;
			let currentDate = new Date(today);
			let inputDate = new Date(d);
			return Math.floor(Math.abs(((currentDate.getTime() - inputDate.getTime()) / (24 * 60 * 60 *
				1000)) / 365.242199)); // hours*minutes*seconds*milliseconds
		}
		let d1 = document.getElementById('d1').value;
		let d2 = document.getElementById('d2').value;
		let toAcademy = (document.getElementById('ac').checked) ? true : false;
		age = diffYear(d1);
		elapsedYears = diffYear(d2);
		//NB1 -be bárhonnan
		Cost = 0;
		if (!toAcademy) {
			if (age >= 10 && age < 13) {
				Cost = 150000;
			} else if (age >= 13 && age < 15) {
				Cost = 200000;
			} else if (age >= 15 && age < 17) {
				Cost = 300000;
			} else if (age >= 17 && age < 19) {
				Cost = 350000;
			} else if (age >= 19 && age < 21) {
				Cost = 400000;
			} else if (age >= 21 && age < 23) {
				Cost = 450000;
			} else Cost = 0;
		} else { //akadémiába bárhonnan
			if (age < 15) {
				Cost = 2000000;
			} else if (age >= 15 && age < 17) {
				Cost = 3000000;
			} else if (age >= 17 && age < 19) {
				Cost = 4000000;
			} else if (age >= 19 && age < 21) {
				Cost = 5000000;
			}
		}
		if ((!toAcademy) && (elapsedYears > 3)) {
			Cost = Cost * Math.pow(1.20, elapsedYears - 3);
		}
		document.getElementById("out1").innerHTML = numberWithSpaces(Math.round(Cost)) + " Ft";
		document.getElementById("out2").innerHTML = numberWithSpaces(Math.round(Cost * 1.27)) + " Ft";
	}

	let search = document.getElementById("search");
	setTimeout(() => {
		search.submit();
	}, 30)
</script>