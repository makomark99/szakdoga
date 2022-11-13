<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
   
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
?>
<script src="p_licence_match.js" defer></script>
<h1 class="text-center mb-5">Új játékos rögzítése</h1>
<form class="row g-3 " action="includes/addplayer.inc.php" method="post">
	<div class="col-md-6 col-lg-3">
		<label for="name" class="form-label">Név*</label>
		<input name="pName" type="text" title="Csak betűk használata lehetséges"
			pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ\s.]*$" class="form-control" id="name"
			placeholder="Vezetéknév Keresztnév" required>
	</div>
	<div class="col-md-6 col-lg-3 ">
		<label for="bdp" class="form-label">Születési hely*</label>
		<input name="pBPlace" type="text" title="Csak betűk használata lehetséges"
			pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ\s.]*$" class="form-control" id="bdp" placeholder="Születési hely"
			required>
	</div>
	<?php
 $time = strtotime("-5 year", time());
 $date = date("Y-m-d", $time);
?>
	<div class="col-md-4 col-lg-2">
		<label for="bdate" class="form-label">Születési dátum*</label>
		<input name="pBDate" type="date" max="<?php echo $date; ?>"
			title="<?php echo $date; ?> -i dátumnál korábbi szülteséi dátum nem rögzíthető!"
			class="form-control" id="bdate" required>
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="nat" class="form-label">Nemzetiség*</label>
		<select name="pNat" id="nat" class="form-select" required>
			<option value="magyar">magyar</option>
			<option value="szlovák">szlovák</option>
			<option value="osztrák">osztrák</option>
			<option value="román">román</option>
			<option value="szerb">szerb</option>
			<option value="ukrán">ukrán</option>
			<option value="horvát">horvát</option>
			<option value="other">nincs a felsoroltak között</option>
		</select>
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="code" class="form-label">Személy kód*</label>
		<input name="pCode" type="number" class="form-control" min=100 max=999999 id="code"
			placeholder="MKSZ személy kód" required>
	</div>
	<div class="col-md-6 col-lg-3 ">
		<label for="mname" class="form-label">Anyja születési neve*</label>
		<input name="pMsN" type="text" title="Csak betűk használata lehetséges"
			pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ\s.]*$" class="form-control" id="mname"
			placeholder="Vezetéknév Keresztnév" required>
	</div>
	<div class="col-md-6 col-lg-3 ">
		<label class="form-label">Edző neve*</label>
		<select name="pTId" id="" class="form-select" required>
			<?php
        $sql="SELECT * FROM staff S INNER JOIN trainers T ON S.sId=T.sId WHERE T.tIsCoach=1;";
        $result=mysqli_query($conn, $sql);
        $queryResults=mysqli_num_rows($result);
        if ($queryResults>0) {
            while ($row=mysqli_fetch_assoc($result)) {
                $val=$row['sId'];
                $name=$row['sName'];
                echo '<option value='.$val.'>'.$name.'</option>';
            }
        }
        ?>
		</select>
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="pArrival" class="form-label">Igazolás időpontja*</label>
		<input name="pArrival"
			value="<?php echo date("Y-m-d"); ?>"
			type="text" onfocus="(this.type='date')" max="9999-11-11"
			placeholder="<?php echo date; ?>" class="form-control"
			id="pArrival">
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="mcdate" class="form-label">Sportorvosi időpont</label>
		<input name="pLMCDate" type="date" min="2010-01-01"
			max="<?php echo date("Y-m-d"); ?>"
			class="form-control" id="mcdate">
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="mc" class="form-label">Sportorvos</label>
		<input name="pMCD" type="text" title="Csak betűk használata lehetséges"
			pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ\s.]*$" class="form-control" id="mc" placeholder="Név / helyszín">
	</div>

	<div class="col-md-6 col-lg-3 ">
		<label for="email1" class="form-label">1. E-mail</label>
		<input name="pPEmail" type="email" class="form-control" id="email1" placeholder="Játékos e-mail cím">
	</div>
	<div class="col-md-6 col-lg-3 ">
		<label for="email2" class="form-label">2. E-mail</label>
		<input name="pEmail" type="email" class="form-control" id="email2" placeholder="Szülő e-mail cím">
	</div>

	<div class="col-md-4 col-lg-2 ">
		<label for="tel1" class="form-label">1. Telefonszám</label>
		<input name="pPTel" type="text" pattern="^[\d\s\/\+]{9,30}$"
			title="Csak számok, vagy szóköz, '+' '/' jelek használata lehetséges!" class="form-control" id="tel1"
			placeholder="Játékos telefonszám">
	</div>
	<div class="col-md-4 col-lg-2 ">
		<label for="tel2" class="form-label">2. Telefonszám</label>
		<input name="pTel" type="text" title="Csak számok, vagy szóköz, '+' '/' jelek használata lehetséges!"
			pattern="^[\d\s\/\+]{9,30}$" class="form-control" id="tel2" placeholder="Szülő telefonszám">
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="pSH" class="form-label">Kollégista?</label>
		<select class="form-select" name="pSH" id="pSH">
			<option value="0">Nem</option>
			<option value="1">Igen</option>
		</select>
	</div>
	<div class="col-md-4 col-lg-2">
		<label for="pPost" class="form-label">Poszt kiválasztása</label>
		<select class="form-select" name="pPost" id="pPost">
			<option value="0">Nincs megadva</option>
			<option value="Balátlövő">Balátlövő</option>
			<option value="Balszélső">Balszélső</option>
			<option value="Jobbátlövő">Jobbátlövő</option>
			<option value="Jobbszélső">Jobbszélső</option>
			<option value="Irányító">Irányító</option>
			<option value="Beálló">Beálló</option>
			<option value="Kapus">Kapus</option>
		</select>
	</div>

	<div class="col-md-4 col-lg-2">
		<label for="shirtsize" class="form-label">Pólóméret</label>
		<select name="pTSize" id="shirtsize" class="form-select">
			<?php $i=0;
      while ($i!=count($sizes)) { ?>
			<option value="<?php echo $sizes[$i];?>">
				<?php if ($sizes[$i]=="") {
          echo "Nincs megadva";
      } else {
          echo $sizes[$i];
      } ?>
			</option>
			<?php $i++;
      }?>
		</select>
	</div>

	<div class="col-md-4 col-lg-2 ">
		<label for="ssn" class="form-label">Tajszám</label>
		<input name="pSsn" type="number" pattern='^\d{9}$' title="Pontosan 9 számjegy használható!" class="form-control"
			id="ssn" placeholder="Tajszám">
	</div>


	<?php
    $i=1; $j=0; $tmp;
    while ($i!=4) {
        echo '
      <div class="col-md-4 col-lg-2">
        <label class="form-label">Játékengedély '.$i.'</label>
        <select onchange="playerLicenceMath()" name="pL'.$i.'" id="pL'.$i.'" class="form-select">';
        while ($j!=count($teams)) {
            $tmp=$teams[$j]; ?>
	<option value="<?php echo $tmp; ?>">
		<?php if ($tmp=="") {
                echo "Nincs játékengedély";
            } else {
                echo $tmp;
            } ?>
	</option>
	<?php $j++;
        } ?>
	</select>
	</div>
	<?php $i++;
        $j=0;
    }
  ?>

	<div class="col-md-8 col-lg-4 ">
		<label for="pHA" class="form-label">Lakhely (település)</label>
		<input name="pHA" placeholder="9200 Mosonmagyaróvár Gorkij utca 1"
			title="Csak betűk, számok ',' '.' ';' és '/' jelek használata lehetséges!"
			pattern="^[a-zA-Z0-9 éáűőúöüóíÁÉÍŰÚŐÖÜÓ\s\/\,\.\;]*$" type="text" class="form-control" id="pHA">
	</div>
	<!-- <div class="col-md-4 col-lg-2 "> 
		<label for="pHA" class="form-label">Lakhely (irányítószám)</label>
		<input name="pHA" placeholder="9200" title="Csak számjegyek használata lehetséges 4-6 karakterig!"
			pattern="^\d{4,6}$" type="text" class="bg-dark form-control" id="pHA" disabled>
	</div>

	<div class="col-md-4 col-lg-2 ">
		<label for="pHA" class="form-label">Lakhely (közterület neve)</label>
		<input name="pHA" placeholder="Gorkij" title="Csak betűk használata lehetséges!"
			pattern="^[a-zA-ZéáűőúöüóíÁÉÍŰÚŐÖÜÓ\s\/\,\.\;]*$" type="text" class="bg-dark form-control" id="pHA"
			disabled>
	</div>
	<div class="col-md-6 col-lg-3">
		<label for="pHA" class="form-label">Lakhely (házszám/ép./szint/ajtó)</label>
		<input name="pHA" placeholder="1" title="Csak betűk, ',' '.' ';' és '/' jelek használata lehetséges!"
			pattern="^[a-zA-ZéáűőúöüóíÁÉÍŰÚŐÖÜÓ\s\/\,\.\;]*$" type="text" class=" bg-dark form-control" id="pHA"
			disabled>
	</div>-->
	<div class="col-md-4 col-lg-2">
		<label for="pPHand" class="form-label">Lövő kéz</label>
		<select class="form-select" name="pPHand" id="pPHand">
			<option value="">Nincs megadva</option>
			<option value="Jobb">Jobb</option>
			<option value="Bal">Bal</option>
		</select>
	</div>
	<div class="col-md-12 col-lg-6">
		<label for="pPhoto" class="form-label">Arcképes fotó</label>
		<input name="pPhoto" id="pPhoto" placeholder="https://mkcse.hu/assets/img/logo.png" type="url"
			class="form-control" id="foto">
	</div>

	<div class="col-md-auto mt-4 ">
		<input type="hidden" name="pLastModifiedBy"
			value="<?php echo $_SESSION['useruid'];?>">
		<button type="submit" id="btn" name="submit" class="btn btn-outline-primary">Rögzítés</button>
	</div>

</form>

<?php
    if (isset($_GET["error"])) {
        if ($_GET["error"]== "pcodeexists") {
            errorAlert("A megadott Személy kód már létezik!!", "p_add.php", true);
        }
        if ($_GET["error"]== "stmtfailed") {
            errorAlert("Valami nem stimmel, próbálkozz újra!", "p_add.php", true);
        }
        if ($_GET["error"]== "playerlicensematch") {
            errorAlert("A játékengedélyek megadásánál csak különböző értékeket lehet kiválasztani!", "p_add.php", true);
        }
        if ($_GET["error"]== "pssnexists") {
            errorAlert("A megadott tajszám már tárolva van a rendszerben!", "p_add.php", true);
        }
        if ($_GET["error"]== "none") {
            errorAlert("Az új játékos adatai sikeresen rögzítésre kerültek!", "p_add.php", false);
        }
    }
  ?>

<?php
    include 'footer.php';
?>