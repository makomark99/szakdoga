<?php
  include_once 'header.php';
  include_once 'navbar.php';
  include_once 'includes/dbh.inc.php';
  if (!isset($_SESSION["loggedin"])) {
    echo '<script> location.replace("login.php"); </script>';
    
}
  
 
?>

<div class="col-md-12">
    <div class="d-flex justify-content-end">
        <div class="d-flex col-md-3">
            <!-- <input class="form-control me-2" type="text" name="search2" id="search2"
                placeholder="Munkatárs keresése név alapján"> -->
        </div>

        <div class="">
            <a href="staff_add.php" title="Munkatárs hozzáadása" class="btn btn-outline-primary me-2">
                <?php include "img/plus-lg.svg"?>
            </a>
            </form>
        </div>
    </div>
    <div id="output2" class="table-responsive">
        <h1 class="text-center mb-2">Munkatársak adatai</h1>
        <?php $sql = "SELECT * FROM staff WHERE sIsActive=1";
        $result=mysqli_query($conn, $sql);
        $queryResults=mysqli_num_rows($result);
        $th=1;

        ?>

        <div class="container-fluid mt-4">

            <table id="ptable" class="table table-dark table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Név</th>
                        <th>Személy kód</th>
                        <th>Belső E-mail</th>
                        <th>E-mail</th>
                        <th>Telefonszám</th>
                        <th>Beosztás</th>
                        <th
                            class="<?php echo ($sadmin)? : 'd-none'; ?>">
                            Műveletek</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row=mysqli_fetch_assoc($result)) {
            ?>

                    <tr
                        style='<?php echo (!$sadmin) ?  : "font-size:90%;"; ?>'>
                        <td class="align-middle">
                            <?php echo $th++; ?>
                        </td>
                        <td class="align-middle">
                            <?php echo $row['sName']; ?>
                        </td>

                        <td class="align-middle ">
                            <?php echo $row['sCode']; ?>
                        </td>

                        <td class="align-middle ">
                            <?php echo $row['sEmail']; ?>
                        </td>

                        <td class="align-middle ">
                            <?php echo $row['sEmail2']; ?>
                        </td>


                        <td class="align-middle ">
                            <?php echo $row['sTel']; ?>
                        </td>



                        <td class="align-middle ">
                            <?php echo $row['sPost']; ?>
                        </td>

                        <td
                            class="<?php echo ($sadmin)? : 'd-none'; ?>">
                            <input type="hidden"
                                name="sLastModifiedBy<?php echo $row['sId']; ?>"
                                value="<?php echo $_SESSION['useruid']; ?>">

                            <input type="hidden"
                                name="modifyID<?php echo $row['sId']; ?>"
                                value="<?php echo $row['sId']; ?>">
                            <a href="staff_modify.php?id=<?php echo $row['sId']; ?>"
                                class="btn btn-sm btn-outline-warning">
                                <?php include 'img/pencil.svg' ?>
                            </a>


                            <a title="Törlés" class="btn btn-sm btn-outline-danger " data-bs-toggle="modal"
                                data-bs-target="#delete<?php echo $row['sId']; ?>">
                                <!--egyedi id kell, mert minding az elsőt találta meg-->
                                <?php include 'img/trash.svg' ?>
                            </a>
                        </td>

                    </tr>
                    <div class="modal fade"
                        id="delete<?php echo $row['sId']; ?>"
                        tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content text-dark fs-5">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="deleteLabel">Munkatárs törlése</h4>
                                    <button type="button" class="btn-close " data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <?php
                echo 'Biztosan szeretné <strong>TÖRÖLNI</strong> a következő nevű dolgozót az adatbázisból: '.$row['sName'].' ?'; ?>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Bezár</button>
                                    <a href="staff_delete.php?id=<?php echo $row['sId']; ?>"
                                        title="Törlés" name="deleteStaff" class="btn btn-danger ">Törlés</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
        }
    
?>
                </tbody>
            </table>

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