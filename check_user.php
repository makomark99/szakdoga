<?php
include_once 'includes/dbh.inc.php';

if (isset($_SESSION["useruid"])) {
    $uname=$_SESSION["useruid"];
    $q="SELECT * FROM users WHERE usersUid='$uname';";
    $res=mysqli_query($conn, $q);
    $row=mysqli_fetch_assoc($res);
    $sadmin=($row['rId']==1)?true:false;
    $admin=($row['rId']==2)?true:false;
    $gUser=($row['rId']==3)?true:false;
}
