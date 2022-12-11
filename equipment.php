<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
  include_once 'includes/arrays.php';
  if (!isset($_SESSION["loggedin"])) {
      echo '<script> location.replace("login.php"); </script>';
  }
?>
<script defer>
	function enableSaveBtn(id) {
		document.getElementById(id).removeAttribute("disabled", "");
	}
</script>

<?php
function equipmentDropdownList(bool $hasEquipment, array $array, string $equipmentName, $row, $under14, $isGeneralUser, $ID)
{
    $i=0; ?>
<select onchange="enableSaveBtn(<?php echo $ID; ?>)"
	<?php echo ($under14||$isGeneralUser)?"disabled": ""; ?>
	name="<?php echo $equipmentName?>"
	class="form-select form-select-sm text-white
	<?php echo ($under14||$isGeneralUser)?"bg-dark": "bg-secondary"; ?>
	">
	<?php if ($hasEquipment) { ?>
	<option value="<?php echo $row[$equipmentName]; ?>">
		<?php echo $row[$equipmentName]; ?>
	</option>
	<?php while ($i!=count($array)) {
        if ($row[$equipmentName]!=$array[$i]) { ?>
	<option value="<?php echo $array[$i];?>">
		<?php echo $array[$i];?>
	</option>
	<?php	}
        $i++;
    }
         } else {
             while ($i!=count($array)) { ?>
	<option value="<?php echo $array[$i];?>">
		<?php echo $array[$i];?>
	</option>
	<?php $i++;
            }
         } ?>
</select>
<?php
}
?>
<?php
//add, or insert equipment
if (isset($_POST['submit'])) {
    $pId=$_POST['pId'];
    $eBag=$_POST['eBag'];
    $eTravellingTop=$_POST['eTravellingTop'];
    $eTravellingTrouser=$_POST['eTravellingTrouser'];
    $eTravellingTS=$_POST['eTravellingTS'];
    $eTTS=$_POST['eTTS'];
    $eTTSQ=$_POST['eTTSQ'];
    $eWhiteTravellingTS=$_POST['eWhiteTravellingTS'];
    $eBlackTravellingTS=$_POST['eBlackTravellingTS'];
    $eNewTravellingTop=$_POST['eNewTravellingTop'];
    $eNewTravellingTrouser=$_POST['eNewTravellingTrouser'];
    $eCPullover=$_POST['eCPullover'];
    $eCoat=$_POST['eCoat'];
    $eLastModifiedAt=date("Y-m-d");
    $eLastModifiedBy= $_SESSION['useruid'];
    $sql="INSERT INTO p_equipment (pId, eBag, eTravellingTop, eTravellingTrouser, eTravellingTS, 
	eTTS, eTTSQ, eWhiteTravellingTS, eBlackTravellingTS, eNewTravellingTop, eNewTravellingTrouser, 
	eCPullover, eCoat, eLastModifiedAt, eLastModifiedBy)
	VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
	ON DUPLICATE KEY UPDATE eBag='$eBag', eTravellingTop='$eTravellingTop', 
	eTravellingTrouser='$eTravellingTrouser', eTravellingTS='$eTravellingTS', 
	eTTS='$eTTS', eTTSQ='$eTTSQ', eWhiteTravellingTS='$eWhiteTravellingTS', eBlackTravellingTS='$eBlackTravellingTS',
	eNewTravellingTop='$eNewTravellingTop', eNewTravellingTrouser='$eNewTravellingTrouser', 
	eCPullover='$eCPullover', eCoat='$eCoat', eLastModifiedAt='$eLastModifiedAt', eLastModifiedBy='$eLastModifiedBy';";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "equipment.php", true);
        exit();
    }
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssss",
        $pId,
        $eBag,
        $eTravellingTop,
        $eTravellingTrouser,
        $eTravellingTS,
        $eTTS,
        $eTTSQ,
        $eWhiteTravellingTS,
        $eBlackTravellingTS,
        $eNewTravellingTop,
        $eNewTravellingTrouser,
        $eCPullover,
        $eCoat,
        $eLastModifiedAt,
        $eLastModifiedBy
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    errorAlert("Sikeres módosítás!", "equipment.php", false);
    exit();
}
?>



<div id="equipments">
	<div class="row">
		<div class="col-md-11">
			<h1 class="text-center mb-5">Felszerelések</h1>
		</div>
		<div class="col-md-1">
			<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Játékosok hozzáadása ">
				<a href="p_add.php" class="btn btn-outline-primary ">
					<?php include "img/plus-lg.svg"?>
				</a>
			</div>
		</div>
	</div>


	<!-- <div class="mx-auto col-md-4">
		<?php
            $sql="SELECT * FROM Players WHERE pIsMember=1 ORDER BY pName;";
            $result=mysqli_query($conn, $sql);
            $qres=mysqli_num_rows($result); ?>
	<label for="player" class="form-label ">Játékos kiválasztása</label>
	<input class="form-control" list="datalistOptions" id="player" placeholder="Játékos neve...">
	<datalist id="datalistOptions">
		<?php
      if ($qres>0) {
          while ($row=mysqli_fetch_assoc($result)) {
              echo '<option value="'.$row['pName'].'  - '.$row['pBDate'].' ">'.$row['pCode'].'</option>';
          }
      }
      ?>
	</datalist>
</div> -->
<div class="container-fluid sm-col-10 mt-1 table-responsive">
	<?php
  $sql="SELECT *, TIMESTAMPDIFF(YEAR, `pBDate`, NOW()) AS Age FROM Players WHERE pIsMember=1;";
  $result=mysqli_query($conn, $sql);
   $i=1;
  ?>
	<table id='ptable' class="table table-dark table-hover">
		<thead style="font-size:14px;" class="thead-light ">
			<tr class="align-middle ">
				<th>#</th>
				<th>Név</th>
				<th>Születési dátum</th>
				<th>Táska</th>
				<th>Melegítő felső</th>
				<th>Melegítő alsó</th>
				<th>Utazó póló</th>
				<th>Edző póló méret</th>
				<th>Edző póló (db)</th>
				<th>Fekete utazó póló</th>
				<th>Fehér utazó póló</th>
				<th>Melegítő felső (új)</th>
				<th>Melegítő alsó (új)</th>
				<th>Pamut pulcsi</th>
				<th>Kabát</th>
				<th
					class="<?php echo ($gUser)? 'd-none':''; ?>">
					Mentés</th>
			</tr>
		</thead>
		<tbody>

			<?php  while ($row=mysqli_fetch_assoc($result)) {
      $under14= ($row['Age']<14)? true : false;
      $playerID=$row['pId'];
      $eqiup_sql="SELECT * FROM p_equipment WHERE pId='$playerID'";
      $result2=mysqli_query($conn, $eqiup_sql);
      $hasEquipment=mysqli_num_rows($result2)!=0;
      if ($hasEquipment) {
          $row2=mysqli_fetch_assoc($result2);
      } else {
          $row2="";
      } ?>
			<tr class="align-middle ">
				<form action="equipment.php" method="post">
					<td style=" font-size:12px;" width=1%>
						<?php echo $i; ?>
					</td>
					<td style=" font-size:12px;" width=8%>
						<?php echo $row['pName']; ?>
					</td>
					<td style="font-size:12px;" width=2%>
						<?php echo $row['pBDate']; ?>
					</td>
					<td width=8%>
						<select
							onchange="enableSaveBtn(<?php echo $row['pId']; ?>)"
							<?php echo ($gUser)?"disabled": ""; ?>
							name="eBag" class=" text-white
							<?php echo ($gUser)?"bg-dark": "bg-secondary"; ?>
							form-select form-select-sm">
							<?php if ($row2['eBag']==null || $row2['eBag']==0) {
          echo '<option value="0">Nincs</option>';
          echo '<option value="1">Van</option>';
      } elseif ($row2['eBag']==1) {
          echo '<option value="1">Van</option>';
          echo '<option value="0">Nincs</option>';
      } ?>
						</select>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eTravellingTop', $row2, false, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eTravellingTrouser', $row2, false, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eTravellingTS', $row2, false, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $otherSizes, 'eTTS', $row2, false, $gUser, $row['pId'])?>
					</td>
					<td>
						<input
							<?php echo ($gUser)?"disabled": ""; ?>
						type="number" max=20 name="eTTSQ"
						onblur="enableSaveBtn(<?php echo $row['pId']; ?>)"
						class="text-white
						<?php echo ($gUser)?"bg-dark": "bg-secondary"; ?>
						form-control form-control-sm"
						value="<?php echo $row2['eTTSQ']; ?>"
						/>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eWhiteTravellingTS', $row2, $under14, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eBlackTravellingTS', $row2, $under14, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eNewTravellingTop', $row2, $under14, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eNewTravellingTrouser', $row2, $under14, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eCPullover', $row2, $under14, $gUser, $row['pId'])?>
					</td>
					<td>
						<?php equipmentDropdownList($hasEquipment, $adidasSizes, 'eCoat', $row2, $under14, $gUser, $row['pId'])?>
					</td>

					<td width="4%"
						class="<?php echo ($gUser)? 'd-none':''; ?>">

						<input type="hidden"
							value="<?php echo $row['pId']; ?>"
							name="pId">
						<button disabled
							id="<?php echo $row['pId']; ?>"
							type="submit" name="submit" class="btn btn-outline-success btn-sm">
							<?php include 'img/check-lg.svg' ?>
						</button>


					</td>
				</form>
			</tr>
			<?php $i++;
  } ?>

		</tbody>
	</table>
</div>

</div>





<?php
  include_once 'footer.php';
?>