<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
  include_once 'includes/arrays.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
?>
<script defer src="calculate.js"></script>
<div class="col-md-12  justify-content-end">
	<div class="d-flex  row">
		<div class=" d-flex col-lg-5 col-md-2  justify-content-end">
			<div class="spinner-border d-none text-primary mt-1 p-2" id="spinner" role="status">
				<span class="visually-hidden">Keresési adatok betöltése...</span>
			</div>
		</div>
		<div class=" d-flex col-lg-7 col-md-10  justify-content-end">
			<input class="form-control ms-2 me-2" type="text" autocomplete="off" name="search" id="search"
				placeholder="Játékos keresése név, vagy személy kód alapján" autofocus>
			<!-- Button trigger modal -->
			<a title="Szűrő" data-bs-toggle="modal" data-bs-target="#detail" class="btn btn-outline-primary me-2">
				<?php include "img/filter.svg"?>
			</a>
			<!-- Modal -->
			<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered">
					<div class="modal-content text-dark">
						<form action="livesearch.php" method="post">
							<div class="modal-header">
								<h1 class="modal-title fs-3" id="">Részletes játékos kereső</h1>
								<button type="button" class="btn-close" data-bs-dismiss="modal"
									aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<div class="row g-2 d-flex">
									<div class="col-md-6 mb-3">
										<?php
    $sql5="SELECT DISTINCT pL1 as pl FROM players WHERE pIsMember=1 ORDER BY pl";
    $result5=mysqli_query($conn, $sql5);
    $qres5=mysqli_num_rows($result5);
    ?>
										<label class="form-label">Csapat kiválasztása
											(<?php echo $qres5-1; ?>
											csapat
											közül)</label>
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
										<label for="pSH" class="form-label">Ügyesebb kéz kiválasztása</label>
										<select class="form-select" name="pWeakHand" id="pWeakHand" disabled>
											<option value="">Nincs kiválasztva érték</option>
											<option value="0">Jobb</option>
											<option value="1">Bal</option>
										</select>
									</div>
									<div class="col-md-4 mb-3">
										<label for="pSH" class="form-label">Poszt kiválasztása (7 közül)</label>
										<select class="form-select" name="pPos" id="pPos" disabled>
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
			<form class="m-0" action="livesearch.php" method="post">
				<button class="btn btn-outline-primary me-2 " title=" Távozók" type="submit" name="leavers">
					<?php include "img/leave.svg"?>
				</button>
			</form>

			<!-- Button trigger modal -->
			<a title="Kinevelési költség számítása" id="calcModal" class="btn btn-outline-primary me-2"
				data-bs-toggle="modal" data-bs-target="#calculate">
				<?php include_once 'img/calculator.svg' ?>
			</a>
			<a title="Új játékosok nyilvántartásba vétele" href="p_new.php" id="newPlayers"
				class="btn btn-outline-primary me-2">
				<?php include_once 'img/person-plus.svg' ?>
			</a>
			<a href="p_add.php" title="Játékos hozzáadása" class="btn btn-outline-primary ">
				<?php include "img/plus-lg.svg"?>
			</a>
		</div>
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
						<input type="radio" class="btn-check " name="btnradio" id="nb1" autocomplete="off" checked="" />
						<label class="btn   btn-outline-primary" for="nb1">NB I</label>

						<input type="radio" class="btn-check " name="btnradio" id="nb1b" autocomplete="off" />
						<label class="btn   btn-outline-primary" for="nb1b">NB I/B</label>

						<input type="radio" class="btn-check " name="btnradio" id="otherTeam" autocomplete="off" />
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

						<input type="radio" class="btn-check" name="btnradio2" id="junior" autocomplete="off" />
						<label class="btn  btn-outline-primary" for="junior">Junior</label>
						<input type="radio" class="btn-check" name="btnradio2" id="felnott" autocomplete="off" />
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
						<input type="radio" class="btn-check" name="btnradio3" id="other" onclick="enable()" checked />
						<label class="btn  btn-outline-primary" for="other">Nem</label>

						<input type="radio" class="btn-check" name="btnradio3" id="ac" onclick="disable()"
							autocomplete="off" />
						<label class="btn  btn-outline-primary" for="ac">Igen</label>
					</div>
				</div>
				<hr class="m-2">
				<table class="table table-bordered border border-secondary border-1">
					<thead class="fs-6">
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

</div>

<?php
  include_once 'footer.php';
?>