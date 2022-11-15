<?php
    include_once 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/SweetAlert.php';
    
    if (!isset($_SESSION["loggedin"])) {
        echo '<script> location.replace("login.php"); </script>';
        
    }
    if (isset($_GET["id"])) {
        $id=$_GET["id"];
        $date=date("Y-m-d");
        $sLastModifiedBy= $_SESSION['useruid'];
        $set="UPDATE staff SET sIsActive=0, sLeavingAt='$date', sLastModifiedBy=' $sLastModifiedBy', sLastModifiedAt='$date' WHERE sId=?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $set)) {
            errorAlert("Valami nem stimmel, próbálkozz újra!", "staff.php", true);
            exit();
        }
        mysqli_stmt_bind_param($stmt, 's', $id);
        mysqli_stmt_execute($stmt);
        errorAlert("A munkatárs törlése sikeresen megtörtént!", "staff.php", false);
    }
