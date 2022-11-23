<?php
//signup functions
// function invalidUid($username)
// {
//     $result;
//     if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) { //*:>=0 előfordulás
//         $result=true;
//     } else {
//         $result=false;
//     }
//     return $result;
// }

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
function pSsnExists($conn, $pSsn)
{
    $result;
    if ($pSsn!="") {
        $sql = "SELECT * FROM players WHERE pSsn = ?;";
        $stmt=mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../p_add.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $pSsn);
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

function addPlayer(
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
) {
    $sql = "INSERT INTO players (pName,pCode,pBPlace,pBDate,pMsN,pNat,pHA,pSH,pPTel,pTel,
            pPEmail,pEmail,pTSize,pSsn,pLMCDate,pMCD,pL1,pL2,pL3,pPost,pPHand,pPhoto,pTId,pIsMember,
            pArrival,pLastModifiedAt,pLastModifiedBy) 
            VALUES(?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?,
                    ?, ?, ?, ?, ?, 
                    ?, ?);";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../p_add.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssssssssssssssss",
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
    $fWhen,
    $fTeam,
    $fNop,
    $fActivity,
    $fWhat,
    $fWhere,
    $fEmail1,
    $fEmail2,
    $fEmail3,
    $fIsOrdered
) {
    $sql = "INSERT INTO food (fDate,fDay,fWhen,fTeam,fNop,fActivity,fWhat,fWhere,fEmail1,fEmail2,fEmail3,fIsOrdered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
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
        $fWhen,
        $fTeam,
        $fNop,
        $fActivity,
        $fWhat,
        $fWhere,
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
