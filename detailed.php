<?php

    include_once 'includes/dbh.inc.php';
    include_once 'header.php';
    include_once 'navbar.php';
    include_once 'includes/arrays.php';
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
?>


<h2 class="text-center mb-5">Részletes játékos kereső</h2>
<form class="row g-4" action="livesearch.php" method="post">
  <div class="col-auto ">
    <?php
    $sql5="SELECT DISTINCT pL1 as pl FROM players WHERE pIsMember=1 ORDER BY pl";
    $result5=mysqli_query($conn, $sql5);
    $qres5=mysqli_num_rows($result5);
    ?>
    <label class="form-label">Csapat kiválasztása (<?php echo $qres5-1; ?> csapat közül)</label>
    <select name="pL" class="form-select">
      <option value="NULL">Nincs játékengedély kiválasztva</option>';
      <?php
          if ($qres5>0) {
              while ($row5=mysqli_fetch_assoc($result5)) {
                  echo '<option value="'.$row5['pl'].'">';
                  if ($row5['pl']=="") {
                      echo "Nincs kikérve";
                  } else {
                      echo $row5['pl'];
                  } ?>
      </option>
      <?php
              }
          }
          ?>
    </select>
  </div>

  <div class="col-auto">
    <?php
            $sql="SELECT * FROM staff S INNER JOIN trainers T ON S.sId= T.sId
            WHERE tIsCoach=1;";
            $result=mysqli_query($conn, $sql);
            $queryResults=mysqli_num_rows($result); ?>
    <label class="form-label"> Edző kiválasztása (<?php echo $queryResults;?> edző közül)</label>
    <select name="pTId" class="form-select">
      <option value="">Nincs edző kiválasztva</option>
      <?php
            if ($queryResults>0) {
                while ($row=mysqli_fetch_assoc($result)) {
                    echo '<option value='.$row['sId'].'>'.$row['sName'].'</option>';
                }
            }
            ?>
    </select>
  </div>
  <div class="col-auto">
    <?php $sql2="SELECT DISTINCT YEAR(pBDate) AS MYR FROM players ORDER BY MYR; ";
         $result2=mysqli_query($conn, $sql2);
         $qres=mysqli_num_rows($result2);
        ?>
    <label class="form-label">Keresés születési év alapján (<?php echo $qres; ?> közül) </label>
    <input class="form-control me-2" type="number" name="year" min=<?php echo date("Y")-120;?> max=<?php echo date("Y")-3;?> id="search"
    placeholder="éééé">
  </div>

  <div class="col-auto">
    <?php $sql3="SELECT DISTINCT YEAR(pArrival) AS ARY FROM players ORDER BY ARY; ";
         $result3=mysqli_query($conn, $sql3);
         $qres2=mysqli_num_rows($result3);
        ?>
    <label class="form-label">Keresés igazolás dátum alapján </label>
    <select name="pArr" class="form-select">
      <option value="">Nincs év kiválasztva</option>
      <?php
            if ($qres2>0) {
                while ($row2=mysqli_fetch_assoc($result3)) {
                    if ($row2['ARY']!=0) {
                        echo '<option value='.$row2['ARY'].'>'.$row2['ARY'].'</option>';
                    }
                }
            }
            ?>
    </select>
    <select name="pArrM" class="form-select">
      <option value="">Nincs hónap kiválasztva</option>
      <?php $m=1;
              while ($m!=13) {
                  if ($m<10) {
                      $m='0'.$m;
                  } //nem jó a lekérdezés a hónap miatt (5-05)
                  echo '<option value='.$m.'>'.$m.'</option>';
                  $m++;
              }
            ?>
    </select>
  </div>

  <div class="col-auto">
    <label class="form-label">Keresés lakhely alapján</label>
    <input class="form-control me-2" value="" type="text" name="home" id="home" placeholder="Település">
  </div>

  <div class="col-auto">
    <label class="form-check-label" for="shostel">
      Kollégista
    </label>
    <br>
    <input class="form-check-input ms-4 mx-auto" type="checkbox" value="" name="shostel" id="shostel">

  </div>

  <div class="col-md-auto text-center mx-auto">
    <br> <button type="submit" name="detailed" class="mt-2 btn btn-primary">Keresés</button>
  </div>
</form>

<?php
    include 'footer.php';
