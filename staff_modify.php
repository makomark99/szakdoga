<?php
    include 'header.php';
    include_once 'navbar.php';
    include_once 'includes/dbh.inc.php';
    include_once 'includes/arrays.php';
    include_once 'includes/SweetAlert.php';
    if (!isset($_SESSION["loggedin"])) {
        echo '<script> location.replace("login.php"); </script>';
        
    }

if (isset($_POST["modifyStaff"])) {
    $id=$_POST["modifyID"];
    $sCode=$_POST['sCode'];
    $sEmail=$_POST['sEmail'];
    $sEmail2=$_POST['sEmail2'];
    $sTel=$_POST['sTel'];
    $sPost=$_POST['sPost'];
    $sBDate=$_POST['sBDate'];
    $sHA=$_POST['sHA'];
    $sInternal=$_POST['sInternal'];
    $sLastModifiedBy= $_SESSION['useruid'];
    $sLastModifiedAt=date("Y-m-d");
    
    $sql="UPDATE staff SET sCode='$sCode', sEmail='$sEmail', sEmail2='$sEmail2', 
	sTel='$sTel', sPost='$sPost', sBDate='$sBDate',sHA='$sHA', sInternal='$sInternal', sLastModifiedAt='$sLastModifiedAt',
     sLastModifiedBy='$sLastModifiedBy' WHERE sId='$id'; ";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        errorAlert("Valami nem stimmel, próbálkozz újra!", "staff_modify.php?id=$id", true);
        exit();
    }
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    errorAlert("Adatok sikeresen módosítva!", "staff_modify.php?id=$id", false);
    exit();
}

if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $sql="SELECT * FROM staff WHERE sId=? AND sIsActive=1;";
    $stmt=mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "<h2> class='red' Valami nem stimmel, próbálkozzon újra!</h2>";
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result=mysqli_stmt_get_result($stmt);
    if ($row=mysqli_fetch_assoc($result)) {
        ?>
<h1 class="text-center mb-5">Dolgozók adatainak módosítása</h1>
<form class="row g-3" action="staff_modify.php" method="post">
    <div class="col-md-6 col-lg-3 ">
        <label for="sName" class="form-label ">Név*</label>
        <input name="sName" type="text" class="form-control notm" id="sName"
            value="<?php echo $row['sName']; ?>"
            disabled>
    </div>
    <div class="col-md-6 col-lg-3 ">
        <label for="sPost" class="form-label ">Beosztás*</label>
        <input name="sPost" type="text" class="form-control" id="sPost"
            value="<?php echo $row['sPost']; ?>">
    </div>
    <div class="col-md-4 col-lg-2 ">
        <label for="sBDate" class="form-label ">Születési dátum</label>
        <input id="sBDate" max="9999-12-31" name="sBDate" type="date"
            class="form-control <?php echo ($row['sBDate']==null || $row['sBDate']=='0000-00-00')? : "notm"; ?>"
            value="<?php echo $row['sBDate']; ?>"
            <?php echo ($row['sBDate']==null || $row['sBDate']=='0000-00-00')? : " readonly"; ?>>
    </div>
    <div class="col-md-4 col-lg-2 ">
        <label for="code" class="form-label ">Személy kód</label>
        <input name="sCode" type="text"
            class="form-control  <?php echo ($row['sCode']==null || $row['sCode']=='')? : "notm"; ?>"
            value="<?php echo $row['sCode']; ?>"
            <?php echo ($row['sCode']==null || $row['sCode']=='')? : " readonly"; ?>>
    </div>
    <div class="col-md-4 col-lg-2 ">
        <label for="sPassword" class="form-label ">MKSZ jelszó</label>
        <input name="sPassword" type="text" class="form-control " id="sPassword"
            value="<?php echo $row['sPassword']; ?>">
    </div>

    <div class="col-md-6 col-lg-3">
        <label for="sEmail" class="form-label">Céges e-mail (mkcse)</label>
        <input name="sEmail" type="email" class="form-control" id="sEmail" pattern="^[a-z0-9-_\.]+@mkcse\.hu$"
            placeholder="keresztnev.vezeteknev@mkcse.hu"
            title="Céges e-mail cím megadásakor csak mkcse mail címet lehet használni!"
            value="<?php echo $row['sEmail']; ?>">
    </div>
    <div class="col-md-6 col-lg-3">
        <label for="sEmail2" class="form-label">Magán e-mail (Google mail)</label>
        <input name="sEmail2" type="email" class="form-control" id="email2" pattern="^[a-z0-9-_\.]+@gmail\.com$"
            title="Magán e-mail cím megadásakor csak Google mail címet lehet használni!"
            value="<?php echo $row['sEmail2']; ?>">
    </div>
    <div class="col-md-6 col-lg-3 ">
        <label for="sTel" class="form-label">Telefonszám</label>
        <input name="sTel" type="text" title="Csak számok, vagy szóköz, '+' '/' jelek használata lehetséges!"
            pattern="^[\d\s\/\+]{9,30}$" class="form-control" id="tel1"
            value="<?php echo $row['sTel']; ?>">
    </div>

    <div class="col-md-6 col-lg-3">
        <label for="sInternal" class="form-label">Belső érintett?</label>
        <select class="form-select" name="sInternal" id="sInternal">
            <?php if ($row['sInternal']==0) {
            echo '<option value="0">Nem (jelenlegi)</option>
            <option value="1">Igen</option>';
        } else {
            echo '<option value="1">Igen (jelenlegi)</option>
              <option value="0">Nem</option>';
        } ?>
        </select>
    </div>
    <div class="col-md-8 col-lg-4 ">
        <label for="sHA" class="form-label">Lakhely (település)</label>
        <input name="sHA" title="Csak betűk, számok ',' '.' ';' és '/' jelek használata lehetséges!"
            pattern="^[a-zA-Z0-9 éáűőúöüóíÁÉÍŰÚŐÖÜÓ\s\/\,\.\;]*$" type="text" class="form-control"
            value="<?php echo $row['sHA']; ?>">
    </div>
    <div class="col-md-8 col-lg-8">
        <label for="sPhoto" class="form-label">Arcképes fotó URL</label>
        <input name="sPhoto" id="sPhoto" type="url" class="notm form-control" id="foto" disabled>
    </div>

    <div class="col-md-auto mt-4">
        <input type="hidden" value="<?php echo $id?>"
            name="modifyID">
        <button type="submit" id="btn" name="modifyStaff" class="btn btn-outline-primary">Módosít</button>
    </div>

</form>

<?php
    }
}

include_once 'footer.php';
?>