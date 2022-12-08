<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
   
    if (!isset($_SESSION["loggedin"])) {
        echo '<script> location.replace("login.php"); </script>';
    }
if (isset($_POST["submit"])) {
    $sName=$_POST['sName'];
    $sPost=$_POST['sPost'];
    $sBDate=$_POST['sBDate'];
    $sCode=$_POST['sCode'];
    $sPassword=$_POST['sPassword'];
    $sEmail=$_POST['sEmail'];
    $sEmail2=$_POST['sEmail2'];
    $sTel=$_POST['sTel'];
    $sHA=$_POST['sHA'];
    $sInternal=$_POST['sInternal'];
    $sIsActive=1;
    $sLastModifiedBy=$_POST['sLastModifiedBy'];
    $sLastModifiedAt=date("Y-m-d");
   
    $sql = "INSERT INTO staff (sName,sCode,sPassword,sEmail,sEmail2,sTel,sPost,
	sBDate,sHA,sInternal,sIsActive, sLastModifiedAt, sLastModifiedBy) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo '<script> location.replace("staff_add.php?addstaff=stmtfailed"); </script>';
        exit();
    }
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssss",
        $sName,
        $sCode,
        $sPassword,
        $sEmail,
        $sEmail2,
        $sTel,
        $sPost,
        $sBDate,
        $sHA,
        $sInternal,
        $sIsActive,
        $sLastModifiedAt,
        $sLastModifiedBy
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    echo '<script> location.replace("staff_add.php?addstaff=none"); </script>';
}
?>
<h1 class="text-center mb-5">Új munkatárs rögzítése</h1>
<form class="row g-3 " action="staff_add.php" method="post">
	<div class="col-md-6 col-lg-3">
		<label for="name" class="form-label">Név*</label>
		<input name="sName" type="text" title="Csak betűk használata lehetséges"
			pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ\s.]*$" class="form-control" id="name"
			placeholder="Vezetéknév Keresztnév" required>
	</div>

	<div class="col-md-6 col-lg-3 ">
		<label for="sPost" class="form-label">Beosztás/Pozíció*</label>
		<input name="sPost" title="Csak betűk, szóközök és számok használata lehetséges"
			pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ0-9.]*$$" placeholder="Utánpótlás masszőr" value="" type="text"
			class="form-control" id="sPost" required>
	</div>

	<div class=" col-md-4 col-lg-2">
		<label for="bdate" class="form-label">Születési dátum</label>
		<input name="sBDate" type="date" max="9999-11-11" title="" class="form-control" id="bdate">
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="code" class="form-label">MKSZ személykód</label>
		<input name="sCode" type="number" class="form-control" min=100 max=999999 id="code"
			placeholder="MKSZ személykód">
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="pwd" class="form-label">MKSZ jelszó</label>
		<input name="sPassword" type="text" class="form-control" id="pwd" placeholder="j3L$z0">
	</div>

	<div class="col-md-6 col-lg-3 ">
		<label for="semail1" class="form-label">Céges e-mail (mkcse)</label>
		<input name="sEmail" type="email" class="form-control" id="semail1" pattern="^[a-z0-9-_\.]+@mkcse\.hu$"
			placeholder="keresztnev.vezeteknev@mkcse.hu"
			title="Céges e-mail cím megadásakor csak mkcse mail címet lehet használni!">
	</div>
	<div class="col-md-6 col-lg-3 ">
		<label for="semail2" class="form-label">Magán e-mail (Google mail)</label>
		<input name="sEmail2" type="email" class="form-control" id="semail2" placeholder="minta@gmail.com"
			pattern="^[a-z0-9-_\.]+@gmail\.com$"
			title="Magán e-mail cím megadásakor csak Google mail címet lehet használni!">
	</div>

	<div class="col-md-6 col-lg-3 ">
		<label for="stel" class="form-label">Telefonszám</label>
		<input name="sTel" type="text" class="form-control" id="tel" placeholder="Telefonszám" pattern="^[+ 0-9]*$"
			title="Telefonszám megadásakor csak '+'-jelet, szóközt és számokat lehet használni!">
	</div>



	<div class="col-md-6 col-lg-3">
		<label for="sInternal" class="form-label">Belső érintett*</label>
		<select class="form-select" name="sInternal" id="sInternal">
			<option value="1">Igen</option>
			<option value="0">Nem</option>

		</select>
	</div>
	<div class="col-md-8 col-lg-4 ">
		<label for="sHA" class="form-label">Lakhely (település)</label>
		<input name="sHA" pattern="^[a-zA-Z0-9éáűőúöüóíÁÉÍŰÚŐÖÜÓ\s\/\,\.\;]*$"
			title="Csak betűk, számok, ',' '.' ';' és '/' jelek használata lehetséges" placeholder="Lakhely" value=""
			type="text" class="form-control" id="sHA">
	</div>
	<div class="col-md-8">
		<label for="foto" class="form-label">Arcképes fotó</label>
		<input name="sPhoto " type="url" class="form-control notm" id="foto" disabled>
	</div>

	<div class="col-md-auto mt-4 input-group ">
		<input type="hidden" name="sLastModifiedBy"
			value="<?php echo $_SESSION['useruid'];?>">
		<button type="submit" name="submit" class="btn btn-outline-primary"> Rögzítés </button>
	</div>
	<div class="mt-4 col-md-auto">

		<?php
        if (isset($_GET["addstaff"])) {
            if ($_GET["addstaff"]=="stmtfailed") {
                errorAlert("Valami nem stimmel, próbálkozz újra!", "staff_add.php", true);
            } elseif ($_GET["addstaff"]=="none") {
                errorAlert("Az új munkatárs adatai sikeresen rögzítésre kerültek!", "staff_add.php", false);
            }
        }
        ?>
	</div>
</form>

<?php
    include 'footer.php';
?>