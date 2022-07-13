<?php
  include_once 'header.php';
  include_once 'navbar.php';
?>

<div class="container" id="signup">
  <div class="row">
    <div class="panel col-lg-4 col-md-6 col-sm-8 mx-auto">
      <div class="panel-heading text-center ">
        <h1> Bejelentkezés</h1>
        <img class="mx-auto mt-4" id="logo2" src="img\mkc_logo.png" alt="logo">
      </div>
      <div class="panel-body">
        <form action="includes/login.inc.php" method="post">
          <div class="form-group mt-5">
            <label for="Uid">Felhasználónév*</label>
            <input id="Uid" class="form-control mb-3 fs-5" type="text" pattern="^[a-zA-Z0-9]*$" 
            title="A felhasználónév csak betűket és számokat tartalmazhat!" name="uid" placeholder="Felhasználónév/E-mail"
              required>
          </div>
          <div class="form-group ">
            <label for="Pass">Jelszó*</label>
            <input id="Pass" class="form-control mb-3 fs-5" type="password" name="pwd" placeholder="Jelszó" required>
          </div>
          <div class="panel-footer m-auto row ">
            <button type="submit " name="submit" class="btn btn-outline-primary mb-3 col-auto">Bejelentkezés</button>
            <div class="ms-auto mt-2 col-auto"><small>&copy; Mosonmagyaróvári KC</small></div>
          </div>
          <div class="text-center">
            <?php
                if (isset($_GET["error"])) { //olyan adatot ellenőriz, amit látunk az URL-ben
                    if ($_GET["error"]== "wronglogin") {
                        echo "<p class='red'>Hibás felhasználónév, vagy jelszó!</p>";
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
