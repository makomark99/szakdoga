<?php
if (isset($_POST["addF"])) {
    $fDate=$_POST["Date"];
    $fDay=$_POST["Day"];
    $fTime=$_POST["When"];
    $fTeam=$_POST["Team"];
    $fNop=$_POST["Nop"];
    $fActivity=$_POST["Activity"];
    $fType=$_POST["What"];
    $fLoc=$_POST["Where"];
    $fEmail1=$_POST["Email1"];
    $fEmail2=$_POST["Email2"];
    $fEmail3=$_POST["Email3"];
    $fIsOrdered=0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addFood(
        $conn,
        $fDate,
        $fDay,
        $fTime,
        $fTeam,
        $fNop,
        $fActivity,
        $fType,
        $fLoc,
        $fEmail1,
        $fEmail2,
        $fEmail3,
        $fIsOrdered
    );
} else {
    header("location: ../food.php");
    exit();
}
