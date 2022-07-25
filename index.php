<?php
  include_once 'header.php';
  include_once 'includes/dbh.inc.php';
  include_once 'navbar.php';
  include_once 'auto_logout.php';
  include_once 'includes/arrays.php';
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
    if (isset($_SESSION["useruid"])) {
        echo '<h6>Bejelentkezve <b><i>'.$_SESSION["useruid"].' </i></b> néven.</h6>';
    } else {
        echo '<p> <a id="loginl" href="login.php">Ön jelenleg nincs bejeletkezve! A bejelentkezéshez kattintson ide!</a> </p>';
    }
  ?>

<h1 class='text-center'>Főoldal</h1>
<nav class=" mt-5">
	<div class="row">
		<div class="col-auto">
			<h5>Google táblázatok:</h5>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1BfDUlMre4odPiAt6Rib_FAmUDGvrgp_7VYH5nfUz46g/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn-sm">Utánpótlás csapatok</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1ZSuDeR-15Ss0_b6E15m0aQwuxYljtV6gOY-eT5CA5cc/edit#gid=225423210"
				target="_blank" class="btn btn-outline-primary btn-sm">Új játékosok</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1AHm7ABE91E2oVIO14aD3nYCFAzme73MOl9WPWTPVlD4/edit#gid=1778699873"
				target="_blank" class="btn btn-outline-primary btn-sm">Tábor</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1VyKHQ4G69IYiFkQMJUDw_2lJOVoDy9Q-XH0GkutysZA/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn-sm">Felmérések</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1LuH9r4tKx77pAaxClUiv08suHrAdQiWE76L1plFjRRA/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn-sm">Automatikus e-mailek</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1tboVA-tKNujGKgIw9k2f-6vDxhtPv3fi8wAn5kW1w64/edit#gid=1169301745"
				target="_blank" class="btn btn-outline-primary btn-sm">MKC ALL</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1B_f0Loj5d2LJGq_6q2ErJayoFXD28MBX/edit#gid=2087547045"
				target="_blank" class="btn btn-outline-primary btn-sm">Tagdíjak</a>
		</div>
		<div class="col-auto"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1XUQonFIpyV_0sVrMOEQILWZm-7RVmPwt/edit#gid=774448911"
				target="_blank" class="btn btn-outline-primary btn-sm">Mezszámok</a>
		</div>
	</div>
	<div>
		<h4 class="my-3">Email rendelések</h4>
		<a type="button" href="food.php" class="btn btn-outline-primary btn-sm">Hidegcsomag</a>
	</div>
</nav>
<h3 class="mt-3">Feladatok</h3>
<div class="d-flex align-middle">
	<p class="  col-md-auto me-3">Sportorvosi időpont foglalása</p>
	<div class="progress col-md-8 ">
		<div class=" align-middle progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0"
			aria-valuemax="100" style="width: 60%;">
			60%
		</div>
	</div>
</div>

<div class="row g-2 mt-3 ">
	<div class="col-md-12 col-lg-12 rounded-pill px-3 pt-1 pb-5 border border-5 border-warning mb-2">
		<div class="row m-3">
			<div class="col-auto mx-auto ">
				<!-- Button trigger modal -->
				<button type="button" title="Feladat hozzáadása" class="btn btn-outline-primary me-1 my-2"
					data-bs-toggle="modal" data-bs-target="#addTask">
					<?php include_once 'img/plus-lg.svg' ?>
				</button>
				<h2 class="d-inline my-5">Végrehajtandó feladatok</h2>
			</div>
		</div>
		<?php
        $sql = "SELECT * FROM tasks T JOIN staff S ON T.taskRef=S.sId WHERE T.taskIsReady ='0' ORDER BY T.taskDeadline; ";
        $result=mysqli_query($conn, $sql);
        $queryResults=mysqli_num_rows($result);
        $th=1;
        ?>
		<div class="table-responsive m-3">
			<table class="table table-dark  rounded table-hover ">
				<thead class="thead-light ">
					<tr>
						<th>Műveletek</th>
						<th>#</th>
						<th>Felelős</th>
						<th>Kategória</th>
						<th>Feladat leírása</th>
						<th>Határidő</th>
						<th>Létrehozó</th>
						<th>Létrehozva</th>
					</tr>
				</thead>
				<tbody>
					<?php
                    while ($row=mysqli_fetch_assoc($result)) {
                        ?>
					<tr class="align-conent-center">
						<td class="align-middle ">
							<a href="task_done.php?id=<?php echo $tId; ?>"
								title="Elkészült" class="btn btn-outline-success 
                      <?php if (!$sadmin) {
                            echo 'disabled';
                        } ?>">
								<?php include 'img/check-lg.svg' ?>
							</a>
							<a title="Törlés" class="btn btn-outline-danger <?php if (!$sadmin) {
                            echo 'disabled';
                        } ?>" data-bs-toggle="modal"
								data-bs-target="#delete<?php echo $id; ?>">
								<!--egyedi id kell, mert minding az elsőt találta meg-->
								<?php include 'img/trash.svg' ?>
							</a>
						</td>
						<td class="align-middle"><?php echo $th++; ?>
						</td>
						<td class="align-middle"><?php echo $row['sName']; ?>
						</td>
						<td class="align-middle"><?php echo $row['taskCategory']; ?>
						</td>
						<td class="align-middle"><?php echo $row['taskDesc']; ?>
						</td>
						<td class="align-middle bold"><b><?php echo $row['taskDeadline']; ?></b>
						</td>
						<td class="align-middle"><?php echo $row['taskCreator']; ?>
						</td>
						<td class="align-middle"><?php echo $row['taskDate']; ?>
						</td>
					</tr>
					<?php
                    }?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- Modal -->
	<form action="includes/addtask.inc.php" method="post">
		<div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-centered">
				<div class="modal-content text-dark fs-5">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel">Végrehajtandó feladat hozzáadása</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

						<label class="form-label" for="">Feladat leírása</label>
						<textarea class="form-control mb-2" placeholder="Feladat kifejtése..." name="task" id=""
							cols="10" rows="5"></textarea>
						<div class="row g-1 d-flex">
							<div class="col-md-6">
								<label class="form-label" size="2" for="">Felelős kiválasztása</label>
								<select class="form-select mb-2" name="ref" id="">
									<option value="">Felelős kiválasztása</option>
									<?php   $sql="SELECT * FROM staff ;";
                    $res=mysqli_query($conn, $sql);
                    $queryResults=mysqli_num_rows($res);
                    if ($queryResults>0) {
                        while ($row=mysqli_fetch_assoc($res)) {
                            ?>
									<option
										value="<?php echo $row['sId']; ?>">
										<?php echo $row['sName']; ?>
									</option> <?php
                        }
                    }?>
								</select>

							</div>
							<div class="col-md-6">
								<label class="form-label " for="">Határidő megadása</label>
								<input name="deadline"
									value="<?php echo date("Y-m-d"); ?>"
									type="date" max="9999-11-11" class="form-control mb-2">
							</div>

						</div>
						<label class="form-label " for="category">Kategória kiválasztása</label>
						<input class="form-control" name="category" list="datalistOptions" id="category"
							placeholder="Kategória kiválasztása...">
						<datalist id="datalistOptions">
							<?php
             $x=0;
          while ($x!=count($categories)) {
              echo '<option value="'.$categories[$x].'"</option>';
              $x++;
          }
      ?>
						</datalist>
					</div>
					<div class="modal-footer ">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
						<button type="submit" name="submit" class="btn btn-primary">Rögzítés</button>
						<?php
            //   if (isset($_GET["error"])) {
            //       if ($_GET["error"]== "stmtfailed") {
            //           echo "<p class='red'>Valami nem stimmel, próbálkozzon újra!</p>";
            //       }
            //       if ($_GET["error"]== "none") {
            //           echo "<p class='green '>Az új feladat adatai sikeresen rögzítésre kerültek!</p>";
            //       }
            //   }
            ?>
					</div>
				</div>
	</form>
</div>

</div>
<div class="col-md-12 col-sm-12  rounded-pill px-3 pt-1 pb-5 border border-success border-5 mb-2">
	<h2 class="text-center my-2">Befejezett feladatok</h2>
	<div class="table-responsive">
		<table class="table table-dark table-hover ">
			<thead class="thead-light ">
				<tr>
					<th>#</th>
					<th>Elkészült</th>
					<th>Felelős</th>
					<th>Kategória</th>
					<th>Feladat leírása</th>
					<th>Határidő</th>
					<th>Létrehozó</th>
					<th>Létrehozva</th>
				</tr>
			</thead>
			<tbody>
				<tr class="align-conent-center">
					<td class="align-middle">1.</td>
					<td class="align-middle">2022.09.02</td>
					<td class="align-middle">Makó Márk</td>
					<td class="align-middle">Időpontegyeztetés</td>
					<td class="align-middle">Le kell egyeztetni az ifi,seri időpontokat</td>
					<td class="align-middle bold"><b>2022.06.09</b> </td>
					<td class="align-middle">Makó Márk</td>
					<td class="align-middle">2022.08.15</td>

				</tr>

			</tbody>
		</table>
	</div>
</div>


<?php
  include_once 'footer.php';
