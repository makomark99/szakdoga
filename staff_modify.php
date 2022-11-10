<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
    include_once 'includes/SweetAlert.php';
  
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }

if (isset($_POST["modifyStaff"])) {
    $id=$_POST["modifyID"];
    $sCode=$_POST['sCode'];
    $sEmail=$_POST['sEmail'];
    $sEmail2=$_POST['sEmail2'];
    $sTel=$_POST['sTel'];
    $sPost=$_POST['sPost'];
    $set="UPDATE staff SET sCode='$sCode', sEmail='$sEmail' sEmail2='$sEmail2' 
	sTel='$sTel' sPost='$sPost' WHERE sId=?;";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $set)) {
        echo '<script> location.replace("staff.php?modifystaff=stmtfailed"); </script>';
        exit();
    }
    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    echo '<script> location.replace("staff.php?modifystaff=none"); </script>';
}
