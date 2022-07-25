<?php
include_once 'navbar.php';
include_once 'header.php';
include_once 'includes/dbh.inc.php';
if (!isset($_SESSION["loggedin"])) {
    header('location: ../Szakdoga/login.php');
}
if (isset($_GET["id"])) {
    $id=$_GET["id"];
    $date=date("Y-m-d");
    $set="UPDATE tasks SET taskIsReady=1, taskDoneDate='$date' WHERE tId=?;";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $set)) {
        echo "<h2> class='red' Valami nem stimmel, próbálkozzon újra!</h2>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    echo "<div class='col-md-6 offset-3 text-center'> <h2 class='mt-3 green'>A feladat elkészültként lett berögzíve</h2>";
    echo '<a href="index.php" class="mt-3 btn btn-outline-primary ">OK</a></div>';
}
