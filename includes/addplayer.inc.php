<?php
if (isset($_POST["submit"])) {
    $pName= mb_strtoupper($_POST['pName'], "UTF-8");
    $pCode=$_POST['pCode'];
    $pBPlace= mb_strtoupper($_POST['pBPlace'], "UTF-8");
    $pBDate=$_POST['pBDate'];
    $pMsN= mb_strtoupper($_POST['pMsN'], "UTF-8");
    $pNat=$_POST['pNat'];
    $pSsn=$_POST['pSsn'];
    $pPTel=$_POST['pPTel'];
    $pTel=$_POST['pTel'];
    $pPEmail=$_POST['pPEmail'];
    $pEmail=$_POST['pEmail'];
    $pHA= mb_strtoupper($_POST['pHA'], "UTF-8");
    $pSH=$_POST['pSH'];
    $pTSize=$_POST['pTSize'];
    $pLMCDate=$_POST['pLMCDate'];
    $pMCD=$_POST['pMCD'];
    $pL1 = ($_POST['pL1']=='')? null: $_POST['pL1'];
    $pL2 = ($_POST['pL2']=='')? null: $_POST['pL2'];
    $pL3 = ($_POST['pL3']=='')? null: $_POST['pL3'];
    $pTId=$_POST['pTId'];
    $pArrival=$_POST['pArrival'];
    $pIsMember=1;
    $pPost=$_POST['pPost'];
    $pPHand=$_POST['pPHand'];
    $pPhoto=mysqli_real_escape_string($conn, $_POST['pPhoto']);
    $pLastModifiedBy=$_POST['pLastModifiedBy'];
    $pLastModifiedAt=date("Y-m-d");

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (pCodeExists($conn, $pCode)!==false) {
        header("location: ../p_add.php?error=pcodeexists");
        exit();
    }
    if (pSsnExists($conn, $pSsn)!==false) {
        header("location: ../p_add.php?error=pssnexists");
        exit();
    }
    addPlayer(
        $conn,
        $pName,
        $pCode,
        $pBPlace,
        $pBDate,
        $pMsN,
        $pNat,
        $pHA,
        $pSH,
        $pPTel,
        $pTel,
        $pPEmail,
        $pEmail,
        $pTSize,
        $pSsn,
        $pLMCDate,
        $pMCD,
        $pL1,
        $pL2,
        $pL3,
        $pPost,
        $pPHand,
        $pPhoto,
        $pTId,
        $pIsMember,
        $pArrival,
        $pLastModifiedAt,
        $pLastModifiedBy
    );
} else {
    header("location: ../p_add.php");
    exit();
}
