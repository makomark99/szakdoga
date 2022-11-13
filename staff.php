<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location:Szakdoga/login.php');
  }
  
 
?>

<div class="col-md-12">
	<div class="d-flex justify-content-end">
		<div class="d-flex col-md-3">
			<input class="form-control me-2" type="text" name="search2" id="search2"
				placeholder="Munkatárs keresése név alapján">
		</div>

		<div class="">
			<a href="staff_add.php" title="Munkatárs hozzáadása" class="btn btn-outline-primary me-2">
				<?php include "img/plus-lg.svg"?>
			</a>
			</form>
		</div>
	</div>
	<div id="output2" class="table-responsive">

	</div>
</div>

<?php  if (isset($_GET["modifystaff"])) {
    if ($_GET["modifystaff"]=="stmtfailed") {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "staff.php", true);
    } elseif ($_GET["modifystaff"]=="none") {
        errorAlert("Az adatok sikeresen módosításra kerültek!", "staff.php", false);
    }
}
if (isset($_GET["deletestaff"])) {
    if ($_GET["deletestaff"]=="stmtfailed") {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "staff.php", true);
    } elseif ($_GET["deletestaff"]=="none") {
        errorAlert("Dolgozó adatai sikeresen törlésre kerülek!", "staff.php", false);
    }
}
include_once 'footer.php';
?>