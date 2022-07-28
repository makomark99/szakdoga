<?php
if (isset($_POST['submit'])) {
    $fDate=$_POST['fDate'];
    $fDay=$_POST['fDay'];
    $fWhen=$_POST['fWhen'];
    $fTeam=$_POST['fTeam'];
    $fNop=$_POST['fNop'];
    $fActivity=$_POST['fActivity'];
    $fWhat=$_POST['fWhat'];
    $fWhere=$_POST['fWhere'];
    $fEmail1=$_POST['fEmail1'];
    $fEmail2=$_POST['fEmail2'];
    $fEmail3=$_POST['fEmail3'];
    $fIsOrdered=0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    addFood(
        $conn,
        $fDate,
        $fDay,
        $fWhen,
        $fTeam,
        $fNop,
        $fActivity,
        $fWhat,
        $fWhere,
        $fEmail1,
        $fEmail2,
        $fEmail3,
        $fIsOrdered
    );
} else {
    header("location: ../food.php");
    exit();
}
