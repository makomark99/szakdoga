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
		<a title="Kinevelési költség számítása" id="calcModal" class="btn btn-outline-primary me-2"
			data-bs-toggle="modal" data-bs-target="#calculate">
			<?php include_once 'img/calculator.svg' ?>
		</a>
		<a title="Új játékosok nyilvántartásba vétele" href="players_new.php" id="newPlayers"
			class="btn btn-outline-primary me-2">
			<?php include_once 'img/person-plus.svg' ?>
		</a>
		<a href="p_add.php" title="Játékos hozzáadása" class="btn btn-outline-primary me-2">
			<?php include "img/plus-lg.svg"?>
		</a>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="calculate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content  text-dark fs-5">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Kinevelési költség kalkulátor</h3>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body ">
				<div class="col-auto  ">
					<label class="form-label" for="name">Játékos neve</label>
					<input name="name " id="name" type="text" class="form-control mb-2 calcInput"
						placeholder="Vezetéknév Keresztnév">
				</div>
				<div class="row g-2 d-flex">
					<div class="col-md-6">
						<label class="form-label " for="">Játékos születési dátuma</label>
						<input name="birth" value="" placeholder="éééé.hh.nn." id="d1" type="date"
							onfocus="(this.type='text')" required
							max="<?php echo date("Y-m-d"); ?>"
							class="form-control mb-2 calcInput">

					</div>
					<div class="col-md-6">
						<label class="form-label " for="">Előző igazolás dátuma</label>
						<input name="lastConctract" value="" placeholder="éééé.hh.nn." id="d2" type="date"
							onfocus="(this.type='text')" required
							max="<?php echo date("Y-m-d"); ?>"
							class="form-control mb-2 calcInput">
					</div>
				</div>
				<hr class="m-2">
				<div class="text-center">
					<span>Legmagasabb felnőtt bajnoki osztály kiválasztása</span>
				</div>
				<div class="text-center">
					<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
						<input type="radio" class="btn-check " name="btnradio" id="nb1" autocomplete="off" checked="" />
						<label class="btn btn-sm  btn-outline-primary" for="nb1">NB I</label>

						<input type="radio" class="btn-check " name="btnradio" id="nb1b" autocomplete="off" />
						<label class="btn btn-sm  btn-outline-primary" for="nb1b">NB I/B</label>

						<input type="radio" class="btn-check " name="btnradio" id="otherTeam" autocomplete="off" />
						<label class="btn btn-sm  btn-outline-primary" for="otherTeam">Egyéb</label>
					</div>
				</div>
				<hr class="m-2">
				<div class="text-center">
					<div>Válogatottság kiválasztása
						<a type="button" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-title="Válogatottság után járó szorzó akkor vehető figyelembe, ha a játékos legalább 3
								hivatalos válogatott mérkőzésen szerepelt a jegyzőkönyvvben."><?php include "img/info-square.svg";?>
						</a>
					</div>
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
					<div>Sportakadémiába történő igazolás
						<a type="button" data-bs-toggle="tooltip" data-bs-placement="left"
							data-bs-title="Ha a játékos kevesebb mint 3 évet töltött az előző sportszervezetben, akkor az összeg 70%-a illeti meg az átadó sportszervezetet."><?php include "img/info-square.svg";?>
						</a>
					</div>
					<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
						<input type="radio" class="btn-check" name="btnradio3" id="other" onclick="enable()" checked />
						<label class="btn btn-sm btn-outline-primary" for="other">Nem</label>

						<input type="radio" class="btn-check" name="btnradio3" id="ac" onclick="disable()"
							autocomplete="off" />
						<label class="btn btn-sm btn-outline-primary" for="ac">Igen</label>
					</div>
				</div>
				<hr class="m-2">
				<table class="table table-bordered border border-secondary border-1">
					<thead>
						<tr>
							<th>Nettó alapdíj</th>
							<th>Nettó összeg</th>
							<th>Bruttó összeg</th>
						</tr>
					</thead>
					<tr>
						<td class="info" id="out0"> Ft</td>
						<td class="info" id="out1"> Ft</td>
						<td class="info" id="out2"> Ft</td>
					</tr>
				</table>
				<table class="table m-0 table-bordered border border-secondary border-1">
					<thead>
						<tr>
							<th>Életkor</th>
							<th>Egyesületben eltöltött évek</th>
							<th>Szorzó</th>
						</tr>
					</thead>
					<tr>
						<td class="info" id="out3"> Év</td>
						<td class="info" id="out4"> Év</td>
						<td class="info" id="out5"> </td>
					</tr>
				</table>
			</div>

			<div class="modal-footer ">

				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
				<button type="submit" id="reset" value="button" onclick="reset()"
					class="btn btn-danger">Alaphelyzet</button>
				<button type="submit" id="calc" value="submit" onclick="calculate()"
					class="btn btn-primary">Számítás</button>

			</div>
		</div>
	</div>
</div>

<div id="output">

</div>

<?php
  include_once 'footer.php';
?>
<script src="test.js"></script>
<!--<script src="row_click.js"></script> -->

<script>
	function disable() {
		document.getElementById('nb1').setAttribute("disabled", "")
		document.getElementById('nb1b').setAttribute("disabled", "")
		document.getElementById('otherTeam').setAttribute("disabled", "")
	}

	function enable() {
		document.getElementById('nb1').removeAttribute("disabled", "")
		document.getElementById('nb1b').removeAttribute("disabled", "")
		document.getElementById('otherTeam').removeAttribute("disabled", "")

	}

	function calculate() {

		function numberWithSpaces(x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " "); //reg ex, extra space after 3 chars
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

		//to academy?
		let toAcademy = (document.getElementById('ac').checked) ? true : false;

		//next club
		let nb1 = (document.getElementById('nb1').checked) ? true : false;
		let nb2 = (document.getElementById('nb1b').checked) ? true : false;
		let otherTeam = (document.getElementById('otherTeam').checked) ? true : false;

		//international caps
		let youth = (document.getElementById('ifi').checked) ? true : false;
		let junior = (document.getElementById('junior').checked) ? true : false;
		let senior = (document.getElementById('felnott').checked) ? true : false;
		let YouthSH = (document.getElementById('upsk').checked) ? true : false;
		let SeniorSH = (document.getElementById('fsk').checked) ? true : false;

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
		let basicFee = Cost;
		let odds = 1;
		if ((!toAcademy) && (elapsedYears >= 3)) {
			odds = Math.pow(1.20, elapsedYears - 2)
			Cost *= odds;

		} else if (toAcademy && elapsedYears < 3) {
			odds = 0.7;
			Cost *= odds;
		}
		//international cap odds
		icOdds = 1;
		if (youth) {
			icOdds = 2;
			Cost *= icOdds;
		} else if (junior) {
			icOdds = 3;
			Cost *= icOdds;
		} else if (senior) {
			icOdds = 5;
			Cost *= icOdds;
		} else if (YouthSH) {
			icOdds = 1.5;
			Cost *= icOdds;
		} else if (SeniorSH) {
			icOdds = 3;
			Cost *= icOdds;
		}

		document.getElementById("out0").innerHTML = numberWithSpaces(Math.round(basicFee)) + " Ft";
		document.getElementById("out1").innerHTML = numberWithSpaces(Math.round(Cost)) + " Ft";
		document.getElementById("out2").innerHTML = numberWithSpaces(Math.round(Cost * 1.27)) + " Ft";
		document.getElementById("out3").innerHTML = isNaN(age) ? 0 : age + " Év";
		document.getElementById("out4").innerHTML = isNaN(elapsedYears) ? 0 : elapsedYears + " Év";
		document.getElementById("out5").innerHTML = isNaN(elapsedYears) ? 1 : (odds * icOdds).toFixed(
			5);

	}
</script>