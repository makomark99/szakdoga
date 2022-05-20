<?php 
include_once 'dbh.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>


        <div class="row">
            <div class="col-auto me-auto"> Játékosok keresése</div>
            <div class="col-auto"> 
                <input type="text" name="" id="">
                <button type="submit">Ki</button>
                
                    <div class="form-inline">
                    <div class="form-group">
                <form action="detailed.php">
         <button title="Szűrő" class="btn btn-outline-primary me-2" name="detailed" type="submit">
         <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-filter" viewBox="0 0 16 16">
            <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5z"/>
          </svg>
         </button>
         </form>
         </div>
         </div>
         </div>
             </div>
        </div>
  
    <br>
    <label for="#t"><fieldset><legend>Token</legend></label>
    <form action="" method="post">     
    <input type="password" name="token" id="t" placeholder="token">
         <button name="submit" type="submit">Submit</button>
         </form>
    </fieldset>
    
   


    <?php 

    if( isset($_POST["submit"])){
         $token=$_POST["token"];
    }

    $age=18;
    $date="2021-03-05";
    $days=strtotime($date);
    
    $elapsedDays=floor((time()-$days)/(60*60*24));
    echo "Eltelt napok:$elapsedDays";
    
    $valid=364;
    echo "<br>";
    if($age<18 && $elapsedDays<=$valid/2){
        $valid=$valid/2-$elapsedDays;
        echo "Érvényes $valid napig";
    }
    else if($age>=18 && $elapsedDays<=$valid){
        $valid=$valid-$elapsedDays;
        echo "Érvényes $valid napig";
    }
    else if($age<18) {
        $valid=$valid/2-$elapsedDays;
        echo "Lejárt ".abs($valid)." napja ";
    }
    else{ echo 
        $valid=$valid-$elapsedDays;
        echo "Lejárt ".abs($valid)." napja ";
    }
    //év kiszámolása
    $time= strtotime("1999-11-30");
    echo floor((time()-$time)/(60*60*24)/365);
    echo "<br>";


    //$test='a3';
    $sql= "SELECT * FROM reg_tokens WHERE tokens='$token' AND valid='1';";
    //Create a prepared statement
    $stmt=mysqli_stmt_init($conn); //initialize a prepared statement
    // Prepare the prepared statement
    if(!mysqli_stmt_prepare($stmt,$sql)){ //Check the 2 paramaters succeed
        echo "SQL statement failed";
    }
    else {
        //Bind parameters to the placeholder, if there is a '?'
       // mysqli_stmt_bind_param($stmt, 's', $test); -> this only needed when there is a '?' in the sql query
        //Run parameters inside database
        mysqli_stmt_execute($stmt);
        $result=mysqli_stmt_get_result($stmt);
        if($row=mysqli_fetch_assoc($result)){
                echo "Yuppy";
                $update="UPDATE reg_tokens SET valid=0 WHERE tokens='$token';";
                $stmt2=mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt2,$update)){
                    return false;
                }
                else{
                    mysqli_stmt_execute($stmt2);
                    return true;
                }
        }
    }

    /*
     $sql="SELECT * FROM reg_tokens WHERE valid='1';";
    $result=mysqli_query($conn,$sql);
    $resultCheck=mysqli_num_rows($result);
    if($resultCheck>0){
        while($row=mysqli_fetch_assoc($result)){
          echo $row['tokens'] . "<br>";
           if($row['tokens']==$token){
                echo " Hashelés nélül jó a mutatvány!";
                $query="UPDATE reg_tokens  SET valid=0 WHERE tokens=$token;";
                $result2=mysqli_query($conn,$query);
            }
           echo "<br>";
         }
    }
    */

    ?>
    


</body>
</html>