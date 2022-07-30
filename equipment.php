<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
?>

<div class="container">
	<h1 class="text-center mb-5">Felszerelések</h1>
	<div class="mx-auto col-md-4">
		<?php
            $sql="SELECT * FROM Players WHERE pIsMember=1 ORDER BY pName;";
            $result=mysqli_query($conn, $sql);
            $qres=mysqli_num_rows($result); ?>
		<label for="equipment" class="form-label ">Játékos kiválasztása</label>
		<input class="form-control" list="datalistOptions" id="equipment" placeholder="Játékos neve...">
		<datalist id="datalistOptions">
			<?php
      $code="";
      if ($qres>0) {
          while ($row=mysqli_fetch_assoc($result)) {
              echo '<option value="'.$row['pName'].'  -  '.$row['pCode'].'">'.$row['pBDate'].'</option>';
              $code=$row['pCode'];
          }
      }
      ?>
		</datalist>

		<?php
   
    $sql2="SELECT * FROM Players WHERE pIsMember=1 AND pCode=$code;";
            $result2=mysqli_query($conn, $sql2);
            $qres2=mysqli_num_rows($result);
            if ($qres2>0) {
                while ($row2=mysqli_fetch_assoc($result)) {
                    echo ''.$row['pName'].'';
                }
            }
      ?>
	</div>
</div>
<label for="exampleColorInput" class="form-label">Color picker</label>
<input type="color" class="form-control form-control-color" id="exampleColorInput" value="#563d7c"
	title="Choose your color">


<?php
  include_once 'footer.php';
