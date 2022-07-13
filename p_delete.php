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
    $set="UPDATE players SET pIsMember=0, pDeparture='$date' WHERE pId=?;";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $set)) {
        echo "<h2> class='red' Valami nem stimmel, próbálkozzon újra!</h2>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    echo "<div class='col-md-6 offset-3 text-center'> <h2 class='mt-3 green'>A játékos törlése sikeresen megtörtént!</h2>";
    echo '<a href="players.php" class="mt-3 btn btn-outline-primary ">OK</a></div>';
}
