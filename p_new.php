<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
   
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
    if (isset($_POST["submit"])) {
        $npName=mysqli_real_escape_string($conn, $_POST['npName']);
        $npStatusCode=$_POST['npStatusCode'];
        $npDate=date("Y-m-d");
        $npIsSigned=0;
        $npComment=$_POST['npComment'];
        $sql = "INSERT INTO new_players (npName, npStatusCode, npDate, npIsSigned, npComment) 
		VALUES(?, ?, ?, ?, ?);";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo '<script> location.replace("p_new.php?error=stmtfailed"); </script>';
            exit();
        }
        mysqli_stmt_bind_param(
            $stmt,
            "sssss",
            $npName,
            $npStatusCode,
            $npDate,
            $npIsSigned,
            $npComment
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo '<script> location.replace("p_new.php?error=none"); </script>';
        exit();
    }
    if (isset($_POST["prevStatus"])) {
        $id=$_POST["prevID"];
        $date=date("Y-m-d");
        $set="UPDATE new_players SET npStatusCode=npStatusCode-1 WHERE npID=?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $set)) {
            echo '<script> location.replace("p_new.php?prevstatus=stmtfailed"); </script>';
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        echo '<script> location.replace("p_new.php?prevstatus=none"); </script>';
    }
    if (isset($_POST["nextStatus"])) {
        $id=$_POST["nextID"];
        $actCode=$_POST['actCode'];
        $date=date("Y-m-d");
        if ($actCode==9) {
            $set="UPDATE new_players SET npStatusCode=npStatusCode+1, npSignedDate='$date' WHERE npID=?;";
        } else {
            $set="UPDATE new_players SET npStatusCode=npStatusCode+1 WHERE npID=?;";
        }
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $set)) {
            echo '<script> location.replace("p_new.php?nextstatus=stmtfailed"); </script>';
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        echo '<script> location.replace("p_new.php?nextstatus=none"); </script>';
    }
?>
<div class="container">

	<h1 class="my-3 text-center">Új játékosok nyilvántartásba vételének folyamata</h1>
	<form action="p_new.php" method="post">

		<div class="me-5 ms-5 row my-5 ">
			<label for="npName" class="text-center mb-2 fs-5">Új nyilvántartásba vételi folyamat rögzítése</label>
			<div class="col-md-4 col-lg-3 mt-1">
				<input name="npName" type="text" title="Csak betűk használata lehetséges"
					pattern="^[a-zA-Zéáűőúöüóí\s]*$" class="form-control" id="npName" placeholder="Új játékos neve"
					required>
			</div>
			<div class="col-md-8 col-lg-5 mt-1">
				<select name="npStatusCode" class="form-select" required>
					<option value="0">Jelentkezési űrlap szülő által kitöltve</option>
					<option value="1">Űrlap adatok, feltöltött dokumentumok ellenőrizve</option>
					<option value="2">MKSZ rendszerbe rögzítve új játékosként</option>
					<option value="3">Igazolólap kinyomtatva, edzőnek odaadva</option>
					<option value="4">Igazolólap szülő és játékos által aláírva, edzőtől visszakapva</option>
					<option value="5">Dokumentumok pecsételve és aláíratva a jogosut személyjel</option>
					<option value="6">Aláírt dokumentumok beszkennelve, ellenőrizve</option>
					<option value="7">Aláírt dokumentumok egyesítve, feltöltve MKSZ rendszerbe</option>
					<option value="8">MKSZ által jóváhagyva</option>
					<option value="9">Igazolás kép feltöltve, jóváhagyásra vár</option>
					<option value="10">Kép jóváhagyva, amatőr/tagsági szerződés feltöltve</option>
				</select>
			</div>
			<div class="col-md-4 col-lg-3 mt-1">
				<input name="npComment" type="text" class="form-control" id="npComment" placeholder="Megjegyzés">
			</div>
			<div class="col-md-4 col-lg-1 me-auto mt-1">
				<button type="submit" name="submit" class="btn btn-outline-primary">Rögzítés</button>
			</div>
		</div>
	</form>
	<!-- Komponens -->
	<?php
    $status=array("Jelentkezési űrlap szülő által kitöltve","Űrlap adatok, feltöltött dokumentumok ellenőrizve","MKSZ rendszerbe rögzítve új játékosként",
    "Igazolólap kinyomtatva, edzőnek odaadva","Igazolólap szülő és játékos által aláírva, edzőtől visszakapva","Dokumentumok pecsételve és aláíratva a jogosut személyjel"
    ,"Aláírt dokumentumok beszkennelve, ellenőrizve","Aláírt dokumentumok egyesítve, feltöltve MKSZ rendszerbe","MKSZ által jóváhagyva",
    "Igazolás kép feltöltve, jóváhagyásra vár","Kép jóváhagyva, amatőr/tagsági szerződés feltöltve");
    $sql="SELECT * FROM new_players ORDER BY npIsSigned, npDate DESC;";
                    $result=mysqli_query($conn, $sql);
                    $queryResults=mysqli_num_rows($result);
                    if ($queryResults>0) {
                        while ($row=mysqli_fetch_assoc($result)) {
                            ?>
	<div class="row" style="width:90%;">
		<label class="col-md-3 mt-3 me-2"><b>Név:</b>
			<?php echo $row['npName'] ?></label>
		<label class="col-md-3 mt-3 me-2"><b>Bejegyezve:</b>
			<?php echo $row['npDate']; ?></label>
		<label class="col-md-3 mt-3 me-2"><b>Megjegyzés:</b>
			<?php echo $row['npComment']; ?></label>
		<label class="col-md-6 mt-3 "><b>Aktuális folyamat:</b>
			<?php echo $status[$row['npStatusCode']]; ?></label>
		<label class="col-md-6 mt-3"><b>Következő folyamat:</b>
			<?php echo ($row['npStatusCode']!=10)? $status[$row['npStatusCode']+1] : "Nincs"; ?></label>
	</div>
	<form action="p_new.php" method="post">
		<div class="row mt-1 mb-3">
			<div class="col-md-12 d-flex">

				<button type="submit" name="prevStatus"
					class="btn btn-outline-primary me-1 col-md-auto me-auto <?php  echo ($row['npStatusCode']==0)? 'disabled':'';
                            echo ($row['npStatusCode']==10)? 'd-none':''?>">
					< </button>
						<input type="hidden" name="prevID"
							value="<?php echo $row['npID']; ?>">
						<div class="my-auto progress col-sm-11 col-md-10 mx-auto " style="height: 20px; width:90%;">
							<div class="progress-bar " role="progressbar" aria-label="Example with label"
								aria-valuenow="<?php echo $row['npStatusCode']; ?>"
								style="width: <?php echo $row['npStatusCode']*10; ?>%;"
								aria-valuemin="0" aria-valuemax="10"><span
									class="fs-6 "><?php echo $row['npStatusCode']*10; ?>%<span>
							</div>
						</div>
						<button type="submit" name="nextStatus"
							class="ms-1 btn btn-outline-primary col-md-auto ms-auto <?php  echo ($row['npStatusCode']==10)? 'd-none':''?>">></button>
						<input type="hidden" name="nextID"
							value="<?php echo $row['npID']; ?>">
						<input type="hidden" name="actCode"
							value="<?php echo $row['npStatusCode']; ?>">

			</div>
		</div>
	</form>
	<hr class="border border-warning border-2 opacity-75">
	<?php
                        }
                    }?>
	<!-- Komponens -->
</div>
<?php
if (isset($_GET["error"])) {
                        if ($_GET["error"]=="stmtfailed") {
                            errorAlert("Valami nem stimmel, próbálkozz újra!", "p_new.php", true);
                        } elseif ($_GET["error"]=="none") {
                            errorAlert("Az új nyilvántartásba vételi folyamat sikeresen rögzítve!", "p_new.php", false);
                        }
                    }
                    if (isset($_GET["nextstatus"])||isset($_GET["prevstatus"])) {
                        if (($_GET["nextstatus"]=="stmtfailed")||$_GET["prevstatus"]=="stmtfailed") {
                            errorAlert("Valami nem stimmel, próbálkozz újra!", "p_new.php", true);
                        } elseif (($_GET["nextstatus"]=="none")||($_GET["prevstatus"]=="none")) {
                            errorAlert("A nyilvántartásba vételi folyamat sikeresen frissítve !", "p_new.php", false);
                        }
                    }
?>