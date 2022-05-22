<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'auto_logout.php';
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
?>
<div class="col-md-12 ">
  <div class="d-flex justify-content-end ">
    <div class=" d-flex col-md-4 col-sm-5">
      <input class="form-control me-2" type="text" name="search" id="search"
        placeholder="Játékos keresése név, vagy személy kód alapján">
    </div>
    <a href="detailed.php" title="Szűrő" class="btn btn-outline-primary me-2">
      <?php include "img/filter.svg"?>
    </a>
    <form class="m-0" action="livesearch.php" method="post">
      <button class="btn btn-outline-primary me-2 " title=" Távozók" type="submit" name="leavers">
        <?php include "img/leave.svg"?>
      </button>
    </form>

    <a href="p_add.php" title="Játékos hozzáadása" class="btn btn-outline-primary me-2">
      <?php include "img/plus-lg.svg"?>
    </a>
  </div>
</div>
<div id="output">

</div>

<?php
  include_once 'footer.php';
?>
<!--<script src="row_click.js"></script> -->