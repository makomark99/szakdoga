<?php
  include_once 'includes/dbh.inc.php';
  include_once 'header.php';
  include_once 'check_user.php';
  include_once 'auto_logout.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
  $leavers=false;
  if (!isset($_POST['name'])) {
      $sql="SELECT * FROM players WHERE pIsMember=1;";
  } else {
      $search=mysqli_real_escape_string($conn, $_POST['name']);
      $sql = "SELECT * FROM players WHERE (pName LIKE '%$search%' OR pCode LIKE '%$search%') AND pIsMember=1 ;";
  }
  if (isset($_POST['leavers'])) {
      include_once 'navbar.php';
      $leavers=true;
      $sql="SELECT * FROM players WHERE pIsMember=0;";
  }
  if (isset($_POST['detailed'])) {
      include_once 'navbar.php';
      $pl="";
      $trainer="";
      $year="";
      $sql="SELECT * FROM players P JOIN staff S on P.pTId=S.sId WHERE (P.pIsmember=1) ";
      if (isset($_POST['pL'])&& $_POST['pL']!=""&& $_POST['pL']!=null && $_POST['pL']!="NULL") {
          $pl=$_POST['pL'];
          $sql.="AND (P.pL1='$pl' OR P.pL2='$pl' OR P.pL3='$pl') ";
          // $sql="SELECT * FROM players WHERE (pL1='$pl' OR pL2='$pl' OR pL3='$pl') AND pIsMember=1;";
          echo "A/az ",$pl," csapat játékosa(i)<br>";
      }
      if ($_POST['pL']=="" && $_POST['pL']!="NULL") {
          $sql.="AND (P.pL1 is NULL) ";
          // $sql="SELECT * FROM players WHERE pL1 is NULL AND pIsMember=1;";
          echo "A játékengedély nélküli játékos(ok)<br>";
      }

      if (isset($_POST['pTId']) && $_POST['pTId']!="") {
          $trainer=$_POST['pTId'];
          $sql.="AND (P.pTId='$trainer')" ;
          // $sql="SELECT * FROM players P INNER JOIN staff S ON P.pTId=S.sId WHERE P.pTId='$trainer' AND P.pIsMember=1;";
          $r=mysqli_query($conn, $sql);
          $ro=mysqli_fetch_assoc($r);
          $n=$ro['sName'];
          echo $n, " nevű edző játékosa(i)<br>";
      } //sId
      if (isset($_POST['year']) && $_POST['year']!="") {
          $year=mysqli_real_escape_string($conn, $_POST['year']);
          $sql.="AND (P.pBDate LIKE '$year%')" ;
          // $sql="SELECT * FROM players WHERE pBDate LIKE '$year%' AND pIsMember=1;";
          echo "A következő évben született játékos(ok): $year<br>";
      }
      if (isset($_POST['pArr']) && $_POST['pArr']!="") {
          $condition=$_POST['pArr'];
          if (isset($_POST['pArrM']) && $_POST['pArrM']!="") {
              $condition=$condition.'-'.$_POST['pArrM'];
          }
          $sql.="AND (P.pArrival LIKE '$condition%')";
          // $sql="SELECT * FROM players WHERE pArrival LIKE '$condition%' AND pIsMember=1;";
          echo "A következő évben igiazolt játékos(ok): $condition<br>";
      }
      $sql.="ORDER BY P.pName;";
  }
    $result=mysqli_query($conn, $sql);
    $queryResults=mysqli_num_rows($result);
    $th=1;
      if ($queryResults>0) {
          echo "<h3 class='mt-2'>A keresésnek $queryResults találata van!</h3>"
      ?>
<div class="container sm-col-10 mt-4 table-responsive">
  <h1 class="text-center m-4"><?php echo $leavers ? "Távozott játékosok adatai" : "Játékosok adatai"; ?>
  </h1>

  <table class="table table-dark table-hover">
    <thead class="thead-light ">
      <tr>
        <th>#</th>
        <th>Név</th>
        <th>Személy kód</th>
        <th>Születési dátum</th>
        <th>Életkor</th>
        <th>Igazolás dátuma</th>
        <?php echo $leavers ? "<th>Távozás dátuma</th>" : "<th>Játékengedélyek</th>"; ?>
        <th>Érvényes sportorvosi</th>
        <th>Műveletek</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row=mysqli_fetch_assoc($result)) {
          $time= strtotime($row['pBDate']);
          $age=floor((time()-$time)/(60*60*24)/365.2425);
          $id= $row['pId']; ?>
      <tr data-href="p_view.php?id=<?php echo $id; ?>">
        <td class="align-middle"> <?php echo $th++; ?>
        </td>
        <td class="align-middle"> <?php echo $row['pName']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['pCode']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['pBDate']; ?>
        </td>
        <td class="align-middle"> <?php echo $age; ?>
        </td>
        <td class="align-middle"> <?php echo $row['pArrival']; ?>
        </td>

        <td class="align-middle">

          <?php
          if (!$leavers) {
              echo $row['pL1'];
              if ($row['pL2']!="") {
                  echo ";\t";
                  echo $row['pL2'];
              }
              if ($row['pL3']!="") {
                  echo ";\t";
                  echo $row['pL3'];
              }
          } else {
              echo $row['pDeparture'];
          } ?>
        </td>
        <?php
                if (($row['pLMCDate'] != "") && ($row['pLMCDate']!=0000-00-00)) {
                    $days=strtotime($row['pLMCDate']);
                    $elapsedDays=floor((time()-$days)/(60*60*24));
                    $valid=364;
                    if ($age<18 && $elapsedDays<=$valid/2) {
                        $valid=$valid/2-$elapsedDays;
                        echo '<td class="align-middle">';
                        include "img/check-square.svg";
                        echo ' Érvényes '.$valid.' napig</td>';
                    } elseif ($age>=18 && $elapsedDays<=$valid) {
                        $valid=$valid-$elapsedDays;
                        echo '<td class="align-middle">';
                        include "img/check-square.svg";
                        echo ' Érvényes '.$valid.' napig</td>';
                    } elseif ($age<18) {
                        $valid=$valid/2-$elapsedDays;
                        echo '<td class="align-middle">';
                        include "img/hourglass-bottom.svg";
                        echo ' Lejárt '.abs($valid).' napja </td>';
                    } else {
                        $valid=$valid-$elapsedDays;
                        echo '<td class="align-middle">';
                        include "img/hourglass-bottom.svg";
                        echo ' Lejárt '.abs($valid).' napja </td>';
                    }
                } else {
                    echo '<td class="align-middle">';
                    include "img/x-square.svg";
                    echo ' Még nem volt! </td>';
                } ?>
        <td class="align-middle ">
          <a href="p_modify.php?id=<?php echo $id; ?>"
            title="Szerkesztés" class="btn btn-outline-warning 
                  <?php if (!$sadmin) {
                    echo 'disabled';
                } ?>">
            <?php include 'img/pencil.svg' ?>
          </a>
          <a title="Törlés" class="btn btn-outline-danger <?php if (!$sadmin) {
                    echo 'disabled';
                } ?>" data-bs-toggle="modal"
            data-bs-target="#delete<?php echo $id; ?>">
            <!--egyedi id kell, mert minding az elsőt találta meg-->
            <?php include 'img/trash.svg' ?>
          </a>

          <!-- Modal -->


        </td>
      </tr>

      <div class="modal fade" id="delete<?php echo $id; ?>"
        tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content text-dark fs-5">
            <div class="modal-header">
              <h4 class="modal-title" id="deleteLabel">Játékos törlése</h4>
              <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <?php
                          echo 'Biztosan szeretné <strong>TÖRÖLNI</strong> a következő nevű játkost az adatbázisból: '.$row['pName'].' ?'; ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
              <a href="p_delete.php?id=<?php echo $id; ?>"
                class="btn btn-danger">Törlés </a>
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
</div>
<?php include_once 'footer.php'; ?>
<!-- <script src="row_click.js"></script> -->