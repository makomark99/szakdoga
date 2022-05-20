<?php

if(isset($_POST["submit"])){
    
    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrep = $_POST["pwdrepeat"];
    $token=$_POST["token"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if(invalidUid($username)!==false){
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if(pwdMatch($pwd,$pwdrep)!==false){
        header("location: ../signup.php?error=passworderror");
        exit();
    }
    if(pwdIsStrong($pwd)!==false){
        header("location: ../signup.php?error=weakpassword");
        exit();
    }
    if(uidExists($conn,$username,$email)!==false){
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    createUser($conn,$name,$email,$username,$pwd,$token);

}
else{
    header("location: ../signup.php");
    exit();
}