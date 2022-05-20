<?php 
if(isset($_POST["modify"])){
    $pTId=$_POST['pTId'];
    $pLMCDate=$_POST['pLMCDate'];
    //$pMCD=mysqli_real_escape_string($_POST['pMCD']);
    $pMCD=$_POST['pMCD'];
    $pPEmail=$_POST['pPEmail'];
    $pEmail=$_POST['pEmail'];
    $pPTel=$_POST['pPTel'];
    $pTel=$_POST['pTel'];
    $pSH=$_POST['pSH'];
    $pTSize=$_POST['pTSize'];
    $pL1=$_POST['pL1'];
    $pL2=$_POST['pL2'];
    $pL3=$_POST['pL3'];
    $pSsn=$_POST['pSsn'];
    $pHA=$_POST['pHA'];
    $pPhoto=$_POST['pPhoto'];
    $id=$_GET['id'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
   
    if(invalidpCode($pCode)!==false){
        header("location: ../p_modify.php?error=invalidpcode");
        exit();
    }
    if(invalidpBDate($pBDate)!==false){
        header("location: ../p_modify.php?error=invalidpbdate");
        exit();
    }
    if(invalidpLMCDate($pLMCDate)!==false){
        header("location: ../p_modify.php?error=invalidpLMCDate");
        exit();
    }
    if(playerLicenseMatch($pL1,$pL2,$pL3)!==false){
        header("location: ../p_modify.php?error=playerlicensematch");
        exit();
    }
    if(invalidSsn($pSsn)!==false){
        header("location: ../p_modify.php?error=invalidssn");
        exit();
    }
    modifyPlayer($id,$conn,$pTId,$pLMCDate,$pMCD,$pPEmail,$pEmail,$pPTel,$pTel, 
        $pSH,$pTSize,$pL1,$pL2,$pL3,$pSsn,$pHA,$pPhoto);
}
else{
    header("location: ../p_modify.php");
    exit();
}

?>