<?php
    include_once 'includes/dbh.inc.php';
    include_once 'includes/dbh.inc.php';
    include_once 'header.php';
    include_once 'check_user.php';
    
    if (isset($_POST["modifyStaff"])) {
        $id=$_POST["modifyID"];
        $sCode=$_POST['sCode'];
        $sEmail=$_POST['sEmail'];
        $sEmail2=$_POST['sEmail2'];
        $sTel=$_POST['sTel'];
        $sPost=$_POST['sPost'];
        $set="UPDATE staff SET sCode='$sCode', sEmail='$sEmail' sEmail2='$sEmail2' 
		sTel='$sTel' sPost='$sPost' WHERE sId=?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $set)) {
            echo '<script> location.replace("staffsearch.php?modifystaff=stmtfailed"); </script>';
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        echo '<script> location.replace("staffsearch.php?modifystaff=none"); </script>';
    }
    if (isset($_POST["deleteStaff"])) {
        $id=$_POST["deleteID"];
        $date=date("Y-m-d");
        $delete="UPDATE staff SET sIsActive=0, sLeavingAt='$date' WHERE sId=?;";
        $stmt2=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt2, $delete)) {
            echo '<script> location.replace("staffsearch.php?deletestaff=stmtfailed"); </script>';
            exit();
        }
        mysqli_stmt_bind_param($stmt2, 's', $id);
        mysqli_stmt_execute($stmt2);
        echo '<script> location.replace("staffsearch.php?deletestaff=none"); </script>';
    }
    

    $search=mysqli_real_escape_string($conn, $_POST['name']);
    $sql = "SELECT * FROM staff WHERE sName LIKE '%$search%'";
    $result=mysqli_query($conn, $sql);
    $queryResults=mysqli_num_rows($result);
    $th=1;
    if ($queryResults>0) {
        echo "<h3 class='mt-2'>A keresésnek $queryResults találata van!</h3>"; ?>

<div class="container-fluid mt-4">
	<h1 class="text-center m-4">Munkatársak adatai</h1>
	<table class="table table-dark table-hover">
		<thead class="thead-light">
			<tr>
				<th>#</th>
				<th>Név</th>
				<th>Személy kód</th>
				<th>Belső E-mail</th>
				<th>E-mail</th>
				<th>Telefonszám</th>
				<th>Beosztás</th>
				<th
					class="<?php echo ($sadmin)? : 'd-none'; ?>">
					Műveletek</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row=mysqli_fetch_assoc($result)) {
            ?>

			<tr
				style='<?php echo (!$sadmin) ?  : "font-size:90%;"; ?>'>

				<td class="align-middle"> <?php echo $th++; ?>
				</td>
				<td class="align-middle">
					<?php echo $row['sName']; ?>
				</td>
				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input name="sCode" style="width:80px;"
						value="<?php echo $row['sCode']; ?>"
						class="form-control text-white bg-secondary form-control-sm " min=100 max=999999 type="number">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sCode']; ?>
				</td>
				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input name="sEmail" style="width:180px;"
						value="<?php echo $row['sEmail']; ?>"
						class="form-control text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sEmail']; ?>
				</td>
				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input name="sEmail2" style="width:225px;"
						value="<?php echo $row['sEmail2']; ?>"
						class="form-control text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sEmail2']; ?>
				</td>

				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input name="sTel" style="width:125px;"
						value="<?php echo $row['sTel']; ?>"
						class="form-control  text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sTel']; ?>
				</td>


				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input name="sPost" style="width:225px;"
						value="<?php echo $row['sPost']; ?>"
						class="form-control  text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sPost']; ?>
				</td>

				<td
					class="<?php echo ($sadmin)? : 'd-none'; ?>">
					<form action="staffsearch.php" method="post">
						<button title="Szerkesztés" type="submit" name="modifyStaff"
							class="btn btn-sm btn-outline-warning">
							<?php include 'img/pencil.svg' ?>
						</button>
						<input type="hidden" name="modifyID"
							value="<?php echo $row['sId']; ?>">
						<button type="submit" title="Törlés" name="deleteStaff" class="btn btn-sm btn-outline-danger">
							<?php include 'img/trash.svg' ?>
						</button>
						<input type="hidden" name="deleteID"
							value="<?php echo $row['sId']; ?>">
					</form>
				</td>

			</tr>

			<?php
        }
    } else {
        echo "<h3 class='mt-2'>Nem található a megadott paramétereknek megfelelő személy</h3>";
    }
?>
		</tbody>
	</table>

</div>
<?php  if (isset($_GET["modifystaff"])) {
    if ($_GET["modifystaff"]=="stmtfailed") {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "staff.php", true);
    } elseif ($_GET["modifystaff"]=="none") {
        errorAlert("Az adatok sikeresen módosításra kerültek!", "staff.php", false);
    }
}
if (isset($_GET["deletestaff"])) {
    if ($_GET["deletestaff"]=="stmtfailed") {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "staff.php", true);
    } elseif ($_GET["deletestaff"]=="none") {
        errorAlert("Dolgozó adatai sikeresen törlésre kerülek!", "staff.php", false);
    }
}
?>