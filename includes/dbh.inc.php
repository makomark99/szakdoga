<?php

$ServerName="localhost";
$dBUsername="root";
$dBPassword="";
$dBName="phpproj";

$conn = mysqli_connect($ServerName,$dBUsername,$dBPassword,$dBName);

if(!$conn){
    die("Megszakadt a kapcsolat: " . mysqli_connect_error());
}