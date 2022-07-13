<?php
//signup functions
function invalidUid($username)
{
    $result;
    if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) { //*:>=0 előfordulás
        $result=true;
    } else {
        $result=false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat)
{
    $result;
    if ($pwd!==$pwdRepeat) {
        $result=true;
    } else {
        $result=false;
    }
    return $result;
}

function pwdIsStrong($pwd)
{
    $result;
    if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z]{8,30}$/', $pwd)) {
        $result=true;
    } else {
        $result=false;
    }
    return $result;
}

function uidExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData=mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result=false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd, $token)
{
    $sql= "SELECT * FROM reg_tokens WHERE tokens='$token' AND valid='1';";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    } else {
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if ($row=mysqli_fetch_assoc($result)) {
            $sql2="UPDATE reg_tokens SET valid=0 WHERE tokens='$token';";
            $stmt2=mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                header("location: ../signup.php?error=stmtfailed");
                exit();
            } else {
                mysqli_stmt_execute($stmt2);
                $sql3 = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
                $stmt3=mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt3, $sql3)) {
                    header("location: ../signup.php?error=stmtfailed");
                    exit();
                }
                $hashedPwd=password_hash($pwd, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt3, "ssss", $name, $email, $username, $hashedPwd);
                mysqli_stmt_execute($stmt3);
                mysqli_stmt_close($stmt3);
                header("location: ../signup.php?error=none");
                exit();
            }
        } else {
            header("location: ../signup.php?error=wrongtoken");
            exit();
        }
    }
}
//login functions
function emtpyInputLogin($username, $pwd)
{
    $result;
    if (empty($username) || empty($pwd)) {
        $result =true;
    } else {
        $result=false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd)
{
    $uidExists= uidExists($conn, $username, $username);

    if ($uidExists===false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd=password_verify($pwd, $pwdHashed);
    if ($checkPwd===false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    } elseif ($checkPwd===true) {
        session_start();
        $_SESSION["userid"]= $uidExists["usersId"];
        $_SESSION["useruid"]= $uidExists["usersUid"];
        $_SESSION["last_login_time"]=time();
        $_SESSION["loggedin"]=true;
        header("location: ../index.php");
        exit();
    }
}

//add_player functions
function pCodeExists($conn, $pCode)
{
    $result;
    if ($pCode!="") {
        $sql = "SELECT * FROM players WHERE pCode = ?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../p_add.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $pCode);
        mysqli_stmt_execute($stmt);

        $resultData=mysqli_stmt_get_result($stmt);
        $row =mysqli_num_rows($resultData);
        if ($row>0) {
            $result=true;
        } else {
            $result=false;
        }
        mysqli_stmt_close($stmt);
    } else {
        $result=false;
    }
    return $result;
}

function invalidpCode($pCode)
{
    $result;
    if ($pCode!="") {
        if (!preg_match('/^[0-9]{3,6}$/', $pCode)) {
            $result=true;
        } else {
            $result=false;
        }
    } else {
        $result=false;
    }
    return $result;
}

function invalidpBDate($pBDate)
{
    $age=floor((time()-(strtotime($pBDate)))/(60*60*24)/365.2425);
    $result;
    if ($age<3) {
        $result=true;
    } else {
        $result=false;
    }
    return $result;
}

function invalidSsn($pSsn)
{
    $result;
    if ($pSsn!="") {
        if (preg_match('/[-]/', $pSsn)) { //ha tartalmaz kötőjelet
            if (!preg_match('/^[0-9-]{11}$/', $pSsn)) {
                $result=true;
            } else {
                $result=false;
            }
        } elseif (!preg_match('/^[0-9]{9}$/', $pSsn)) { //ha csak számot tartamaz
            $result=true;
        } else {
            $result=false;
        }
    } else {
        $result=false;
    }
    return $result;
}

function invalidpLMCDate($pLMCDate)
{
    $result;
    if (time()-strtotime($pLMCDate)<0) {
        $result=true;
    } else {
        $result=false;
    }
    return $result;
}

function playerLicenseMatch($pL1, $pL2, $pL3)
{
    $result=false;
    if (($pL1!="" && $pL2!="") && ($pL1===$pL2)) {
        $result=true;
    } elseif (($pL1!="" && $pL3!="") && ($pL1===$pL3)) {
        $result=true;
    } elseif (($pL2!="" && $pL3!="") && ($pL2===$pL3)) {
        $result=true;
    } else {
        $result=false;
    }
    return $result;
}

function addPlayer(
    $conn,
    $pName,
    $pCode,
    $pBPlace,
    $pBDate,
    $pMsN,
    $pNat,
    $pSsn,
    $pPTel,
    $pTel,
    $pPEmail,
    $pEmail,
    $pTSize,
    $pPhoto,
    $pLMCDate,
    $pMCD,
    $pL1,
    $pL2,
    $pL3,
    $pTId,
    $pIsMember,
    $pArrival,
    $pHA,
    $pSH
) {
    $sql = "INSERT INTO players (pName,pCode,pBPlace,pBDate,pMsN,pNat,pSsn,pPTel,pTel,
            pPEmail,pEmail,pTSize,pPhoto,pLMCDate,pMCD,pL1,pL2,pL3,pTId,pIsMember,
            pArrival, pHA, pSH) 
            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../p_add.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssssssssssss",
        $pName,
        $pCode,
        $pBPlace,
        $pBDate,
        $pMsN,
        $pNat,
        $pSsn,
        $pPTel,
        $pTel,
        $pPEmail,
        $pEmail,
        $pTSize,
        $pPhoto,
        $pLMCDate,
        $pMCD,
        $pL1,
        $pL2,
        $pL3,
        $pTId,
        $pIsMember,
        $pArrival,
        $pHA,
        $pSH
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../p_add.php?error=none");
    exit();
}

//modify_player
function modifyPlayer(
    $id,
    $conn,
    $pTId,
    $pLMCDate,
    $pMCD,
    $pPEmail,
    $pEmail,
    $pPTel,
    $pTel,
    $pSH,
    $pTSize,
    $pL1,
    $pL2,
    $pL3,
    $pSsn,
    $pHA,
    $pPhoto
) {
    $sql="UPDATE players SET pTId='$pTId', pLMCDate='$pLMCDate', pMCD='$pMCD', pPEmail='$pPEmail',
         pEmail='$pEmail', pPTel='$pPTel', pTel='$pTel',pSH='$pSH',pTSize='$pTSize',
         pL1='$pL1',pL2='$pL2',pL3='$pL3', pSsn='$pSsn',pHA='$pHA' WHERE pId='$id'; ";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../p_modify.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../p_modify.php?error=none");
    exit();
}

//addFood (orders)

function addFood(
    $conn,
    $fDate,
    $fDay,
    $fTime,
    $fTeam,
    $fNop,
    $fActivity,
    $fType,
    $fLoc,
    $fEmail1,
    $fEmail2,
    $fEmail3,
    $fIsOrdered
) {
    $sql = "INSERT INTO food (fDate,fDay,fTime,fTeam,fNop,fActivity,fType,fLoc,fEmail1,fEmail2,fEmail3,fIsOrdered) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../food.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssss",
        $fDate,
        $fDay,
        $fTime,
        $fTeam,
        $fNop,
        $fActivity,
        $fType,
        $fLoc,
        $fEmail1,
        $fEmail2,
        $fEmail3,
        $fIsOrdered
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../food.php?error=none");
    exit();
}
function addTask(
    $conn,
    $task,
    $ref,
    $deadline,
    $category,
    $username,
    $date,
    $ready
) {
    $sql = "INSERT INTO tasks (taskDesc,taskRef,taskDeadline,taskCategory,taskCreator,taskDate,taskIsReady) 
            VALUES(?, ?, ?, ?, ?, ?, ?);";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../index.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param(
        $stmt,
        "sssssss",
        $task,
        $ref,
        $deadline,
        $category,
        $username,
        $date,
        $ready
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../index.php?error=none");
    exit();
}
