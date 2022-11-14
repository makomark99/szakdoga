<script src="p_licence_match.js" defer></script>
<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
    include_once 'includes/SweetAlert.php';

    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }

    if (isset($_POST["modify"])) {
        $pTId=$_POST['pTId'];
        $pLMCDate=$_POST['pLMCDate'];
        $pMCD=$_POST['pMCD'];
        $pPEmail=$_POST['pPEmail'];
        $pEmail=$_POST['pEmail'];
        $pPTel=$_POST['pPTel'];
        $pTel=$_POST['pTel'];
        $pSH=$_POST['pSH'];
        $pTSize=$_POST['pTSize'];
        $pL1 = ($_POST['pL1']==''||$_POST['pL1']==null)? null: $_POST['pL1'];
        $pL2 = ($_POST['pL2']==''||$_POST['pL2']==null)? null: $_POST['pL2'];
        $pL3 = ($_POST['pL3']==''||$_POST['pL3']==null)? null: $_POST['pL3'];
        $pSsn=$_POST['pSsn'];
        $pHA=$_POST['pHA'];
        $pPhoto=mysqli_real_escape_string($conn, $_POST['pPhoto']);
        $pPHand=$_POST['pPHand'];
        $pPost=$_POST['pPost'];
        $id=$_POST['pId'];
        $pLastModifiedBy= $_SESSION['useruid'];
        $pLastModifiedAt=date("Y-m-d");
        $sql="UPDATE players SET pTId='$pTId', pLMCDate='$pLMCDate', pMCD='$pMCD', pPEmail='$pPEmail',
         pEmail='$pEmail', pPTel='$pPTel', pTel='$pTel',pSH='$pSH',pTSize='$pTSize',
         pL1='$pL1',pL2='$pL2',pL3='$pL3', pSsn='$pSsn',pHA='$pHA', pPhoto='$pPhoto', pPHand='$pPHand', pPost='$pPost', 
		 pLastModifiedAt='$pLastModifiedAt', pLastModifiedBy='$pLastModifiedBy' WHERE pId='$id'; ";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            errorAlert("Valami nem stimmel, próbálkozz újra!", "p_modify.php?id=$id", true);
            exit();
        }
        $sql1="UPDATE players SET pl1=NULL WHERE pL1='';";
        $sql2="UPDATE players SET pl2=NULL WHERE pL2='';";
        $sql3="UPDATE players SET pl3=NULL WHERE pL3='';";
        
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_query($conn, $sql1);
        mysqli_query($conn, $sql2);
        mysqli_query($conn, $sql3);
        errorAlert("Sikeres módosítás!", "p_modify.php?id=$id", false);
        exit();
    }


    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        $sql="SELECT * FROM players WHERE pId=?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "<h2> class='red' Valami nem stimmel, próbálkozzon újra!</h2>";
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if ($row=mysqli_fetch_assoc($result)) {
            ?>
<h1 class="text-center mb-5">Játékos adatainak módosítása</h1>
<form class="row g-3" action="p_modify.php" method="post">
	<div class="col-md-6 col-lg-3 ">
		<label for="name" class="form-label ">Név*</label>
		<input name="pName" type="text" class="form-control notm" id="name"
			placeholder="<?php echo $row['pName']; ?>"
			disabled>
	</div>
	<div class="col-md-6 col-lg-3  ">
		<label for="bplace" class="form-label ">Születési hely*</label>
		<input name="pBPlace" type="text" class="form-control notm" id="bplace"
			placeholder="<?php echo $row['pBPlace']; ?>"
			disabled>
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="bdate" class="form-label ">Születési dátum*</label>
		<input name="pBDate" type="text" class="form-control notm" id="bdate"
			placeholder="<?php echo $row['pBDate']; ?>"
			disabled>
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="nat" class="form-label">Nemzetiség*</label>
		<input name="pNat" id="nat" class="form-select notm"
			placeholder="<?php echo $row['pNat']; ?>"
			disabled>
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="code" class="form-label ">Személy kód*</label>
		<input name="pCode" type="text"
			class="form-control <?php if ($row['pCode']!="") { ?> notm <?php } ?> "
			id="code"
			placeholder="<?php echo $row['pCode']; ?>"
			<?php if ($row['pCode']!="") { ?>disabled
		<?php } else { ?>
		<?php } ?> >
	</div>

	<div class="col-md-6 col-lg-3 ">
		<label for="mname" class="form-label ">Anyja születési neve*</label>
		<input name="pMsN" type="text" class="form-control notm" id="mname"
			placeholder="<?php echo $row['pMsN']; ?>"
			disabled>
	</div>
	<div class="col-md-6 col-lg-3">
		<?php
            $sId=$row['pTId'];
            $sql3="SELECT * FROM staff S INNER JOIN players P ON S.sId=P.pTId WHERE S.sId='$sId';";
            $result3=mysqli_query($conn, $sql3);
            $r=mysqli_fetch_assoc($result3); ?>
		<label class="form-label">Edző neve*</label>
		<select name="pTId" id="" class="form-select">
			<option value="<?php if ($r['pTId']!=null) {
                echo $r['pTId'];
            } else {
                echo "";
            } ?>">
				<?php if ($r['sName']!=null) {
                echo $r['sName'];
            } else {
                echo 'Nincs megadva';
            } ?>
				(jelenelgi)
			</option>
			<?php
                $sql2="SELECT * FROM staff S INNER JOIN trainers T ON S.sId=T.sId WHERE T.tIsCoach=1;";
            $result2=mysqli_query($conn, $sql2);
            $queryResults2=mysqli_num_rows($result2);
            if ($queryResults2>0) {
                while ($row2=mysqli_fetch_assoc($result2)) {
                    if ($r['sId']!=$row2['sId']) {
                        echo '<option value="'.$row2['sId'].'">'.$row2['sName'].'</option>'; //ismétlődés kiszűrése
                    }
                }
            } ?>
		</select>
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="pArrival" class="form-label">Igazolás időpontja*</label>
		<input name="pArrival" type="text" class="form-control notm" id="pArrival"
			placeholder="<?php echo $row['pArrival']; ?>"
			disabled>
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="mcdate" class="form-label">Sportorvosi időpont</label>
		<input name="pLMCDate" type="text" onfocus="(this.type='date')"
			max="<?php echo date("Y-m-d"); ?>"
			value="<?php echo $row['pLMCDate']; ?>"
			class="form-control" id="mcdate">
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="mc" class="form-label">Sportorvos</label>
		<input name="pMCD" title="Csak betűk használata lehetséges" pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ\s.]*$"
			type="text"
			value="<?php echo $row['pMCD']; ?>"
			class="form-control" id="mc">
	</div>

	<div class="col-md-6 col-lg-3">
		<label for="email1" class="form-label">1. E-mail</label>
		<input name="pPEmail" type="email" class="form-control" id="email1"
			vlaue="<?php echo $row['pPEmail']; ?>">
	</div>
	<div class="col-md-6 col-lg-3">
		<label for="email2" class="form-label">2. E-mail</label>
		<input name="pEmail" type="email" class="form-control" id="email2"
			vlaue="<?php echo $row['pEmail']; ?>">
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="tel1" class="form-label">1. Telefonszám</label>
		<input name="pPTel" type="text" title="Csak számok, vagy szóköz, '+' '/' jelek használata lehetséges!"
			pattern="^[\d\s\/\+]{9,30}$" class="form-control" id="tel1"
			value="<?php echo $row['pPTel']; ?>">
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="tel2" class="form-label">2. Telefonszám</label>
		<input name="pTel" type="text" title="Csak számok, vagy szóköz, '+' '/' jelek használata lehetséges!"
			pattern="^[\d\s\/\+]{9,30}$" class="form-control" id="tel2"
			value="<?php echo $row['pTel']; ?>">
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="pSH" class="form-label">Kollégista?</label>
		<select class="form-select" name="pSH" id="pSH">
			<?php if ($row['pSH']==0) {
                echo '<option value="0">Nem (jelenlegi)</option>
                <option value="1">Igen</option>';
            } else {
                echo '<option value="1">Igen (jelenlegi)</option>
                  <option value="0">Nem</option>';
            } ?>
		</select>
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="pPost" class="form-label">Poszt kiválasztása</label>
		<select class="form-select" name="pPost" id="pPost">
			<?php $i=0; ?>
			<option
				value="<?php echo $row['pPost']; ?>">
				<?php echo $row['pPost'];
            if ($row["pPost"]!="") {
                echo ' (jelenelgi)';
            } else {
                echo'Nincs megadva ';
            } ?>
			</option>
			<?php
              while ($i!=count($posts)) {
                  if ($row['pPost']!=$posts[$i]) {?>
			<option value="<?php echo $posts[$i];?>">
				<?php if ($posts[$i]=="") {
                      echo "Nincs megadva";
                  } else {
                      echo $posts[$i];
                  } ?>
			</option>
			<?php }
                  $i++;
              } ?>
		</select>
	</div>

	<?php $i=0; ?>
	<div class="col-md-4 col-lg-2">
		<label for="shirtsize" class="form-label">Pólóméret</label>
		<select name="pTSize" id="shirtsize" class="form-select">
			<option
				value="<?php echo $row['pTSize']; ?>">
				<?php echo $row['pTSize'];
            if ($row["pTSize"]!="") {
                echo ' (jelenelgi)';
            } else {
                echo'Nincs megadva ';
            } ?>
			</option>
			<?php
              while ($i!=count($sizes)) {
                  if ($row['pTSize']!=$sizes[$i]) {?>
			<option value="<?php echo $sizes[$i];?>">
				<?php if ($sizes[$i]=="") {
                      echo "Nincs megadva";
                  } else {
                      echo $sizes[$i];
                  } ?>
			</option>
			<?php }
                  $i++;
              } ?>
		</select>
	</div>

	<div class="col-md-4 col-lg-2 ">
		<label for="pSsn" class="form-label">Tajszám</label>
		<input name="pSsn" pattern='^\d{9}$' title="Pontosan 9 számjegy használható!" type="text"
			value="<?php echo $row['pSsn']; ?>"
			class="form-control <?php if ($row['pSsn']!="") { ?> notm <?php } ?> "
			id="pSsn"
			<?php if ($row['pSsn']!="") { ?>readonly
		<?php } else { ?>
		<?php } ?> >
	</div>

	<?php
            $x=1;
            $y=0;
            while ($x!=4) {
                ?>
	<div class="col-md-4 col-lg-2">
		<label class="form-label">Játékengedély
			<?php echo $x; ?></label>
		<select onchange="playerLicenceMath()"
			id="pL<?php echo $x; ?>"
			name="pL<?php echo $x; ?>" class="form-select">
			<option value="<?php echo $row["pL$x"]; ?>"><?php echo $row["pL$x"];
                if ($row["pL$x"]!="") {
                    echo ' (jelenelgi)';
                } else {
                    echo'Nincs játékengedély ';
                } ?>
			</option>
			<?php
                    while ($y!=count($teams)) {
                        if ($row["pL$x"]!=$teams[$y]) {?>
			<option value="<?php echo $teams[$y];?>">
				<?php if ($teams[$y]=="") {
                            echo "Nincs játékengedély";
                        } else {
                            echo $teams[$y];
                        } ?>
			</option>
			<?php }
                        $y++;
                    } ?>
		</select>
	</div>
	<?php
                $x++;
                $y=0;
            } ?>


	<div class="col-md-8 col-lg-4 ">
		<label for="pHA" class="form-label">Lakhely (település)</label>
		<input name="pHA" title="Csak betűk, számok ',' '.' ';' és '/' jelek használata lehetséges!"
			pattern="^[a-zA-Z0-9 éáűőúöüóíÁÉÍŰÚŐÖÜÓ\s\/\,\.\;]*$" type="text" class="form-control"
			value="<?php echo $row['pHA']; ?>">
	</div>


	<div class="col-md-4 col-lg-2">
		<label for="pPHand" class="form-label">Lövő kéz</label>
		<select class="form-select" name="pPHand" id="pPHand">
			<?php if ($row['pPHand']=="Jobb") {
                echo '<option value="Jobb">Jobb (jelenlegi)</option>
                <option value="Bal">Bal</option>';
            } elseif ($row['pPHand']=="Bal") {
                echo '<option value="Bal">Bal (jelenlegi)</option>
                  <option value="Jobb">Jobb</option>';
            } elseif ($row['pPHand']=="") {
                echo '<option value="">Nincs megadva</option>
				<option value="Bal">Bal</option>
                  <option value="Jobb">Jobb</option>';
            } ?>
		</select>
	</div>
	<div class="col-md-12 col-lg-6">
		<label for="pPhoto" class="form-label">Arcképes fotó</label>
		<input name="pPhoto"
			value="<?php echo $row['pPhoto']; ?>"
			id="pPhoto" type="url" class="form-control" id="foto">
	</div>

	<div class="col-md-auto mt-4">
		<input type="hidden" value="<?php echo $id?>" name="pId">
		<input type="hidden" name="pLastModifiedBy"
			value="<?php echo $_SESSION['useruid']; ?>">
		<button type="submit" id="btn" name="modify" class="btn btn-outline-primary">Módosít</button>
	</div>

</form>

<?php
        }
    }
    if (isset($_GET["error"])) {
        if ($_GET["error"]== "stmtfailed") {
            errorAlert("Valami nem stimmel, próbálkozz újra!", "players.php", true);
        }
        if ($_GET["error"]== "invalidpbdate") {
            errorAlert("3 éves kornál fiatalabb játékos nem rögzíthető!", "players.php", true);
        }
        if ($_GET["error"]== "invalidpLMCDate") {
            errorAlert("Sportorvosi vizsgálathoz kizárólag múltbeli időpont adható meg!", "players.php", true);
        }
        if ($_GET["error"]== "playerlicensematch") {
            errorAlert("A játékengedélyek megadásánál csak különböző értékeket lehet kiválasztani!", "players.php", true);
        }
        if ($_GET["error"]== "invalidssn") {
            errorAlert("Érvénytelen tajszámot adott meg!", "players.php", true);
        }
        if ($_GET["error"]== "none") {
            errorAlert("A kiválasztott játékos adatai sikeresen módosításra kerültek!!", "players.php", false);
        }
    }

include_once 'footer.php';
?>