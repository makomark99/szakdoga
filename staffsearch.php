<?php
      include_once 'includes/dbh.inc.php';
      include_once 'header.php';
      include_once 'check_user.php';
      if (!isset($_SESSION["loggedin"])) {
          header('location: ../Szakdoga/login.php');
      }
     
    $search=mysqli_real_escape_string($conn, $_POST['name']);
    $sql = "SELECT * FROM staff WHERE sName LIKE '%$search%' AND sIsActive=1";
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
					<input
						name="sCode<?php echo $row['sId']; ?>"
						style="width:80px;"
						value="<?php echo $row['sCode']; ?>"
						class="form-control text-white bg-secondary form-control-sm " min=100 max=999999 type="number">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sCode']; ?>
				</td>
				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input
						name="sEmail<?php echo $row['sId']; ?>"
						style="width:180px;"
						value="<?php echo $row['sEmail']; ?>"
						class="form-control text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sEmail']; ?>
				</td>
				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input
						name="sEmail2<?php echo $row['sId']; ?>"
						style="width:225px;"
						value="<?php echo $row['sEmail2']; ?>"
						class="form-control text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sEmail2']; ?>
				</td>

				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input
						name="sTel<?php echo $row['sId']; ?>"
						style="width:125px;"
						value="<?php echo $row['sTel']; ?>"
						class="form-control  text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sTel']; ?>
				</td>


				<td
					class=" <?php echo ($sadmin)? : 'd-none'; ?>">
					<input
						name="sPost<?php echo $row['sId']; ?>"
						style="width:225px;"
						value="<?php echo $row['sPost']; ?>"
						class="form-control  text-white bg-secondary  form-control-sm " type="text">
				</td>
				<td
					class="align-middle <?php echo (!$sadmin)? : 'd-none'; ?>">
					<?php echo $row['sPost']; ?>
				</td>

				<td
					class="<?php echo ($sadmin)? : 'd-none'; ?>">
					<input type="hidden"
						name="sLastModifiedBy<?php echo $row['sId']; ?>"
						value="<?php echo $_SESSION['useruid']; ?>">

					<input type="hidden"
						name="modifyID<?php echo $row['sId']; ?>"
						value="<?php echo $row['sId']; ?>">
					<a href="staff_modify.php?id=<?php echo $row['sId']; ?>"
						class="btn btn-sm btn-outline-warning">
						<?php include 'img/pencil.svg' ?>
					</a>


					<a title="Törlés" class="btn btn-sm btn-outline-danger " data-bs-toggle="modal"
						data-bs-target="#delete<?php echo $row['sId']; ?>">
						<!--egyedi id kell, mert minding az elsőt találta meg-->
						<?php include 'img/trash.svg' ?>
					</a>
				</td>

			</tr>
			<div class="modal fade"
				id="delete<?php echo $row['sId']; ?>"
				tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content text-dark fs-5">
						<div class="modal-header">
							<h4 class="modal-title" id="deleteLabel">Munkatárs törlése</h4>
							<button type="button" class="btn-close " data-bs-dismiss="modal"
								aria-label="Close"></button>
						</div>

						<div class="modal-body">
							<?php
                echo 'Biztosan szeretné <strong>TÖRÖLNI</strong> a következő nevű dolgozót az adatbázisból: '.$row['sName'].' ?'; ?>
						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
							<a href="staff_delete.php?id=<?php echo $row['sId']; ?>"
								title="Törlés" name="deleteStaff" class="btn btn-danger ">Törlés</a>
						</div>
					</div>
				</div>
			</div>
			<?php
        }
    } else {
        echo "<h3 class='mt-2'>Nem található a megadott paramétereknek megfelelő személy</h3>";
    }
?>
		</tbody>
	</table>

</div>
<?php include_once 'footer.php'; ?>