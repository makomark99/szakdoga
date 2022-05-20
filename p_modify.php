<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
    include_once 'auto_logout.php';
    
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
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
<form class="row g-3" action="includes/modifyplayer.inc.php" method="post">
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
    <?php } else { ?> <?php } ?> >
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
    <input name="pLMCDate" type="text" onfocus="(this.type='date')" max="1999-11-11"
      value="<?php $row['pLMCDate']; ?>"
      placeholder="<?php echo $row['pLMCDate']; ?>"
      class="form-control" id="mcdate">
  </div>
  <div class="col-md-4 col-lg-2">
    <label for="mc" class="form-label">Sportorvos </label>
    <input name="pMCD" type="text"
      value="<?php $row['pMCD']; ?>"
      class="form-control" id="mc"
      placeholder="<?php echo $row['pMCD']; ?>">
  </div>

  <div class="col-md-6 col-lg-3">
    <label for="email1" class="form-label">1. E-mail</label>
    <input name="pPEmail" type="text" class="form-control" id="email1"
      vlaue="<?php $row['pPEmail']; ?>"
      placeholder="<?php echo $row['pPEmail']; ?>">
  </div>
  <div class="col-md-6 col-lg-3">
    <label for="email2" class="form-label">2. E-mail</label>
    <input name="pEmail" type="email" class="form-control" id="email2"
      vlaue="<?php $row['pEmail']; ?>"
      placeholder="<?php echo $row['pEmail']; ?>">
  </div>
  <div class="col-md-4 col-lg-2 ">
    <label for="tel1" class="form-label">1. Telefonszám</label>
    <input name="pPTel" type="text" class="form-control" id="tel1"
      value="<?php $row['pPTel']; ?>"
      placeholder="<?php echo $row['pPTel']; ?>">
  </div>
  <div class="col-md-4 col-lg-2 ">
    <label for="tel2" class="form-label">2. Telefonszám</label>
    <input name="pTel" type="text" class="form-control" id="tel2"
      value="<?php $row['pTel']; ?>"
      placeholder="<?php echo $row['pTel']; ?>">
  </div>
  <div class="col-md-2 col-lg-1">
    <label for="pSH" class="form-label">Kollégista?</label>
    <select class="form-select" name="pSH" id="pSH">
      <?php if ($row['pSH']==0) {
                echo '<option value="0">Nem</option>
                <option value="1">Igen</option>';
            } else {
                echo '<option value="1">Igen</option>
                  <option value="0">Nem</option>';
            } ?>
    </select>
  </div>
  <?php $i=0; ?>
  <div class="col-md-2 col-lg-1">
    <label for="shirtsize" class="form-label">Pólóméret</label>
    <select name="pTSize" id="shirtsize" class="form-select">
      <option value="<?php $row['pTSize']; ?>">
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

  <?php
            $x=1;
            $y=0;
            while ($x!=4) {
                ?>
  <div class="col-md-4 col-lg-2">
    <label class="form-label">Játékengedély <?php echo $x; ?></label>
    <select name="pL<?php echo $x; ?>" class="form-select">
      <option value="<?php $row["pL$x"]; ?>"><?php echo $row["pL$x"];
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

  <div class="col-md-4 col-lg-2 ">
    <label for="pSsn" class="form-label">Tajszám</label>
    <input name="pSsn" type="text"
      value="<?php echo $row['pSsn']; ?>"
      class="form-control <?php if ($row['pSsn']!="") { ?> notm <?php } ?> "
      id="pSsn"
      placeholder="<?php echo $row['pSsn']; ?>"
      <?php if ($row['pSsn']!="") { ?>disabled
    <?php } else { ?> <?php } ?> >
  </div>

  <div class="col-md-4 col-lg-2 ">
    <label for="pHA" class="form-label">Lakhely (település)</label>
    <input name="pHA" type="text" class="form-control"
      value="<?php $row['pHA']; ?>" <?php echo $row['pHA']; ?>>
  </div>

  <div class="col-md-4 col-lg-2">
    <label for="foto" class="form-label">Arcképes fotó</label>
    <input name="pPhoto" type="file"
      value="<?php $row['pPhoto']; ?> "
      class="form-control" id="foto" disabled>
  </div>

  <div class="col-md-auto mt-4">
    <button type="submit" name="modify" class="btn btn-primary">Módosít</button>
  </div>

</form>

<?php
        }
    }/*else{
  echo "<h2 class='red'>  Valami nem stimmel, próbálkozzon újra ELSE!</h2>";
}*/
?>




<?php
    if (isset($_GET["error"])) {
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
            echo "<p class='green '>A kiválasztott játékos adatai sikeresen módosításra kerültek!</p>";
        }
    }

include_once 'footer.php';
