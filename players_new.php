<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
   
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
?>
<div class="container">
	<h1 class="my-3 text-center">Új játékosok nyilvántartásba vételének folyamata</h1>
	<label class="mt-5 me-5" for="name">Játékos Neve</label>
	<label class="mt-3 me-5" for="name">Bejegyezve: 2022.10.07</label>
	<label class="mt-3 me-5" for="name">Előző befejezett folyamat: Dokumentumok kinyomtatása</label>
	<label class="mt-3" for="name">Következő folyamat: Dokumentumok aláíratása a szülőkkel</label>

	<div class="mt-2 progress">
		<div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 25%;"
			aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
	</div>

	<label class="mt-5 me-5" for="name">2.Játékos Neve</label>
	<label class="mt-3 me-5" for="name">Bejegyezve: 2022.10.03</label>
	<label class="mt-3 me-5" for="name">Előző befejezett folyamat: Dokumentumok aláíratása</label>
	<label class="mt-3" for="name">Következő folyamat: Dokumentumok beszkennelése</label>

	<div class="mt-2 progress">
		<div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 60%;"
			aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
	</div>
</div>