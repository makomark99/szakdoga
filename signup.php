<?php
  include_once 'header.php';
  include_once 'navbar.php';
?>
<div class="container" id="signup">
  <div class="row ">
    <div class="panel panel-danger col-md-4 col-xs-10 col-sm-9 mx-auto">
      <div class="panel-heading text-center">
        <h1>Regisztrációs űrlap</h1>
      </div>
      <div class="panel-body">
        <form action="includes/signup.inc.php" method="post">
          <div class="form-group">
            <label class="mt-5" for="Wname">Teljes név*</label>
            <input id="Wname" class="form-control mb-3" type="text" name="name" placeholder="Vezetéknév Keresztnév "
              required>
          </div>
          <div class="form-group">
            <label for="Email">E-mail cím*</label>
            <input id="Email" class="form-control mb-3" type="email" name="email" placeholder="pelda@pelda.com"
              required>
          </div>
          <div class="form-group">
            <label for="Uid">Felhasználónév*</label>
            <input id="Uid" class="form-control mb-3" type="text" name="uid" placeholder="felhasznalonev" required>
          </div>
          <div class="form-group">
            <label for="Pass">Jelszó*</label>
            <input id="Pass" class="form-control mb-3" type="password" name="pwd" placeholder="Jelszó" required>
          </div>
          <div class="form-group">
            <label for="PassR">Jelszó ismét*</label>
            <input id="PassR" class="form-control mb-3" type="password" name="pwdrepeat" placeholder="Jelszó ismét"
              required>
          </div>
          <div class="form-group">
            <label for="Token">Regisztrációs token*</label>
            <input id="Token" class="form-control mb-3" type="password" name="token" placeholder="Regisztrációs token"
              required>
          </div>
          <div class="panel-footer m-auto row  ">
            <button type="submit" name="submit" class="btn btn-outline-primary  mb-2 col-auto">Regisztráció</button>
            <div class=" ms-auto mt-2 col-auto"><small>&copy; Mosonmagyaróvári KC</small></div>

          </div>
          <div class="text-center">
            <?php
                if (isset($_GET["error"])) { //olyan adatot ellenőriz, amit látunk az URL-ben
                    if ($_GET["error"]== "invaliduid") {
                        echo "<p class='red'> Válassz más felhasználónevet!</p>";
                    }
                    if ($_GET["error"]== "passworderror") {
                        echo "<p class='red'> A két jelszó nem azonos!</p>";
                    }
                    if ($_GET["error"]== "usernametaken") {
                        echo "<p class='red'>A megadot felhasználónév már foglalt!</p>";
                    }
                    if ($_GET["error"]== "stmtfailed") {
                        echo "<p class='red'>Valami nem stimmel, próbálkozzon újra!</p>";
                    }
                    if ($_GET["error"]== "none") {
                        echo "<p class='green'>Sikeres regisztráció!</p>";
                    }
                    if ($_GET["error"]=="wrongtoken") {
                        echo "<p class='red'>A megadott token helytelen, vagy már nem érvényes!</p>";
                    }
                    if ($_GET["error"]=="weakpassword") {
                        echo "<p class='red'>A jelszónak tartalmaznia kell kisbetűt, nagybetűt és számot. A jelszó hossza 8-30 karakter!</p>";
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
