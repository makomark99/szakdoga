<?php
include_once 'includes/dbh.inc.php';

if (isset($_SESSION["useruid"])) {
    $uname=$_SESSION["useruid"];
    $q="SELECT * FROM users WHERE usersUid='$uname';";
    $res=mysqli_query($conn, $q);
    $row=mysqli_fetch_assoc($res);
    if ($row['rId']==1) {
        $sadmin=true;
    } else {
        $sadmin=false;
    }
    if ($row['rId']==3) {
        $gUser=true;
    } else {
        $gUser=false;
    }
}
