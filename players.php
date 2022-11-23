	<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
  include_once 'includes/arrays.php';
  if (!isset($_SESSION["loggedin"])) {
      echo '<script> location.replace("login.php"); </script>';
  }
?>
	<script defer src="calculate.js">
	</script>

	<div class="col-md-12  justify-content-end">
		<div class="d-flex  row">
			<div class=" d-flex col-lg-5 col-md-2  justify-content-start">
				<div class="spinner-border d-none text-primary mt-1 p-2" id="spinner" role="status">
					<span class="visually-hidden">Keresési adatok betöltése...</span>
				</div>

			</div>
			<div class=" d-flex col-lg-7 col-md-10  justify-content-end">
				<!-- <input class="form-control ms-2 me-2" type="text" autocomplete="off" name="search" id="search"
				placeholder="Játékos keresése név, vagy személy kód alapján" autofocus> -->
				<!-- Button trigger modal -->
				<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Játékos szűrő">
					<a title="Szűrő" data-bs-toggle="modal" data-bs-target="#detail" class="btn btn-outline-primary me-2">
						<?php include "img/filter.svg"?>
					</a>
				</div>
				<!-- Modal -->
				<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content text-dark">
							<form action="players.php" method="post">
								<div class="modal-header">
									<h1 class="modal-title fs-3" id="">Részletes játékos kereső</h1>
									<button type="button" class="btn-close" data-bs-dismiss="modal"
										aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<div class="row g-2 d-flex">
										<div class="col-md-6 mb-3">
											<label class="form-label">Csapat kiválasztása
												(<?php echo count($teams);$j=0;?>
												csapat
												közül)</label>
											<select name="pL" class="form-select">
												<option value="NULL">Nincs játékengedély kiválasztva</option>;
												<?php while ($j!=count($teams)) {
    $tmp=$teams[$j]; ?>
												<option
													value="<?php echo $tmp; ?>">
													<?php if ($tmp=="") {
        echo "Nincs kikérve";
    } else {
        echo $tmp;
    } ?>
												</option>
												<?php $j++;
} ?>
											</select>
										</div>

										<div class="col-md-6 mb-3">
											<?php
            $sql="SELECT * FROM staff S INNER JOIN trainers T ON S.sId= T.sId
            WHERE tIsCoach=1;";
            $result=mysqli_query($conn, $sql);
            $queryResults=mysqli_num_rows($result); ?>
											<label class="form-label"> Edző kiválasztása
												(<?php echo $queryResults;?>
												edző
												közül)</label>
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
										<div class="col-md-6 mb-3">
											<?php $sql2="SELECT DISTINCT YEAR(pBDate) AS MYR FROM players ORDER BY MYR; ";
         $result2=mysqli_query($conn, $sql2);
         $qres=mysqli_num_rows($result2);
        ?>
											<label class="form-label">Keresés születési év alapján
												(<?php echo $qres; ?>
												közül)
											</label>
											<input class="form-control me-2" type="number" name="year"
												min=<?php echo date("Y")-120;?>
											max=<?php echo date("Y")-3;?>
											id="search"
											placeholder="éééé">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Keresés lakhely alapján</label>
											<input class="form-control me-2" value="" type="text" name="home" id="home"
												placeholder="Település">
										</div>

										<div class="col-md-6 mb-3">
											<?php $sql3="SELECT DISTINCT YEAR(pArrival) AS ARY FROM players ORDER BY ARY; ";
         $result3=mysqli_query($conn, $sql3);
         $qres2=mysqli_num_rows($result3);
        ?>
											<label class="form-label">Keresés igazolás dátum alapján (év) </label>
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
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Keresés igazolás dátum alapján (hónap)</label>
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

										<div class="col-md-4 mb-3">
											<label for="pSH" class="form-label">Kollégista?</label>
											<select class="form-select" name="shostel" id="shostel">
												<option value="">Nincs kiválasztva érték</option>
												<option value="1">Nem</option>
												<option value="2">Igen</option>
											</select>
										</div>
										<div class="col-md-4 mb-3">
											<label for="pPHand" class="form-label">Ügyesebb kéz kiválasztása</label>
											<select class="form-select" name="pPHand" id="pPHand">
												<option value="">Nincs kiválasztva érték</option>
												<option value="Jobb">Jobb</option>
												<option value="Bal">Bal</option>
											</select>
										</div>
										<div class="col-md-4 mb-3">
											<label for="pPost" class="form-label">Poszt kiválasztása (7 közül)</label>
											<select class="form-select" name="pPost" id="pPost">
												<option value="">Nincs kiválasztva érték</option>
												<option value="Balátlövő">Balátlövő</option>
												<option value="Balszélső">Balszélső</option>
												<option value="Jobbátlövő">Jobbátlövő</option>
												<option value="Jobbszélső">Jobbszélső</option>
												<option value="Irányító">Irányító</option>
												<option value="Beálló">Beálló</option>
												<option value="Kapus">Kapus</option>
											</select>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
									<a><button type="submit" name="detailed" class="btn btn-primary">Keresés</button> </a>
								</div>
							</form>
						</div>
					</div>
				</div>
				<form class="m-0" action="players.php" method="post">
					<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Távozók">
						<button class="btn btn-outline-primary me-2 " title=" Távozók" type="submit" name="leavers">
							<?php include "img/leave.svg"?>
						</button>
					</div>
				</form>

				<!-- Button trigger modal -->
				<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kinevelési költség kalkulátor">
					<a id="calcModal" class="btn btn-outline-primary me-2" data-bs-toggle="modal"
						data-bs-target="#calculate">
						<?php include_once 'img/calculator.svg' ?>
					</a>
				</div>
				<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Új játékosok nyilvántartásba vétele">
					<a href="p_new.php" id="newPlayers" class="btn btn-outline-primary me-2">
						<?php include_once 'img/person-plus.svg' ?>
					</a>
				</div>
				<div data-bs-toggle="tooltip" data-bs-placement="bottom" title="Játékosok hozzáadása ">
					<a href="p_add.php" class="btn btn-outline-primary ">
						<?php include "img/plus-lg.svg"?>
					</a>
				</div>
			</div>


			<!-- Modal -->
			<div class="modal fade" id="calculate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg">
					<div class="modal-content text-dark fs-5">
						<div class="modal-header">
							<h3 class="modal-title" id="exampleModalLabel">Kinevelési költség kalkulátor</h3>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>


						</div>
						<div class="modal-body ">

							<div class="row g-2 d-flex">
								<div class="col-md-4  ">
									<label class="form-label" for="name">Játékos neve</label>
									<input name="name" id="pName" type="text" class="form-control mb-2 calcInput"
										placeholder="Vezetéknév Keresztnév">
								</div>
								<div class="col-md-4">
									<label class="form-label " for="">Játékos születési dátuma</label>
									<input name="birth" value="" placeholder="éééé.hh.nn." id="d1" type="date"
										onfocus="(this.type='text')" required
										max="<?php echo date("Y-m-d"); ?>"
										class="form-control mb-2 calcInput">

								</div>
								<div class="col-md-4">
									<label class="form-label " for="">Előző igazolás dátuma</label>
									<input name="lastConctract" value="" placeholder="éééé.hh.nn." id="d2" type="date"
										onfocus="(this.type='text')" required
										max="<?php echo date("Y-m-d"); ?>"
										class="form-control mb-2 calcInput">
								</div>
							</div>
							<hr class="m-2">
							<div class="text-center">
								<span>Legmagasabb felnőtt bajnoki osztály kiválasztása</span>
							</div>
							<div class="text-center">
								<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
									<input type="radio" class="btn-check " name="btnradio" id="nb1" autocomplete="off"
										checked="" />
									<label class="btn   btn-outline-primary" for="nb1">NB I</label>

									<input type="radio" class="btn-check " name="btnradio" id="nb1b" autocomplete="off" />
									<label class="btn   btn-outline-primary" for="nb1b">NB I/B</label>

									<input type="radio" class="btn-check " name="btnradio" id="otherTeam"
										autocomplete="off" />
									<label class="btn   btn-outline-primary" for="otherTeam">Egyéb</label>
								</div>
							</div>
							<hr class="m-2">
							<div class="text-center">
								<div>Válogatottság kiválasztása
									<a type="button" data-bs-toggle="tooltip" data-bs-placement="left"
										data-bs-title="Válogatottság után járó szorzó akkor vehető figyelembe, ha a játékos legalább 3
								hivatalos válogatott mérkőzésen szerepelt a jegyzőkönyvvben."><?php include "img/info-square.svg";?>
									</a>
								</div>
							</div>
							<div class="text-center">
								<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
									<input type="radio" class="btn-check" name="btnradio2" id="none" autocomplete="off"
										checked="" />
									<label class="btn  btn-outline-primary" for="none">Nincs</label>

									<input type="radio" class="btn-check" name="btnradio2" id="ifi" autocomplete="off" />
									<label class="btn  btn-outline-primary" for="ifi">Ifjúsági</label>

									<input type="radio" class="btn-check" name="btnradio2" id="junior"
										autocomplete="off" />
									<label class="btn  btn-outline-primary" for="junior">Junior</label>
									<input type="radio" class="btn-check" name="btnradio2" id="felnott"
										autocomplete="off" />
									<label class="btn  btn-outline-primary" for="felnott">Felnőtt</label>

									<input type="radio" class="btn-check" name="btnradio2" id="upsk" autocomplete="off" />
									<label class="btn  btn-outline-primary" for="upsk">Utánpótlás strandkézilabda</label>
									<input type="radio" class="btn-check" name="btnradio2" id="fsk" autocomplete="off" />
									<label class="btn  btn-outline-primary" for="fsk">Felnőtt strandkézilabda</label>
								</div>
							</div>
							<hr class="m-2">
							<div class="text-center">
								<div>Sportakadémiába történő igazolás
									<a type="button" data-bs-toggle="tooltip" data-bs-placement="left"
										data-bs-title="Ha a játékos kevesebb mint 3 évet töltött az előző sportszervezetben, akkor az összeg 70%-a illeti meg az átadó sportszervezetet."><?php include "img/info-square.svg";?>
									</a>
								</div>
								<div class="mt-1" role="group" aria-label="Basic radio toggle button group">
									<input type="radio" class="btn-check" name="btnradio3" id="other" onclick="enable()"
										checked />
									<label class="btn  btn-outline-primary" for="other">Nem</label>

									<input type="radio" class="btn-check" name="btnradio3" id="ac" onclick="disable()"
										autocomplete="off" />
									<label class="btn  btn-outline-primary" for="ac">Igen</label>
								</div>
							</div>
							<hr class="m-2">
							<table class="table table-bordered border border-secondary border-1 fs-6">
								<thead class="">
									<tr>
										<th>Életkor</th>
										<th>Egyesületben eltöltött évek</th>
										<th>Szorzó</th>
										<th>Nettó alapdíj</th>
										<th>Nettó összeg</th>
										<th>Bruttó összeg</th>
									</tr>

								</thead>
								<tr>
									<td class="info" id="out3"> Év</td>
									<td class="info text-center" id="out4"> Év</td>
									<td class="info text-center" id="out5"> </td>
									<td class="info" id="out0"> Ft</td>
									<td class="info" id="out1"> Ft</td>
									<td class="info" id="out2"> Ft</td>
								</tr>
							</table>
						</div>
						<div class="modal-footer ">

							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
							<button type="submit" id="reset" value="button" onclick="setDefaultPosition()"
								class="btn btn-danger">Alaphelyzet</button>
							<button type="submit" id="calc" value="submit" onclick="calculate()"
								class="btn btn-primary">Számítás</button>
						</div>
					</div>
				</div>
			</div>

			<div id="output">
				<?php
function clickToView(int $id)
            {
                /*echo 'style="cursor:pointer;"
    onclick="window.location=`p_view.php?id='.$id.'`"';*/
                echo ' style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#player_view'.$id.'"';
            }
  $leaver=false;

   
 $sql = "SELECT * FROM players WHERE pIsMember=1 ORDER BY pBDate ";
   
  if (isset($_POST['leavers'])) {
      include_once 'navbar.php';
      $leaver=true;
      $sql="SELECT * FROM players WHERE pIsMember=0 ";
  }
  ?>
				<h1 class="text-center mb-2">
					<?php echo $leaver ? "Távozott játékosok adatai" : "Játékosok adatai"; ?>
				</h1> <?php
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
          $sql.="AND (P.pHA LIKE '$search2') ";
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
          ?>
				<div class="container sm-col-10 mt-4 table-responsive">


					<table id='ptable' class="table table-dark table-hover">
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
								<?php echo ($leaver) ? : "<th>Műveletek</th>"; ?>
							</tr>
						</thead>
						<tbody>
							<?php while ($row=mysqli_fetch_assoc($result)) {
              $time= strtotime($row['pBDate']);
              $age=floor((time()-$time)/(60*60*24)/365.2425);
              $id= $row['pId']; ?>
							<tr height="70px">
								<a>

									<td <?php clickToView($id); ?>
										width=2%
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
                        echo '<td  class="align-middle">';
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
								<td class="align-middle">
									<a data-bs-toggle="tooltip" data-bs-placement="left" title="Játékos szerkesztése"
										href="p_modify.php?id=<?php echo $id; ?>"
										class="btn btn-outline-warning 
                  <?php if ($gUser) {
                echo 'disabled';
            } ?>">
										<?php include 'img/pencil.svg' ?>
									</a>

									<a data-bs-toggle="tooltip" data-bs-placement="right" title="Játékos törlése" class="btn btn-outline-danger <?php if ($gUser) {
                echo 'disabled';
            } ?>" data-bs-toggle="modal"
										data-bs-target="#delete<?php echo $id; ?>">
										<!--egyedi id kell, mert minding az elsőt találta meg-->
										<?php include 'img/trash.svg' ?>
									</a>

									<?php } ?>
								</td>
							</tr>
							<!-- Modal -->
							<div class="modal hide"
								id="delete<?php echo $id; ?>"
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
											<button type="button" class="btn btn-secondary"
												data-bs-dismiss="modal">Bezár</button>
											<a href="p_delete.php?id=<?php echo $id; ?>"
												class="btn btn-danger">Törlés </a>
										</div>
									</div>
								</div>
							</div>
							<!-- player_view modal -->

							<div class="modal hide"
								id="player_view<?php echo $id; ?>"
								tabindex="-1" aria-labelledby="player_view" aria-hidden="true">
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
															<label> <i class="text-secondary">MKSZ Személy kód</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo $row['pCode']; ?>
															</h4>
															<label> <i class="text-secondary">Születési hely</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo mb_convert_case($row['pBPlace'], MB_CASE_TITLE, "UTF-8"); ?>
															</h4>
															<label> <i class="text-secondary">Születési dátum</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo $row['pBDate']; ?>
															</h4>
															<label> <i class="text-secondary">Anyja neve</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo mb_convert_case($row['pMsN'], MB_CASE_TITLE, "UTF-8"); ?>
															</h4>
															<label> <i class="text-secondary">Nemzetiség</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo $row['pNat']; ?>
															</h4>
														</div>
														<div class="col-lg-3 col-md-6  ">
															</h4>
															<label> <i class="text-secondary"> Sportorvosi
																	dátum</i></label>
															<h4 class="mb-4 mt-1"><?php if ($row['pLMCDate']!="" && $row['pLMCDate']!=0000-00-00) {
                    echo $row['pLMCDate'];
                } else {
                    echo "Még nem volt vizsgálaton";
                } ?>
															</h4>
															<label> <i class="text-secondary">Sportorvos</i> </label>
															<h4 class="mb-4 mt-1"><?php if ($row['pMCD']!="") {
                    echo $row['pMCD'];
                } else {
                    echo "nincs megadva";
                } ?>
															</h4>
															<label> <i class="text-secondary">Edző neve</i> </label>
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
															<label> <i class="text-secondary">Igazolás dátuma</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo $row['pArrival']; ?>
															</h4>
															<label> <i class="text-secondary">Lakhely</i> </label>
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
															<label> <i class="text-secondary">Telefonszám</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo ($row['pTel']=='')?'nincs megdva':$row['pTel']; ?>
															</h4>
															<label> <i class="text-secondary">Szülő telefonszám</i>
															</label>
															<h4 class="mb-4 mt-1">
																<?php echo ($row['pPTel']=='')?'nincs megdva':$row['pPTel']; ?>
															</h4>
															<label> <i class="text-secondary">E-mail</i> </label>
															<h5 class="mb-4 mt-1">
																<?php echo ($row['pEmail']=='')?'nincs megdva':$row['pEmail']; ?>
															</h5>
															<label> <i class="text-secondary">Szülő e-mail</i> </label>
															<h5 class="mb-4 mt-1">
																<?php echo ($row['pPEmail']=='')?'nincs megdva':$row['pPEmail']; ?>
															</h5>
														</div>
														<div class="col-lg-3 col-md-6  ">
															<label> <i class="text-secondary">Pólóméret</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo ($row['pTSize']=='')?'nincs megdva':$row['pTSize']; ?>
															</h4>
															<label> <i class="text-secondary">Tajszám</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo ($row['pSsn']=='')?'nincs megdva':$row['pSsn']; ?>
															</h4>
															<label> <i class="text-secondary">Ügyesebbik kéz</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo ($row['pPHand']=='')?'nincs megdva':$row['pPHand']; ?>
															</h4>
															<label> <i class="text-secondary">Poszt</i> </label>
															<h4 class="mb-4 mt-1">
																<?php echo ($row['pPost']=='')?'nincs megdva':$row['pPost']; ?>
															</h4>
															<label> <i class="text-secondary">Játékengedélyek</i> </label>
															<h4 class="mb-4 mt-1">
																<?php
                                                            $isNull=false;
              if ($row['pL1']!="") {
                  echo $row['pL1'];
              } else {
                  $isNull=true;
              }
              if ($row['pL2']!="") {
                  echo ";\t ";
                  echo $row['pL2'];
              }
              if ($row['pL3']!="") {
                  echo ";\t ";
                  echo $row['pL3'];
              }
              if ($isNull) {
                  echo "nincs játékengedély";
              } ?>
															</h4>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-outline-secondary"
												data-bs-dismiss="modal">Bezár</button>
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
		</div>
	</div>
	<?php
  include_once 'footer.php';
?>