<?php
include_once 'dbh.inc.php';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link href="style.css" rel="stylesheet">

<div class="container">
	helló
	<form action="">
		<input type="text" name="" pattern="^[+ 0-9]*$"
			title="Telefonszám megadásakor csak '+'-jelet, szóközt és/vagy számokat lehet megadni!" id="">

		<div class="col-md-6 col-lg-3 ">
			<label for="email2" class="form-label">Magán e-mail (Google mail)</label>
			<input name="sEmail2" type="email" class="form-control" id="email2" pattern="^[a-z0-9\.]+@gmail\.com$"
				title="Magán e-mail cím megadásakor csak Google mail-es címet lehet megadni!"
				placeholder="minta@gmail.com">
		</div>

		<div class="col-md-6 col-lg-3">
			<label for="name" class="form-label">Név*</label>
			<input name="sName" type="text" title="Csak betűk használata lehetséges"
				pattern="^[a-zA-Z áéíóöőúüűÁÉÍŰÚŐÖÜÓ.]*$" class="form-control" id="name"
				placeholder="Vezetéknév Keresztnév" required>
		</div>

		<div class="col-md-4 col-lg-2 ">
			<label for="sHA" class="form-label">Lakhely (település)</label>
			<!-- NEM JÓ -->
			<input name="sHA" pattern="([a-zA-ZáéíóöőúüűÁÉÍŰÚŐÖÜÓ]{3,}(?: [a-zA-ZáéíóöőúüűÁÉÍŰÚŐÖÜÓ0-9]*){0,4}){3-10}$"
				title="Lakhely megadásánál csak számokat és betűket használhat és min. 3 max 50 karakter adható meg!"
				placeholder="Lakhely" value="" type="text" class="form-control" id="sHA">
		</div>

		<button class="btn btn-warning" type="submit">Beküld</button>
	</form>
	<?php
$pSsn="";

$result;
  if ($pSsn!="") {
      if (preg_match('/[-]/', $pSsn)) {
          if (!preg_match('/^[0-9-]{11}$/', $pSsn)) {
              $result=true;
          } else {
              $result=false;
          }
      } elseif (!preg_match('/^[0-9]{9}$/', $pSsn)) {
          $result=true;
      } else {
          $result=false;
      }
  } else {
      $result=false;
  }
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