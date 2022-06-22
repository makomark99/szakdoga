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
      <a href="p_add.php" title="Munkatárs hozzáadása" class="btn btn-outline-primary me-2">
        <?php include "img/plus-lg.svg"?>
      </a>
      </form>
    </div>
  </div>
  <div id="output2" class="table-responsive">

  </div>
</div>

<?php

  include_once 'footer.php';
