<?php
  include_once 'header.php';
  include_once 'includes/dbh.inc.php';
  include_once 'navbar.php';
  include_once 'auto_logout.php';
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
    if (isset($_SESSION["useruid"])) {
        echo '<h4>Bejelentkezve <b><i>'.$_SESSION["useruid"].' </i></b> néven.</h4>';
    } else {
        echo '<p> <a id="loginl" href="login.php">Ön jelenleg nincs bejeletkezve! A bejelentkezéshez kattintson ide!</a> </p>';
    }
  ?>
<h1 class="text-center">Főoldal</h1>
<h3>Feladatok</h3>
<div class="d-flex align-middle">
  <p class="  col-md-auto me-3">Sportorvosi időpont foglalása</p>
  <div class="progress col-md-8 ">
    <div class=" align-middle progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
      style="width: 60%;">
      60%
    </div>
  </div>
</div>

<div class="row no-gutters mt-3">
  <div class="col-md-6 col-sm-12">
    <div class="row">


      <!-- Button trigger modal -->
      <button type="button" title="Feladat hozzáadása" class="btn btn-outline-primary col-auto me-5"
        data-bs-toggle="modal" data-bs-target="#addTask">
        <?php include_once 'img/plus-lg.svg' ?>
      </button>
      <h2 class="text-center col-auto ">Végrehajtandó feladatok</h2>
    </div>


    <!-- Modal -->
    <div class="modal  fade" id="addTask" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content text-dark fs-5">
          <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Végrehajtandó feladat hozzáadása</h3>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <label class="form-label" for="">Feladat leírása</label>
            <textarea class="form-control mb-2" placeholder="Feladat kifejtése..." name="task" id="" cols="10"
              rows="5"></textarea>

            <label class="form-label" size="2" for="">Felelős(ök) kiválasztása</label>
            <div class="row g-0 d-flex">

              <?php $x=0;
              while ($x<=1) { ?>
              <div class="col-md-6">
                <select class="form-select mb-2" name="ref" id="">
                  <option value=""><?php echo $x+1;?>. felelős
                    kiválasztása</option>
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
              <?php  $x++; } ?>

            </div>
            <label class="form-label " for="">Határidő megadása</label>
            <input name="deadline"
              value="<?php echo date("Y-m-d"); ?>"
              type="date" max="9999-11-11" class="form-control mb-2">
          </div>
          <div class="modal-footer ">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
            <button type="button" class="btn btn-primary">Rögzítés</button>
          </div>
        </div>
      </div>
    </div>



  </div>
  <div class="col-md-6 col-sm-12 bg-success">
    <h2 class="text-center">Befejezett feladatok</h2>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laboriosam, nulla laudantium doloribus labore ex ipsa
      id alias deserunt, quis soluta nobis? Ex dolorum consequatur nobis sequi earum doloremque perferendis quae.
      Lorem ipsum, dolor sit amet consectetur adipisicing elit. Est sint corporis accusamus illum! Nisi quibusdam
      exercitationem mollitia reprehenderit asperiores, molestias dicta! Veniam nulla id officiis rem facere. Aperiam
      voluptatibus, repellendus dicta doloribus similique at fugiat dolor impedit. Ullam, temporibus, deserunt non in ab
      sunt unde harum facilis explicabo natus omnis, numquam voluptatibus! Nobis voluptatum assumenda harum atque hic
      earum facilis voluptas minima nostrum cumque, exercitationem velit corporis in at vero ea! Asperiores minima alias
      impedit vel labore itaque id! Similique harum accusamus nobis dolor libero! Nostrum fuga molestias esse cupiditate
      veritatis rem, quos sit eos. Modi vel dolore nostrum quis.</p>
  </div>


  <?php
  include_once 'footer.php';
