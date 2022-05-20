<?php 
    $dbServerName="localhost";
    $dbUserName="root";
    $dbPassword="";
    $dbName="phpproj";

    $conn=mysqli_connect($dbServerName,$dbUserName,$dbPassword,$dbName);
    if(!$conn){
        die("Megszakadt a kapcsolat: " . mysqli_connect_error());
    }

?>