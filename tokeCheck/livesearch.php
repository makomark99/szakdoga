<?php
  include_once 'includes/dbh.inc.php';
  
  $search=mysqli_real_escape_string($conn, $_POST['name']);
  $sql = "SELECT * FROM players WHERE isMember ='1' AND pName LIKE '%$search%' OR pCode LIKE '%$search%'";
  $result=mysqli_query($conn, $sql);
  $queryResults=mysqli_num_rows($result);
  $th=1;
    if ($queryResults>0) {
        echo "<h3 class='mt-2'>A keresésnek $queryResults találata van!</h3>"
    ?>
<div class="container mt-4">
	<h1 class="text-center m-4">Játékosok adatai</h1>

	<table class="table table-dark table-hover">
		<thead class="thead-light">
			<tr>
				<th>#</th>
				<th>Név</th>
				<th>Személy kód</th>
				<th>Születési dátum</th>
				<th>Kor</th>
				<th>Játékengedélyek</th>
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
				<td class="align-middle">
					<?php echo $row['pL1'];
        if ($row['pL2']!="") {
            echo ";\t";
            echo $row['pL2'];
        }
        if ($row['pL3']!="") {
            echo ";\t";
            echo $row['pL3'];
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
                      echo 'Érvényes '.$valid.' napig</td>';
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
				<td class="align-middle btns">
					<a href="p_modify.php?id=<?php echo $id; ?>"
						title="Szerkesztés" class="btn btn-outline-warning">
						<?php include 'img/pencil.svg' ?>
					</a>
					<a href="p_delete.php?id=<?php echo $id; ?>"
						title="Törlés" class="btn btn-outline-danger">
						<?php include 'img/trash.svg' ?>
					</a>
				</td>
			</tr>
			<?php
    }
    } else {
        echo "<h3 class='mt-2'>Nem található a megadott paramétereknek megfelelő személy</h3>";
    }
    ?>
		</tbody>
	</table>
</div>
<script src="row_click.js">
</script>