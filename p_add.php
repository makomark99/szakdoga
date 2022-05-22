<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
    include_once 'auto_logout.php';
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
?>
<h1 class="text-center mb-5">Új játékos rögzítése</h1>
<form class="row g-3 " action="includes/addplayer.inc.php" method="post">
  <div class="col-md-6 col-lg-3">
    <label for="name" class="form-label">Név*</label>
    <input name="pName" type="text" class="form-control" id="name" placeholder="Vezetéknév Keresztnév" required>
  </div>
  <div class="col-md-6 col-lg-3 ">
    <label for="bdp" class="form-label">Születési hely*</label>
    <input name="pBPlace" type="text" class="form-control" id="bdp" placeholder="Születési hely" required>
  </div>
  <div class="col-md-4 col-lg-2">
    <label for="bdate" class="form-label">Születési dátum*</label>
    <input name="pBDate" type="date" max="9999-11-11" title="" class="form-control" id="bdate" required>
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
    <input name="pCode" type="number" class="form-control" min=100 max=999999 id="code" placeholder="MKSZ személy kód"
      required>
  </div>
  <div class="col-md-6 col-lg-3 ">
    <label for="mname" class="form-label">Anyja születési neve*</label>
    <input name="pMsN" type="text" class="form-control" id="mname" placeholder="Vezetéknév Keresztnév" required>
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
    <input name="pLMCDate" type="date" title="" min="2010-01-01" max="9999-11-11" class="form-control" id="mcdate">
  </div>
  <div class="col-md-4 col-lg-2">
    <label for="mc" class="form-label">Sportorvos</label>
    <input name="pMCD" type="text" class="form-control" id="mc" placeholder="Név / helyszín">
  </div>

  <div class="col-md-6 col-lg-3 ">
    <label for="email1" class="form-label">1. E-mail</label>
    <input name="pPEmail" type="text" class="form-control" id="email1" placeholder="E-mail">
  </div>
  <div class="col-md-6 col-lg-3 ">
    <label for="email2" class="form-label">2. E-mail</label>
    <input name="pEmail" type="email" class="form-control" id="email2" placeholder="E-mail">
  </div>

  <div class="col-md-4 col-lg-2 ">
    <label for="tel1" class="form-label">1. Telefonszám</label>
    <input name="pPTel" type="text" class="form-control" id="tel1" placeholder="Telefonszám">
  </div>
  <div class="col-md-4 col-lg-2 ">
    <label for="tel2" class="form-label">2. Telefonszám</label>
    <input name="pTel" type="text" class="form-control" id="tel2" placeholder="Telefonszám">
  </div>

  <div class="col-md-2 col-lg-1">
    <label for="pSH" class="form-label">Kollégista?</label>
    <select class="form-select" name="pSH" id="pSH">
      <option value="0">Nem</option>
      <option value="1">Igen</option>
    </select>
  </div>

  <div class="col-md-2 col-lg-1">
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

  <?php
    $i=1; $j=0; $tmp;
    while ($i!=4) {
        echo '
      <div class="col-md-4 col-lg-2">
        <label class="form-label">Játékengedély '.$i.'</label>
        <select name="pL'.$i.'" id="" class="form-select">';
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

  <div class="col-md-4 col-lg-2 ">
    <label for="ssn" class="form-label">Tajszám</label>
    <input name="pSsn" type="number" class="form-control" id="ssn" placeholder="Tajszám">
  </div>

  <div class="col-md-4 col-lg-2 ">
    <label for="pHA" class="form-label">Lakhely (település)</label>
    <input name="pHA" placeholder="Lakhely" value="" type="text" class="form-control" id="pHA">
  </div>

  <div class="col-md-4 col-lg-2">
    <label for="foto" class="form-label">Arcképes fotó &nbsp<?php include "img/filetype-jpg.svg"; echo"&nbsp"; include "img/filetype-png.svg"; ?></label>
    <input name="pPhoto" type="file" class="form-control" id="foto" disabled>
  </div>


  <div class="col-md-auto mt-4 ">
    <button type="submit" name="submit" class="btn btn-primary">Rögzítés</button>
  </div>
  <div class="mt-4 col-md-auto">
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"]== "pcodeexists") {
            echo "<p class='red '>A megadott Személy kód már létezik!</p>";
        }
        if ($_GET["error"]== "invalidpcode") {
            echo "<p class='red '>A megadott Személy kód csak számokat tartalmazhat 3 és 6 karakter között!</p>";
        }
        if ($_GET["error"]== "stmtfailed") {
            echo "<p class='red'>Valami nem stimmel, próbálkozzon újra!</p>";
        }
        if ($_GET["error"]== "invalidpbdate") {
            echo "<p class='red'>3 éves kornál fiatalabb játékos nem rögzíthető!</p>";
        }
        if ($_GET["error"]== "invalidpLMCDate") {
            echo "<p class='red'>Sportorvosi vizsgálathoz kizárólag múltbeli időpont adható meg!</p>";
        }
        if ($_GET["error"]== "playerlicensematch") {
            echo "<p class='red'>A játékengedélyek megadásánál csak különböző értékeket lehet kiválasztani!</p>";
        }
        if ($_GET["error"]== "invalidssn") {
            echo "<p class='red'>Érvénytelen tajszámot adott meg</p>";
        }
        if ($_GET["error"]== "none") {
            echo "<p class='green '>Az új játékos adatai sikeresen rögzítésre kerültek!</p>";
        }
    }
  ?>
  </div>
</form>

<?php
    include 'footer.php';
