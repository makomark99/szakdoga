<?php 
include_once 'dbh.inc.php';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">

<div class="container">
helló
<?php 
$pSsn="";

$result;
  if($pSsn!=""){
    if(preg_match('/[-]/',$pSsn)){
      if(!preg_match('/^[0-9-]{11}$/',$pSsn)){
        $result=true;
      }
      else $result=false;
    }
    elseif(!preg_match('/^[0-9]{9}$/',$pSsn)){
      $result=true;
    }
    else $result=false;   
  }
  else $result=false;
  return $result;

/*
$i=1;
echo "pL$i";
echo '<br>';
$pCode="1243332";
echo strlen($pCode);
  if($pCode!=""){
    if(is_numeric($pCode) && (strlen($pCode)>=3 && strlen($pCode)<=6)){
        $result="true, fasza";
    }
    else{
        $result="false, sok v kevés vagy nem szám";
    }
  }
  else{
    $result="false, üres sztring";
  }
echo $result;
echo '<br>';echo '<br>';

$p="345";
if($p!=""){
  if(!preg_match('/^[0-9]{3,6}$/',$p)){
    echo "It is not an empty sting but not a match either!!!!";
  }
  else echo "Not an empty string but it is a match Yuppy";
}
else echo "An empty string, but not invalid";
echo '<br>';echo '<br>';


$pBDate="2019-03-20";
$age=floor((time()-(strtotime($pBDate)))/(60*60*24)/365.2425); 
if($age<3){
  echo "nem adható hozzá";
}
else echo "simasz";
echo '<br>';echo '<br>';

$pLMCDate="2022-03-21";
if(time()-strtotime($pLMCDate)<0){
  echo "true, azaz rossz dátum";
}
else echo "false, tehát helyes";

echo '<br>';echo '<br>';
$pL1="";
$pL2="";
$pL3="";
$result;
    if(($pL1!="" && $pL2!="") && ($pL1===$pL2)){
      echo"true";
    }
    elseif(($pL1!="" && $pL3!="") && ($pL1===$pL3)){
      echo"true";
    }
    elseif(($pL2!="" && $pL3!="") && ($pL2===$pL3)){
        echo"true";
    }
    else echo "false";
*/
?>

</div>