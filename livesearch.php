<?php
  include_once 'includes/dbh.inc.php';
  include_once 'header.php';
  include_once 'check_user.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
  function clickToView(int $id)
  {
      /*echo 'style="cursor:pointer;"
    onclick="window.location=`p_view.php?id='.$id.'`"';*/
      echo ' style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#player_view'.$id.'"';
  }
  $leaver=false;
   if (!isset($_POST['name']) || $_POST['name']!=="") {
       $sql="SELECT * FROM players WHERE pIsMember=1;";
   }
   if (isset($_POST['name'])) {
       $search=mysqli_real_escape_string($conn, $_POST['name']);
       $sql = "SELECT * FROM players WHERE (pName LIKE '%$search%' OR pCode LIKE '%$search%') AND pIsMember=1 ORDER BY pBDate ";
   }
  if (isset($_POST['leavers'])) {
      include_once 'navbar.php';
      $leaver=true;
      $sql="SELECT * FROM players WHERE pIsMember=0 ";
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
          echo "A/az ",$pl," csapat játékosa(i)<br>";
      }
      if ($_POST['pL']=="" && $_POST['pL']!="NULL") {
          $sql.="AND (P.pL1 is NULL) ";
          echo "A játékengedély nélküli játékos(ok)<br>";
      }
      if (isset($_POST['pTId']) && $_POST['pTId']!="") {
          $trainer=$_POST['pTId'];
          $sql.="AND (P.pTId='$trainer')" ;
          $r=mysqli_query($conn, $sql);
          $ro=mysqli_fetch_assoc($r);
          $n=$ro['sName'];
          echo $n, " nevű edző játékosa(i)<br>";
      } //sId
      if (isset($_POST['year']) && $_POST['year']!="") {
          $year=mysqli_real_escape_string($conn, $_POST['year']);
          $sql.="AND (P.pBDate LIKE '$year%')" ;
          echo "A következő évben született játékos(ok): $year<br>";
      }
      if (isset($_POST['pArr']) && $_POST['pArr']!="") {
          $condition=$_POST['pArr'];
          if (isset($_POST['pArrM']) && $_POST['pArrM']!="") {
              $condition=$condition.'-'.$_POST['pArrM'];
          }
          $sql.="AND (P.pArrival LIKE '$condition%')";
          echo "A következő évben igiazolt játékos(ok): $condition<br>";
      }
      if (isset($_POST['home']) && $_POST['home']!="") {
          $search2=mysqli_real_escape_string($conn, $_POST['home']);
          $sql.="AND (P.pHA LIKE '%$search2%') ";
          echo "Lakhely : $search2<br>";
      }
      if (isset($_POST['shostel'])) {
          if ($_POST['shostel']==2) {
              $sql.="AND (P.pSH=1) ";
              echo "Kollégista játékos(ok)<br>";
          }
          if ($_POST['shostel']==1) {
              $sql.="AND (P.pSH<>1 OR P.pSH=' ' OR P.pSH IS NULL OR P.pSH='' OR P.pSH=0) ";
              echo "Nem kollégista játékos(ok)<br>";
          }
      }
      if (isset($_POST['pPost']) && $_POST['pPost']!="") {
          $post=$_POST['pPost'];
          $sql.="AND (P.pPost = '$post') " ;
          echo "A következő poszton játszó játékos(ok): $post<br>";
      }
      if (isset($_POST['pPHand']) && $_POST['pPHand']!="") {
          $hand= $_POST['pPHand'];
          $sql.="AND (P.pPHand = '$hand')" ;
          echo ($hand=="Bal")? "A balkezes játékosok: <br>":"A jobbkezes játékosok: <br>";
      }
      $sql.="ORDER BY P.pName ";
  }
  $_SESSION["player_query"]=$sql;
    $result=mysqli_query($conn, $_SESSION["player_query"]);
    $queryResults=mysqli_num_rows($result);
    $th=1;
      if ($queryResults>0) {
          echo "<h3 class='mt-2'>A keresésnek $queryResults találata van!</h3>"
      ?>
<div class="container sm-col-10 mt-4 table-responsive">
	<h1 class="text-center m-4">
		<?php echo $leaver ? "Távozott játékosok adatai" : "Játékosok adatai"; ?>
	</h1>

	<?php  //Pagination
        $actualPage=((!isset($_GET["page"])) ? 1 : $_GET["page"]);
          echo $actualPage;
          $numPerPage=10;
          $startFrom=($actualPage-1)*$numPerPage;
          $sql_limited=$sql."LIMIT $startFrom, $numPerPage";
          $limited_result=mysqli_query($conn, $sql_limited);
          $lmited_queryResults=mysqli_num_rows($limited_result); ?>
	<div class="table-responsive">
		<nav aria-label="Page navigation example">
			<ul class=" pagination justify-content-center">

				<?php
          $lastPageNum=ceil($queryResults/$numPerPage);
         
          for ($x=0;$x<=$lastPageNum;$x++) {
              ($x==0)?$x++:$x;
              $actualPage=((!isset($_GET["page"])) ? 1 : $_GET["page"]); ?>
				<div class="page-item ">
					<input type="hidden" autocomplete="off"
						value="<?php echo $x ; ?>" name="page"
						class="pageTo">
					<button type="button"
						onclick='window.location="players.php?page=<?php echo $x; ?>"'
						class=" page-link bg-dark <?php echo ($x==$actualPage)?"bg-black text-white":""; ?>">
						<?php echo $x ; ?>
					</button>
				</div><?php
          } ?>

			</ul>
		</nav>
	</div>
	<table class="table table-dark table-hover">
		<thead class="thead-light ">
			<tr>
				<th>#</th>
				<th>Kép</th>
				<th>Név</th>
				<th>Személy kód</th>
				<th>Születési dátum</th>
				<th>Életkor</th>
				<!-- <th>Igazolás dátuma</th> -->
				<?php echo $leaver ? "<th>Távozás dátuma</th>" : "<th>Játékengedélyek</th>"; ?>
				<th>Sportorvosi engedély</th>
				<?php echo ($leaver||$gUser) ? : "<th>Műveletek</th>"; ?>
			</tr>
		</thead>
		<tbody>
			<?php while ($row=mysqli_fetch_assoc($limited_result)) {
              $time= strtotime($row['pBDate']);
              $age=floor((time()-$time)/(60*60*24)/365.2425);
              $id= $row['pId']; ?>
			<tr>
				<a>

					<td <?php clickToView($id); ?> width=2%
						class="align-middle">
						<?php echo $th++; ?>
					</td>
					<td <?php clickToView($id); ?>
						width=5% class="align-middle text-center p-0 m-0 ">
						<img width="70%" class="rounded " style=" margin-top:1px; margin-bottom:1px;"
							src="<?php echo $row['pPhoto']; ?>">
					</td>
					<td <?php clickToView($id); ?>
						class="align-middle">
						<?php echo $row['pName']; ?>
					</td>
					<td <?php clickToView($id); ?>
						class="align-middle">
						<?php echo $row['pCode']; ?>
					</td>
					<td <?php clickToView($id); ?>
						class="align-middle">
						<?php echo $row['pBDate']; ?>
					</td>
					<td <?php clickToView($id); ?>
						class="align-middle">
						<?php echo $age; ?>
					</td>
					<!-- <td class="align-middle">
                    <?php echo $row['pArrival']; ?>
					</td> -->

					<td <?php clickToView($id); ?>
						class="align-middle">

						<?php
          if (!$leaver) {
              if ($row['pL1']!="" || $row['pL1']!=null) {
                  echo $row['pL1'];
              }
              if ($row['pL2']!="" || $row['pL2']!=null) {
                  echo ";\t";
                  echo $row['pL2'];
              }
              if ($row['pL3']!="" || $row['pL3']!=null) {
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
					<?php
            if (!$leaver) { ?>
				</a>
				<td class="align-middle <?php if ($gUser) {
                echo 'd-none';
            } ?>">
					<a href="p_modify.php?id=<?php echo $id; ?>"
						title="Szerkesztés" class="btn btn-outline-warning 
                  <?php if (!$sadmin) {
                echo 'disabled';
            } ?>">
						<?php include 'img/pencil.svg' ?>
					</a>
					<a title="Törlés" class="btn btn-outline-danger " data-bs-toggle="modal"
						data-bs-target="#delete<?php echo $id; ?>">
						<!--egyedi id kell, mert minding az elsőt találta meg-->
						<?php include 'img/trash.svg' ?>
					</a>
					<?php } ?>
				</td>
			</tr>
			<!-- Modal -->
			<div class="modal fade" id="delete<?php echo $id; ?>"
				tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content text-dark fs-5">
						<div class="modal-header">
							<h4 class="modal-title" id="deleteLabel">Játékos törlése</h4>
							<button type="button" class="btn-close " data-bs-dismiss="modal"
								aria-label="Close"></button>
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
			<!-- player_view modal -->
			<div class="modal fade"
				id="player_view<?php echo $id; ?>" tabindex="-1"
				aria-labelledby="player_view" aria-hidden="true">
				<div class="modal-dialog modal-fullscreen modal-dialog-centered">
					<div class="modal-content bg-black text-white fs-5">
						<div class="modal-header">
							<h1 class="ms-2" id="player_view">
								<?php echo mb_convert_case($row['pName'], MB_CASE_TITLE, "UTF-8") ?>
								adatai
							</h1>
							<button type="button" style="color:white;" class="btn-close btn-close-white "
								data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<div class="card bg-black">
								<div class="row d-flex">
									<div class="col-lg-3 col-md-12 text-center me-2 ">
										<img width="90%" class="mt-3 mb-1 img-thumbnail "
											src="<?php echo $row["pPhoto"]; ?>"
											title=" <?php echo mb_convert_case($row['pName'], MB_CASE_TITLE, "UTF-8"); ?>"
											alt=" <?php echo mb_convert_case($row['pName'], MB_CASE_TITLE, "UTF-8"); ?>">
									</div>

									<div class="col-lg-9 col-md-12 row d-flex mt-5">
										<div class="col-lg-3 col-md-6    ">
											<label> <i>MKSZ Személy kód</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo $row['pCode']; ?>
											</h4>
											<label> <i>Születési hely</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo mb_convert_case($row['pBPlace'], MB_CASE_TITLE, "UTF-8"); ?>
											</h4>
											<label> <i>Születési dátum</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo $row['pBDate']; ?>
											</h4>
											<label> <i>Anyja neve</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo mb_convert_case($row['pMsN'], MB_CASE_TITLE, "UTF-8"); ?>
											</h4>
											<label> <i>Nemzetiség</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo $row['pNat']; ?>
											</h4>
										</div>
										<div class="col-lg-3 col-md-6  ">
											</h4>
											<label> <i> Sportorvosi dátum</i></label>
											<h4 class="mb-4 mt-1"><?php if ($row['pLMCDate']!="" && $row['pLMCDate']!=0000-00-00) {
                    echo $row['pLMCDate'];
                } else {
                    echo "Még nem volt vizsgálaton";
                } ?>
											</h4>
											<label> <i>Sportorvos</i> </label>
											<h4 class="mb-4 mt-1"><?php if ($row['pMCD']!="") {
                    echo $row['pMCD'];
                } else {
                    echo "nincs megadva";
                } ?>
											</h4>
											<label> <i>Edző neve</i> </label>
											<h4 class="mb-4 mt-1"><?php if ($row['pTId']!="") {
                    $sql2="SELECT * FROM staff S INNER JOIN trainers T ON S.sId=T.sId WHERE T.tIsCoach=1;";
                    $result2=mysqli_query($conn, $sql2);
                    $queryResults2=mysqli_num_rows($result);
                    if ($queryResults2>0) {
                        while ($row2=mysqli_fetch_assoc($result2)) {
                            if ($row['pTId']==$row2['sId']) {
                                echo $row2['sName'];
                            }
                        }
                    }
                } else {
                    echo "nincs megadva";
                } ?>
											</h4>
											<label> <i>Igazolás dátuma</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo $row['pArrival']; ?>
											</h4>
											<label> <i>Lakhely</i> </label>
											<h4 class="mb-4 mt-1">
												<?php if ($row['pHA']!="") {
                    echo $row['pHA'];
                    ;
                } else {
                    echo "nincs megadva";
                } ?>
											</h4>
										</div>
										<div class="col-lg-3 col-md-6  ">
											<label> <i>Kollégista?</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pSH'])?'igen':'nem'; ?>
											</h4>
											<label> <i>Telefonszám</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pTel']=='')?'nincs megdva':$row['pTel']; ?>
											</h4>
											<label> <i>Szülő elefonszám</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pPTel']=='')?'nincs megdva':$row['pPTel']; ?>
											</h4>
											<label> <i>E-mail</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pEmail']=='')?'nincs megdva':$row['pEmail']; ?>
											</h4>
											<label> <i>Szülő e-mail</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pPEmail']=='')?'nincs megdva':$row['pPEmail']; ?>
											</h4>
										</div>
										<div class="col-lg-3 col-md-6  ">
											<label> <i>Pólóméret</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pTSize']=='')?'nincs megdva':$row['pTSize']; ?>
											</h4>
											<label> <i>Tajszám</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pSsn']=='')?'nincs megdva':$row['pSsn']; ?>
											</h4>
											<label> <i>Ügyesebbik kéz</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pPHand']=='')?'nincs megdva':$row['pPHand']; ?>
											</h4>
											<label> <i>Poszt</i> </label>
											<h4 class="mb-4 mt-1">
												<?php echo ($row['pPost']=='')?'nincs megdva':$row['pPost']; ?>
											</h4>
											<label> <i>Játékengedélyek</i> </label>
											<h4 class="mb-4 mt-1">
												<?php
                    echo $row['pL1'];
              if ($row['pL2']!="") {
                  echo ";\t ";
                  echo $row['pL2'];
              }
              if ($row['pL3']!="") {
                  echo ";\t ";
                  echo $row['pL3'];
              } ?>
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
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
<!-- <form action="players.php" method="post" class="page-item">
					<input type="hidden" value=<?php echo $actualPage--; ?>
name="page">
<button type="submit"
	class=" navbar-dark bg-dark page-link <?php ($actualPage==1)? 'disabled' : '' ?>">
	Előző
</button>
</form> -->

<!-- <form action="players.php" method="post" class="page-item">
					<input type="hidden" value=<?php echo $actualPage+=2; ?>
name="page">
<button type="submit" class=" bg-dark page-link">Következő
</button>
</form> -->