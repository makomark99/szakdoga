<?php 
if(isset($_POST["submit"])){
    $pName=strtoupper($_POST['pName']);
    $pCode=$_POST['pCode'];
    $pBPlace=strtoupper($_POST['pBPlace']);
    $pBDate=$_POST['pBDate'];
    $pMsN=strtoupper($_POST['pMsN']);
    $pNat=$_POST['pNat'];
    $pSsn=$_POST['pSsn'];
    $pPTel=$_POST['pPTel'];
    $pTel=$_POST['pTel'];
    $pPEmail=$_POST['pPEmail'];
    $pEmail=$_POST['pEmail'];
    $pHA=$_POST['pHA'];
    $pSH=$_POST['pSH'];
    $pTSize=$_POST['pTSize'];
    $pPhoto=$_POST['pPhoto'];
    $pLMCDate=$_POST['pLMCDate'];
    $pMCD=$_POST['pMCD'];
    $pL1=$_POST['pL1'];
    $pL2=$_POST['pL2'];
    $pL3=$_POST['pL3'];
    $pTId=$_POST['pTId'];
    $pArrival=$_POST['pArrival'];
    $pIsMember=1;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(pCodeExists($conn,$pCode)!==false){
        header("location: ../p_add.php?error=pcodeexists");
        exit();
    }
    if(invalidpCode($pCode)!==false){
        header("location: ../p_add.php?error=invalidpcode");
        exit();
    }
    if(invalidpBDate($pBDate)!==false){
        header("location: ../p_add.php?error=invalidpbdate");
        exit();
    }
    if(invalidpLMCDate($pLMCDate)!==false){
        header("location: ../p_add.php?error=invalidpLMCDate");
        exit();
    }
    if(playerLicenseMatch($pL1,$pL2,$pL3)!==false){
        header("location: ../p_add.php?error=playerlicensematch");
        exit();
    }
    if(invalidSsn($pSsn)!==false){
        header("location: ../p_add.php?error=invalidssn");
        exit();
    }
    addPlayer($conn, $pName, $pCode,$pBPlace,$pBDate,$pMsN,$pNat,
                 $pSsn,$pPTel,$pTel,$pPEmail,$pEmail,$pTSize,$pPhoto
                ,$pLMCDate,$pMCD,$pL1,$pL2,$pL3,$pTId,$pIsMember,
                $pArrival, $pHA, $pSH);
}
else{
    header("location: ../p_add.php");
    exit();
}

?>