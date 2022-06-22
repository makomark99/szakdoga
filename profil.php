<?php
  include_once 'header.php';
  include_once 'navbar.php';
  
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }

?>
<div class="container" id="signup">
  <div class="row">
    <div class="panel col-md-4 col-xs-10 col-sm-9 mx-auto">
      <div class="panel-heading text-center ">
        <h1> Jelszó módosítása</h1>
        <img class="mx-auto mt-4" id="logo2" src="img\mkc_logo.png" alt="logo">
      </div>
      <div class="panel-body">
        <form action="includes/login.inc.php" method="post">
          <div class="form-group mt-5">
            <label for="pwd">Jelenlegi jelszó*</label>
            <input id="pwd" class="form-control mb-3" type="password" name="pwd" placeholder="Jelenlegi jelszó"
              required>
          </div>
          <div class="form-group ">
            <label for="npwd">Új jelszó*</label>
            <input id="npwd" class="form-control mb-3" type="password" name="npwd" placeholder="Új jelszó" required>
          </div>
          <div class="form-group ">
            <label for="npwdr">Új jelszó mégegyszer*</label>
            <input id="npwdr" class="form-control mb-3" type="password" name="npwdr" placeholder="Új jelszó mégegyszer"
              required>
          </div>
          <div class="panel-footer m-auto d-flex d-block-sm">
            <button type="submit" name="submit" class="btn btn-outline-primary mb-3">Változtat</button>
            <div class="ms-auto mt-2"><small>&copy; Mosonmagyaróvári KC</small></div>
          </div>
          <div class="text-center">
            <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"]== "emptyinput") {
                        echo "<p class='red'> Töltse ki a fenti mezőket! </p>";
                    }
                    if ($_GET["error"]== "wronglogin") {
                        echo "<p class='red'>A megadott felhasználónév, vagy jelszó nem megfelelő!</p>";
                    }
                }
              ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php

  include_once 'footer.php';
