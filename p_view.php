<?php
include_once 'navbar.php';
include_once 'includes/dbh.inc.php';
include_once 'header.php';
if (!isset($_SESSION["loggedin"])) {
    header('location: ../Szakdoga/login.php');
}
    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        $sql="SELECT * FROM players WHERE pId=?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo "<h2> class='red' Valami nem stimmel, próbálkozzon újra!</h2>";
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if ($row=mysqli_fetch_assoc($result)) {
            ?>
<div class="card bg-black">
    <div class="row">
        <div class="col-md-4 col-sm-7">
            <img id="viewp" class="img-fluid"
                src="<?php $row["Photo"]; ?>"
                title="Arcképes fotó" alt="Arcképes fotó">
        </div>
        <div class="col-md-8 col-sm-5">
            <h2 class="card-title mt-2 mb-3 ">Személy adatai</h2>
            <div class="col-md-4">
                <label> <i>Név</i> </label>
                <h5 class="mb-3"><?php echo $row['pName']; ?>
                </h5>
                <label> <i>Születési hely</i> </label>
                <h5 class="mb-3"><?php echo $row['pBPlace']; ?>
                </h5>
                <label> <i>Születési dátum</i> </label>
                <h5 class="mb-3"><?php echo $row['pBDate']; ?>
                </h5>
                <label> <i>Anyja neve</i> </label>
                <h5 class="mb-3"><?php echo $row['pMsN']; ?>
                </h5>
            </div>
            <div class="col-md-4">
                <label> <i> MKSZ Személy kód</i></label>
                <h5 class="mb-3"><?php if ($row['pCode']!="") {
                echo $row['pCode'];
            } else {
                echo "Még nem készült el az igazolása";
            } ?>
                </h5>
                <label> <i> Sportorvosi dátum</i></label>
                <h5 class="mb-3"><?php if ($row['pLMCDate']!="" && $row['pLMCDate']!=0000-00-00) {
                echo $row['pLMCDate'];
            } else {
                echo "Még nem volt vizsgálaton";
            } ?>
                </h5>
                <label> <i>Sportorvos</i> </label>
                <h5 class="mb-3"><?php if ($row['pMCD']!="") {
                echo $row['pMCD'];
            } else {
                echo "Nem ismert";
            } ?>
                </h5>
                <label> <i>Edző neve</i> </label>
                <h5 class="mb-3"><?php if ($row['pTrainer']!="") {
                echo $row['pTrainer'];
            } else {
                echo "Nem ismert";
            } ?>
                </h5>
            </div>
        </div>
    </div>
</div>
<?php
        }
    } else {
        echo "<h2> class='red' Valami nem stimmel, próbálkozzon újra!</h2>";
    }
    include_once 'footer.php';
