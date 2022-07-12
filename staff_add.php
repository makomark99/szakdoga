<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
   
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
?>
<h1 class="text-center mb-5">Új munkatárs rögzítése</h1>
<form class="row g-3 " action="includes/addplayer.inc.php" method="post">
  <div class="col-md-6 col-lg-3">
    <label for="name" class="form-label">Név*</label>
    <input name="sName" type="text" title="Csak betűk használata lehetséges" pattern="^[a-zA-Z0-9]*$" class="form-control" id="name" placeholder="Vezetéknév Keresztnév" required>
  </div>
  
  <div class="col-md-6 col-lg-3 ">
    <label for="sPost" class="form-label">Beosztás/Pozíció*</label>
    <input name="sPost" title="Csak betűk használata lehetséges" pattern="^[a-zA-Z0-9]*$" placeholder="Utánpótlás masszőr" value="" type="text" class="form-control" id="sPost" required>
  </div>

  <div class="col-md-4 col-lg-2">
    <label for="bdate" class="form-label">Születési dátum</label>
    <input name="sBDate"  type="date" max="9999-11-11" title="" class="form-control" id="bdate" >
  </div>
  
  <div class="col-md-4 col-lg-2">
    <label for="code" class="form-label">MKSZ Személy kód</label>
    <input name="sCode" type="number" class="form-control" min=100 max=999999 id="code" placeholder="MKSZ személy kód"
      >
  </div>
  <div class="col-md-4 col-lg-2">
    <label for="pwd" class="form-label">MKSZ jelszó</label>
    <input name="sPassword" type="text" class="form-control" id="pwd" placeholder="">
  </div>

  <div class="col-md-6 col-lg-3 ">
    <label for="email1" class="form-label">Céges e-mail</label>
    <input name="sEmail" type="email" class="form-control" id="email1" placeholder="minta@mkcse.hu">
  </div>
  <div class="col-md-6 col-lg-3 ">
    <label for="email2" class="form-label">Magán e-mail</label>
    <input name="sEmail2" type="email" class="form-control" id="email2" placeholder="minta@gmail.com">
  </div>

  <div class="col-md-4 col-lg-2 ">
    <label for="tel" class="form-label">1. Telefonszám</label>
    <input name="sTel" type="text" class="form-control" id="tel" placeholder="Telefonszám">
  </div>

  <div class="col-md-4 col-lg-2 ">
    <label for="sHA" class="form-label">Lakhely (település)</label>
    <input name="sHA" title="Csak betűk használata lehetséges" pattern="^[a-zA-Z0-9]*$" placeholder="Lakhely" value="" type="text" class="form-control" id="sHA">
  </div>

  <div class="col-md-4 col-lg-2">
    <label for="foto" class="form-label">Arcképes fotó &nbsp<?php include "img/filetype-jpg.svg"; echo"&nbsp"; include "img/filetype-png.svg"; ?></label>
    <input name="pPhoto" type="file" class="form-control" id="foto" disabled>
  </div>

  <div class="col-md-auto mt-4 input-group ">
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
