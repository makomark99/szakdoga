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
					<div class="col-auto  ">
						<label class="form-label" for="name">Játékos neve</label>
						<input name="name " id="name" type="text" class="form-control mb-2"
							placeholder="Vezetéknév Keresztnév">
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
					<hr class="m-2">
					<div class="text-center">
						<span>Legmagasabb felnőtt bajnoki osztály kiválasztása</span>
					</div>
					<div class="text-center">
						<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
							<input type="radio" class="btn-check" name="btnradio" id="nb1" autocomplete="off"
								checked="" />
							<label class="btn btn-sm  btn-outline-primary" for="nb1">NB I</label>

							<input type="radio" class="btn-check" name="btnradio" id="nb1b" autocomplete="off" />
							<label class="btn btn-sm  btn-outline-primary" for="nb1b">NB I/B</label>

							<input type="radio" class="btn-check" name="btnradio" id="otherTeam" autocomplete="off" />
							<label class="btn btn-sm  btn-outline-primary" for="otherTeam">Egyéb</label>
						</div>
					</div>
					<hr class="m-2">
					<div class="text-center">
						<span>Válogatottság kiválasztása</span>
					</div>
					<div class="text-center">
						<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
							<input type="radio" class="btn-check" name="btnradio2" id="none" autocomplete="off"
								checked="" />
							<label class="btn btn-sm btn-outline-primary" for="none">Nincs</label>

							<input type="radio" class="btn-check" name="btnradio2" id="ifi" autocomplete="off" />
							<label class="btn btn-sm  btn-outline-primary" for="ifi">Ifjúsági</label>

							<input type="radio" class="btn-check" name="btnradio2" id="junior" autocomplete="off" />
							<label class="btn btn-sm  btn-outline-primary" for="junior">Junior</label>
							<input type="radio" class="btn-check" name="btnradio2" id="felnott" autocomplete="off" />
							<label class="btn btn-sm  btn-outline-primary" for="felnott">Felnőtt</label>
						</div>
						<div class="text-center mt-1">
							<input type="radio" class="btn-check" name="btnradio2" id="upsk" autocomplete="off" />
							<label class="btn btn-sm btn-outline-primary" for="upsk">Utánpótlás strandkézilabda</label>
							<input type="radio" class="btn-check" name="btnradio2" id="fsk" autocomplete="off" />
							<label class="btn btn-sm btn-outline-primary" for="fsk">Felnőtt strandkézilabda</label>
						</div>
					</div>
					<hr class="m-2">
					<div class="text-center">
						<span>Sportakadémiába történő igazolás</span>
						<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
							<input type="radio" class="btn-check" name="btnradio3" id="other" onclick="enable()"
								checked />
							<label class="btn btn-sm btn-outline-primary" for="other">Nem</label>

							<input type="radio" class="btn-check" name="btnradio3" id="ac" onclick="disable()"
								autocomplete="off" />
							<label class="btn btn-sm btn-outline-primary" for="ac">Igen</label>
						</div>
					</div>
					<hr class="m-2">
					<table class="table">
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
					<table class="table m-0 tabe-bordered">
						<thead>
							<tr>
								<th>Játékos életkora</th>
								<th>Egyesületben eltöltött évek</th>
							</tr>
						</thead>
						<tr>
							<td id="out3"> Év</td>
							<td id="out4"> Év</td>
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
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "); //reg ex, extra space after 3 chars
		}

		function diffYear(d) {
			var today = new Date();
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();
			today = yyyy + '-' + mm + '-' + dd;
			var currentDate = new Date(today);
			var inputDate = new Date(d);
			return Math.floor(Math.abs(((currentDate.getTime() - inputDate.getTime()) / (24 * 60 * 60 *
				1000)) / 365.242199)); // hours*minutes*seconds*milliseconds
		}
		var d1 = document.getElementById('d1').value;
		var d2 = document.getElementById('d2').value;

		//to academy?
		var toAcademy = (document.getElementById('ac').checked) ? true : false;

		//next club
		var nb1 = (document.getElementById('nb1').checked) ? true : false;
		var nb2 = (document.getElementById('nb1b').checked) ? true : false;
		var otherTeam = (document.getElementById('otherTeam').checked) ? true : false;

		//international caps
		var youth = (document.getElementById('ifi').checked) ? true : false;
		var junior = (document.getElementById('junior').checked) ? true : false;
		var senior = (document.getElementById('felnott').checked) ? true : false;
		var YouthSH = (document.getElementById('upsk').checked) ? true : false;
		var SeniorSH = (document.getElementById('fsk').checked) ? true : false;

		age = diffYear(d1);
		elapsedYears = diffYear(d2);
		//NB1 -be bárhonnan
		Cost = 0;
		if (!toAcademy && nb1) {
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
		} else if (!toAcademy && nb2) {
			if (age >= 10 && age < 13) {
				Cost = 100000;
			} else if (age >= 13 && age < 15) {
				Cost = 120000;
			} else if (age >= 15 && age < 17) {
				Cost = 160000;
			} else if (age >= 17 && age < 19) {
				Cost = 200000;
			} else if (age >= 19 && age < 23) {
				Cost = 250000;
			} else Cost = 0;
		} else if (!toAcademy && otherTeam) {
			if (age >= 10 && age < 13) {
				Cost = 50000;
			} else if (age >= 13 && age < 15) {
				Cost = 70000;
			} else if (age >= 15 && age < 23) {
				Cost = 100000;
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
		//international cap odds
		if (youth) {
			Cost *= 2;
		} else if (junior) {
			Cost *= 3;
		} else if (senior) {
			Cost *= 5;
		} else if (YouthSH) {
			Cost *= 1.5;
		} else if (SeniorSH) {
			Cost *= 3;
		}

		document.getElementById("out1").innerHTML = numberWithSpaces(Math.round(Cost)) + " Ft";
		document.getElementById("out2").innerHTML = numberWithSpaces(Math.round(Cost * 1.27)) + " Ft";
		document.getElementById("out3").innerHTML = age + " Év";
		document.getElementById("out4").innerHTML = elapsedYears + " Év";
	}
</script>