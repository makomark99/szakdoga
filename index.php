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
        echo '<h6">Bejelentkezve <b><i>'.$_SESSION["useruid"].' </i></b> néven.</h6>';
        $tasksToDo=0;
    } else {
        echo '<p> <a id="loginl" href="login.php">Ön jelenleg nincs bejeletkezve! A bejelentkezéshez kattintson ide!</a> </p>';
    }
        //add task
        if (isset($_POST["addTask"])) {
            $task=mysqli_real_escape_string($conn, $_POST['task']);
            $ref=$_POST['ref'];
            $deadline=$_POST['deadline'];
            $category=$_POST['category'];
            $username=$_SESSION["useruid"];
            $date=date("Y-m-d");
            $ready=0;
            $sql = "INSERT INTO tasks (taskDesc,taskRef,taskDeadline,taskCategory,taskCreator,taskDate,taskIsReady) 
            VALUES(?, ?, ?, ?, ?, ?, ?);";
            $stmt=mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo '<script> location.replace("index.php?addToken=stmtfailed"); </script>';
                exit();
            }
            mysqli_stmt_bind_param(
                $stmt,
                "sssssss",
                $task,
                $ref,
                $deadline,
                $category,
                $username,
                $date,
                $ready
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            echo '<script> location.replace("index.php?error=none"); </script>';
            exit();
        }
        //addtaskend

        // task mark as done
    if (isset($_POST["taskIsDoneBtn"])) {
        $id=$_POST["taskIsDone"];
        $date=date("Y-m-d");
        $set="UPDATE tasks SET taskIsReady=1, taskDoneDate='$date' WHERE taskId=?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $set)) {
            echo '<script> location.replace("index.php?taskisdone=stmtfailed"); </script>';
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        echo '<script> location.replace("index.php?taskisdone=none"); </script>';
    }
    // task mark as done end
if (isset($_POST["deleteTaskBtn"])) {
    $id=$_POST["deleteTask"];
    $delete="DELETE FROM tasks WHERE taskId=?;";
    $stmt2=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $delete)) {
        echo '<script> location.replace("index.php?deletetask=stmtfailed"); </script>';
        exit();
    }
    mysqli_stmt_bind_param($stmt2, 's', $id);
    mysqli_stmt_execute($stmt2);
    echo '<script> location.replace("index.php?deletetask=none"); </script>';
}


  ?>

<h1 class='text-center '>Főoldal</h1>

<nav class=" mt-5 ">
	<div class="text-center m-3">
		<h4>Google táblázatok</h4>
	</div>
	<div class="boxes row mt-1  ">

		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1BfDUlMre4odPiAt6Rib_FAmUDGvrgp_7VYH5nfUz46g/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn">Utánpótlás
				csapatok</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1ZSuDeR-15Ss0_b6E15m0aQwuxYljtV6gOY-eT5CA5cc/edit#gid=225423210"
				target="_blank" class="btn btn-outline-primary btn">Új játékosok</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1AHm7ABE91E2oVIO14aD3nYCFAzme73MOl9WPWTPVlD4/edit#gid=1778699873"
				target="_blank" class="btn btn-outline-primary btn">Tábor</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1VyKHQ4G69IYiFkQMJUDw_2lJOVoDy9Q-XH0GkutysZA/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn">Felmérések</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1LuH9r4tKx77pAaxClUiv08suHrAdQiWE76L1plFjRRA/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn">Automatikus e-mailek</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1tboVA-tKNujGKgIw9k2f-6vDxhtPv3fi8wAn5kW1w64/edit#gid=1169301745"
				target="_blank" class="btn btn-outline-primary btn">MKC ALL</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1B_f0Loj5d2LJGq_6q2ErJayoFXD28MBX/edit#gid=2087547045"
				target="_blank" class="btn btn-outline-primary btn">Tagdíjak</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1XUQonFIpyV_0sVrMOEQILWZm-7RVmPwt/edit#gid=774448911"
				target="_blank" class="btn btn-outline-primary btn">Mezszámok</a>
		</div>
		<div class="col-auto mb-2"> <a type="button"
				href="https://docs.google.com/spreadsheets/d/1S5bHnh4hf0NBIvTZgptxVbeBRFxEfth4uMbPFpnI7NE/edit#gid=0"
				target="_blank" class="btn btn-outline-primary btn">Leltár</a>
		</div>
	</div>
	<div class="row mt-5 ">
		<div class="col-auto">
			<h4>Email rendelések:</h4>
		</div>
		<div class="col-auto ">
			<a type="button" href="food.php" class="btn btn-outline-primary ">Hidegcsomag</a>
		</div>
	</div>
</nav>


<div class="row g-2 mt-3">
	<div class="col-md-12 col-lg-12 px-3 pt-1 pb-3   ">
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

        if ($tasksToDo>=0 && !$sadmin) {
            $userID=$_SESSION['userid'];
            $sql = "SELECT * FROM tasks T JOIN users U ON T.taskRef=U.usersId WHERE T.taskIsReady ='0' AND T.taskRef=$userID ORDER BY T.taskDeadline; ";
        } elseif ($sadmin) {
            $sql = "SELECT * FROM tasks T JOIN users U ON T.taskRef=U.usersId WHERE T.taskIsReady ='0' ORDER BY T.taskDeadline; ";
        }
        $result=mysqli_query($conn, $sql);
        $queryResults=mysqli_num_rows($result);
        $th=1;
        if ($queryResults<1 || $tasksToDo!=0) {
            echo "<div class='mx-auto p-0 my-2 w-50 border rounded-pill border-2 border-warning text-center '> <h4 class='my-2'> Jelenleg nincs végrehajtandó feladat</h4> </div>";
        } else {
            ?>

		<div class="table-responsive max-h ">
			<table class="table table-dark table-hover border border-5 border-warning ">
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
                        if ($_SESSION["userid"]==$row['usersId']) {
                            $tasksToDo++;
                        } ?>

					<tr class="align-conent-center">
						<td class="align-middle ">
							<form action="index.php" method="post">
								<button type="submit" name="taskIsDoneBtn" title="Elkészült"
									class="btn btn-outline-success 
                      <?php echo (($tasksToDo==0) && (!$sadmin))? 'd-none':''; ?>">
									<?php include 'img/check-lg.svg' ?>
								</button>
								<input type="hidden" name="taskIsDone"
									value="<?php echo $row['taskId']; ?>">
								<button type="submit" name="deleteTaskBtn" title="Törlés"
									class="btn btn-outline-danger <?php echo (!$sadmin)? 'd-none':''; ?>">
									<?php include 'img/trash.svg' ?>
								</button>
								<input type="hidden" name="deleteTask"
									value="<?php echo $row['taskId']; ?>">
							</form>
						</td>
						<td class="align-middle"><?php echo $th++; ?>
						</td>
						<td class="align-middle">
							<?php echo $row['usersName']; ?>
						</td>
						<td class="align-middle">
							<?php echo $row['taskCategory']; ?>
						</td>
						<td class="align-middle">
							<?php echo $row['taskDesc']; ?>
						</td>
						<td class="align-middle bold">
							<b><?php echo $row['taskDeadline']; ?></b>
						</td>
						<td class="align-middle">
							<?php echo $row['taskCreator']; ?>
						</td>
						<td class="align-middle">
							<?php echo $row['taskDate']; ?>
						</td>
					</tr>
					<?php
                    } ?>
				</tbody>
			</table>
		</div>
	</div>
	<?php
        } ?>
	<!-- Modal -->
	<form action="index.php" method="post">
		<div class="modal fade" id="addTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content text-dark fs-5">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLabel">Végrehajtandó feladat hozzáadása</h3>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

						<label class="form-label" for="">Feladat leírása</label>
						<textarea class="form-control mb-2" placeholder="Feladat kifejtése..." required name="task"
							cols="10" rows="5"></textarea>
						<div class="row g-1 d-flex">
							<div class="col-md-6">
								<label class="form-label" size="2" for="">Felelős kiválasztása</label>
								<select class="form-select mb-2" name="ref" required>
									<option value="">Felelős kiválasztása</option>
									<?php   $sql="SELECT * FROM users ;";
                    $res=mysqli_query($conn, $sql);
                    $queryResults=mysqli_num_rows($res);
                    if ($queryResults>0) {
                        while ($row=mysqli_fetch_assoc($res)) {
                            ?>
									<option
										value="<?php echo $row['usersId']; ?>">
										<?php echo $row['usersName']; ?>
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
						<input class="form-control" name="category" list="datalistOptions" required id="category"
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
						<button type="submit" name="addTask" class="btn btn-primary">Rögzítés</button>
					</div>
				</div>
	</form>
</div>

</div>
<div class="col-md-12 col-sm-12  px-3 pt-1 pb-5  mb-2">
	<div class="row m-3">
		<div class="col-auto mx-auto ">
			<!-- Button trigger modal -->
			<button type="button" title="Összes befejezett feladat kilistázása"
				class="btn btn-outline-primary me-1 my-2" data-bs-toggle="modal" data-bs-target="#showTasks">
				<?php include_once "img/filter.svg" ?>
			</button>
			<h2 class="d-inline my-5">Legutóbb befejezett feladatok</h2>
		</div>
	</div>

	<?php
        $sql = "SELECT * FROM tasks T JOIN users U ON T.taskRef=U.usersId WHERE T.taskIsReady ='1' ORDER BY T.taskDoneDate DESC LIMIT 5;";
        $result=mysqli_query($conn, $sql);
        $queryResults=mysqli_num_rows($result);
        $th=1;
        ?>
	<div class="table-responsive">
		<table class="table table-dark table-hover border border-success border-5">
			<thead class="thead-light ">
				<tr>
					<th>#</th>
					<th>Felelős</th>
					<th>Kategória</th>
					<th>Feladat leírása</th>
					<th>Határidő</th>
					<th>Elkészült</th>
					<th>Létrehozó</th>
					<th>Időtartam</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    while ($row=mysqli_fetch_assoc($result)) {
                        ?>
				<tr class="align-conent-center">
					<td class="align-middle"><?php echo $th++; ?>
					</td>

					<td class="align-middle">
						<?php echo $row['usersName']; ?>
					</td>
					<td class="align-middle">
						<?php echo $row['taskCategory']; ?>
					</td>
					<td class="align-middle ">
						<?php echo $row['taskDesc']; ?>
					</td>
					<td class="align-middle bold">
						<?php echo $row['taskDeadline']; ?>
					</td>
					<td class="align-middle">
						<b><?php echo $row['taskDoneDate']; ?></b>
					</td>
					<td class="align-middle">
						<?php echo $row['taskCreator']; ?>
					</td>
					<?php $elapsedTime=strtotime($row['taskDoneDate'])-strtotime($row['taskDate']); ?>
					<td class="align-middle">
						<?php echo floor($elapsedTime/(60*60*24))." nap"; ?>
					</td>
				</tr>
				<?php
                    }?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->

<div class="modal fade" id="showTasks" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-fullscreen h-100 modal-dialog-centered">
		<div class="modal-content bg-dark text-white fs-5">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel">Befejezett feladatok</h3>
				<button type="button" class="btn-close  bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php
        $sql = "SELECT * FROM tasks T JOIN users U ON T.taskRef=U.usersId WHERE T.taskIsReady ='1' ORDER BY T.taskDoneDate DESC;";
        $result=mysqli_query($conn, $sql);
        $queryResults=mysqli_num_rows($result);
        $th=1;
        ?>
				<div class="table-responsive">
					<table class="table table-dark table-hover table-striped border border-success border-5">
						<thead class="thead-light ">
							<tr>
								<th>#</th>

								<th>Felelős</th>
								<th>Kategória</th>
								<th>Feladat leírása</th>
								<th>Határidő</th>
								<th>Elkészült</th>
								<th>Időtartam</th>
							</tr>
						</thead>
						<tbody>
							<?php
                    while ($row=mysqli_fetch_assoc($result)) {
                        ?>
							<tr class="align-conent-center">
								<td class="align-middle">
									<?php echo $th++; ?>
								</td>

								<td class="align-middle">
									<?php echo $row['usersName']; ?>
								</td>
								<td class="align-middle">
									<?php echo $row['taskCategory']; ?>
								</td>
								<td class="align-middle">
									<?php echo $row['taskDesc']; ?>
								</td>
								<td class="align-middle bold">
									<?php echo $row['taskDeadline']; ?>
								</td>
								<td class="align-middle">
									<b><?php echo $row['taskDoneDate']; ?></b>
								</td>
								<?php $elapsedTime=strtotime($row['taskDoneDate'])-strtotime($row['taskDate']); ?>
								<td class="align-middle">
									<?php echo floor($elapsedTime/(60*60*24))." nap"; ?>
								</td>
							</tr>
							<?php
                    }?>
						</tbody>
					</table>
				</div>

			</div>
			<div class="modal-footer ">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
			</div>
		</div>
	</div>
</div>

<?php
  include_once 'footer.php';
  if ($tasksToDo>=1) { ?>
<script>
	Swal.fire({
		position: "center",
		type: "warning",
		title: "<?php echo $tasksToDo?> végrehajtandó feladat vár rád!",
		showConfirmButton: false,
		icon: "warning",
		background: "#343a40",
		color: "#fff",
		timer: 2500
	})
</script>

<?php
}
if (isset($_GET["error"])) {
    if ($_GET["error"]=="stmtfailed") {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "index.php", true);
    } elseif ($_GET["error"]=="none") {
        errorAlert("A végrehajtandó feladat sikeresen rögzítve!", "index.php", false);
    }
}
  if (isset($_GET["taskisdone"])) {
      if ($_GET["taskisdone"]=="stmtfailed") {
          errorAlert("Valami nem stimmel, próbálkozz újra!", "index.php", true);
      } elseif ($_GET["taskisdone"]=="none") {
          errorAlert("A végrehajtandó feladat elkészültként rögzítve!", "index.php", false);
      }
  }
if (isset($_GET["deletetask"])) {
    if ($_GET["deletetask"]=="stmtfailed") {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "index.php", true);
    } elseif ($_GET["deletetask"]=="none") {
        errorAlert("A végrehajtandó feladat sikeresen törölve!", "index.php", false);
    }
}
?>