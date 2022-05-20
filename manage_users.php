<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'check_user.php';
  include_once 'auto_logout.php';
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
  echo '<div class="container">
        <h1 class="text-center">Felhasználók jogosultságainak kezelése</h1>
            <div class="row">';
  
    $sql="SELECT * FROM users WHERE UsersUid <> '$uname' ;";
    $res=mysqli_query($conn, $sql);
    $queryResults=mysqli_num_rows($res);
    if ($queryResults>0) {
        while ($row=mysqli_fetch_assoc($res)) {
            $actId=$row['rId']; ?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 col-xs-10 mx-auto ">
    <div class="card mt-5 ms-1 bg-dark text-center">
        <img class="card-img-top mx-auto mt-2" src="img/person-square.svg" alt="Profilkép" style="width: 6rem;">
        <div class="card-body">
            <h4 class="card-title"><?php echo $row['usersName']; ?>
            </h4>
            <p class="card-text">Felhasználónév: <strong> <?php echo $row['usersUid']; ?></strong>
            </p>
            <div class="mx-auto" style="width: 15rem;">
                <label class="form-label" for="">Jogosultság</label>
                <select name="roleId" id="" class="form-select">
                    <?php $sql2="SELECT * FROM users S INNER JOIN user_roles U ON S.rId=U.rId WHERE U.rId;";
            $result2=mysqli_query($conn, $sql2);
            $queryResults2=mysqli_num_rows($result2);
            $x=0;
            while ($row2=mysqli_fetch_assoc($result2)) {
                if ($actId==$row2['rId'] && $x==0) { //ne jelenjen meg x-szer ugyan az a fióktípus
                    echo '<option value="'.$row2['rId'].'">'.$row2['rDesc'].' (jelenlegi)</option>';
                    $x++;
                }
            }
            $sql3="SELECT * FROM user_roles WHERE rId <> '$actId';";
            $result3=mysqli_query($conn, $sql3);
            while ($row3=mysqli_fetch_assoc($result3)) {
                echo '<option value="'.$row3['rId'].'">'.$row3['rDesc'].'</option>';
            } ?>
                </select>
            </div>
            <p class="card-text  m-0 mt-3 p-0">Regisztáció dátuma: </p>
            <p class="card-text"> <strong><?php echo $row['regDate']; ?></strong>
            </p>

            <div class="d-flex flex-row-reverse me-3">

                <a title="Törlés" class="btn btn-outline-danger ms-1" data-bs-toggle="modal"
                    data-bs-target="#delete<?php echo $row['usersId']; ?>">
                    <?php include 'img/trash.svg' ?>
                </a>

                <!-- Modal -->
                <div class="modal"
                    id="delete<?php echo $row['usersId']; ?>"
                    data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="deleteLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-dark fs-5">
                            <div class="modal-header">
                                <h4 class="modal-title" id="deleteLabel">Felhasználó törlése</h4>
                                <button type="button" class="btn-close " data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                          echo 'Biztosan szeretné <strong>TÖRÖLNI</strong> a következő nevű felhasználót az adatbázisból: '.$row['usersName'].' ?'; ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                                <a href="user_modify.php?id=<?php echo $row['usersId']; ?>"
                                    class="btn btn-danger">Törlés </a>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="user_modify.php?id=<?php echo $row['usersId']; ?>"
                    title="Módosít" class="btn btn-outline-primary">
                    Módosít
                </a>
            </div>

        </div>
    </div>
</div>
<?php
        }
    }
?>
</div>
</div>

<?php
  include_once 'footer.php';
