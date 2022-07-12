<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
include_once '../header.php';
include_once '../navbar.php';
include_once '../auto_logout.php';

if (isset($_POST["submit"])) {
    $task=mysqli_real_escape_string($conn, $_POST['task']);
    $ref=$_POST['ref'];
    $deadline=$_POST['deadline'];
    $category=$_POST['category'];
    $username=$_SESSION["useruid"];
    $date=date("Y-m-d");
    $ready=0;
   
    addTask(
        $conn,
        $task,
        $ref,
        $deadline,
        $category,
        $username,
        $date,
        $ready
    );
} else {
    header("location: ../index.php");
    exit();
}
