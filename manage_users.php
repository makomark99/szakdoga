<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'check_user.php';
  include_once 'auto_logout.php';
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
      header('location: ../Szakdoga/login.php');
  }
  if ($sadmin) {
      if (isset($_POST["deleteUser"])) {
          $userId=($_POST['userId']);
          $date=date("Y-m-d");
          $actualRole=$_POST['roleId'];
          $set="UPDATE users SET uIsActive=0, uDeleteDate='$date' WHERE usersId=?;";
          $stmt=mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $set)) {
              echo '<script> location.replace("manage_users.php?delete_error=stmtfailed"); </script>';
              exit();
          }
          mysqli_stmt_bind_param($stmt, 's', $userId);
          mysqli_stmt_execute($stmt);
          echo '<script> location.replace("manage_users.php?delete_error=none"); </script>';
      }
      if (isset($_POST["modifyUserRole"])) {
          $userId=($_POST['userId']);
          $newRole=$_POST['roleId'];
          $date=date("Y-m-d");
          $set="UPDATE users SET rId=?, uLastModifiedAt='$date' WHERE usersId=?;";
          $stmt=mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $set)||$newRole=="") {
              echo '<script> location.replace("manage_users.php?modify_error=stmtfailed"); </script>';
              exit();
          }
          mysqli_stmt_bind_param($stmt, 'ss', $newRole, $userId);
          mysqli_stmt_execute($stmt);
          echo '<script> location.replace("manage_users.php?modify_error=none"); </script>';
      }

      echo '<div class="container">
        <h1 class="text-center">Felhasználók jogosultságainak kezelése</h1>
            <div class="row">';
  

      $sql="SELECT * FROM users WHERE UsersUid <> '$uname' AND uIsActive=1 ;";
      $res=mysqli_query($conn, $sql);
      $queryResults=mysqli_num_rows($res);
      if ($queryResults>0) {
          while ($row=mysqli_fetch_assoc($res)) {
              $actId=$row['rId']; ?>

<div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 col-xs-10 mx-auto ">
    <div class="card mt-5 ms-1 bg-dark text-center">
        <form action="manage_users.php" method="post">
            <img class="card-img-top mx-auto mt-2" src="img/person-square.svg" alt="Profilkép" style="width: 6rem;">
            <div class="card-body">
                <h4 class="card-title"><?php echo $row['usersName']; ?>
                </h4>
                <p class="card-text">Felhasználónév: <strong> <?php echo $row['usersUid']; ?></strong>
                </p>
                <div class="mx-auto" style="width: 15rem;">
                    <label class="form-label" for="">Jogosultság</label>
                    <select
                        onchange="enable( <?php echo $row['usersId']; ?>)"
                        name="roleId" id="" class="form-select">
                        <?php $sql2="SELECT * FROM users S INNER JOIN user_roles U ON S.rId=U.rId WHERE U.rId;";
              $result2=mysqli_query($conn, $sql2);
              $queryResults2=mysqli_num_rows($result2);
              $x=0;
              while ($row2=mysqli_fetch_assoc($result2)) {
                  if ($actId==$row2['rId'] && $x==0) { //ne jelenjen meg x-szer ugyan az a fióktípus
                      echo '<option id="opt-'.$row['usersId'].'" value="'.$row2['rId'].'">'.$row2['rDesc'].' (jelenlegi)</option>';
                      $x++;
                  }
              }
              $sql3="SELECT * FROM user_roles WHERE rId <> '$actId';";
              $result3=mysqli_query($conn, $sql3);
              while ($row3=mysqli_fetch_assoc($result3)) {
                  if ($row3['rId']!=1) {
                      echo '<option value="'.$row3['rId'].'">'.$row3['rDesc'].'</option>';
                  }
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
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Bezár</button>
                                    <form action="manage_users.php" method="post">
                                        <input type="hidden"
                                            value="<?php echo $row['usersId']; ?>"
                                            name="userId">
                                        <button type="submit" name="deleteUser" class="btn btn-danger">Törlés</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        id="modify-<?php echo $row['usersId']; ?>"
                        type="submit" name="modifyUserRole" class="btn btn-outline-primary d-none">Módoít</button>
                    <input type="hidden"
                        value="<?php echo $row['usersId']; ?>"
                        name="userId">
                </div>
            </div>
        </form>
    </div>
</div>
<?php
          }
      } ?>
</div>
</div>

<?php
 
 include_once 'footer.php';
      if (isset($_GET["modify_error"])) {
          if ($_GET["modify_error"]=="stmtfailed") {
              errorAlert("Valami nem stimmel, próbálkozz újra!", "manage_users.php", true);
          } elseif ($_GET["modify_error"]=="none") {
              errorAlert("A felhasználó jogosultságának mdosítása sikeresen megtörtént!", "manage_users.php", false);
          }
      }
      if (isset($_GET["delete_error"])) {
          if ($_GET["delete_error"]=="stmtfailed") {
              errorAlert("Valami nem stimmel, próbálkozz újra!", "manage_users.php", true);
          } elseif ($_GET["delete_error"]=="none") {
              errorAlert("A felhasználó törlése sikeresen megtörtént!", "manage_users.php", false);
          }
      }
  } else {
      echo '<script> location.replace("index.php"); </script>';
  }
?>
<script>
    function enable(id) {

        modifyBtnCL = document.getElementById('modify-' + id).classList.remove("d-none");

        // actualOption = document.getElementById('opt-' + id).value;
        // (actualOption != "") ? modifyButton.classList.add("d-none"): modifyButton.classList.remove("d-none");
    }
</script>