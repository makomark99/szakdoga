<?php
if (isset($_POST["addFood"])) {
    $fDate=($_POST['Date']);
    $fDay=$_POST['Day'];
    $fTime=($_POST['When']);
    $fTeam=$_POST['Team'];
    $fNop=$_POST['Nop'];
    $fActivity=$_POST['Activity'];
    $fType=$_POST['What'];
    $fLoc=$_POST['Where'];
    $fEmail1=$_POST['email1'];
    $fEmail2=$_POST['email2'];
    $fEmail3=$_POST['email3'];
    $fIsOrdered=0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addFood($conn, $fDate, $fDay, $fTime, $fTeam, $fNop, $fActivity, $fType, $fLoc, $fEmail1, $fEmail2, $fEmail3, $fIsOrdered);
} else {
    header("location: ../food.php");
    exit();
}
