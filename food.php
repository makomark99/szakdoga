<?php
    include_once 'includes/dbh.inc.php';
    include_once 'header.php';
    include_once 'navbar.php';
    include_once 'includes/arrays.php';
    if (!isset($_SESSION["loggedin"])) {
        header('location: ../Szakdoga/login.php');
    }
?>

<div class="container-fluid">
    <div class="row ">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <form action="includes/addfood.inc.php" method="post">
                <!-- id="myForm" onsubmit="handleFormSubmit(this)" -->
                <h2 class=" text-center">Hidegcsomag rögzítés</h2>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <label class="form-label" for="Date">Dátum*</label>
                        <input type="date" class="form-control" onchange="getDayName()" id="fDate" min=<?php echo date('Y-m-d') ?>
                        max=9999-12-31
                        name="fDate" required>
                    </div>
                    <div class=" col-md-6">
                        <label class="form-label" for="fDay">Nap (auto)</label>
                        <input type="text" class="form-control notm text-light" id="fDay" name="fDay" disabled>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-4">
                        <label class="form-label" for="fWhen">Időpont*</label>
                        <input type="time" class="form-control" id="fWhen" name="fWhen" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="fTeam">Csapat*</label>
                        <select name="fTeam" id="fTeam" class="form-select" required>
                            <option value="U8">U8</option>
                            <option value="U9">U9</option>
                            <option value="U10">U10</option>
                            <option value="U11">U11</option>
                            <option value="U12">U12</option>
                            <option value="U13">U13</option>
                            <option value="U14">U14</option>
                            <option value="U15">U15</option>
                            <option value="Serdülő">Seri</option>
                            <option value="Ifjúsági">Ifi</option>
                            <option value="NB2">NB2</option>
                            <option value="MKC">MKC</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="fNop">Fő*</label>
                        <input type="number" min=1 max=60 class="form-control" value="15" id="fNop" name="fNop"
                            required>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-5">
                        <label class="form-label" for="fActivity">Tevékenység</label>
                        <select name="fActivity" id="fActivity" class="form-select" required>
                            <option value="Mérkőzés">Mérkőzés</option>
                            <option value="Torna">Torna</option>
                            <option value="Edzőmérkőzés">Edzőmérkőzés</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label" for="fWhat">Csomag kiválasztása*</label>
                        <select name="fWhat" id="fWhat" class="form-select">
                            <option value="Hidegcsomag">Hidegcsomag</option>
                            <option value="Rántotthúsos szendvics">Rántotthúsos szendvics</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <label for="fWhere" class="form-label">Helyszín*</label>
                        <input type="text" class="form-control" placeholder="Mérkőzés helyszíne" id="fWhere"
                            name="fWhere" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fEmail1" class="form-label ">E-mail beszállító*</label>
                        <input type="email" name="fEmail1" value="roli96@t-online.hu"
                            class="form-control notm text-light" id="fEmail1" disabled>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <label for="fEmail2" class="form-label">2. E-mail</label>
                        <input type="email" name="fEmail2" value="mark.mako@mkcse.hu" class="form-control" id="fEmail2">
                    </div>
                    <div class="col-md-6">
                        <label for="fEmail3" class="form-label">3. E-mail</label>
                        <input type="email" name="fEmail3" class="form-control" id="fEmail3">
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" name="submit" class="btn btn-primary">Rögzítés</button>
                </div>
                <div class="mt-4 col-md-auto">
                    <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"]== "none") {
                                echo "<p class='green text-center'>A megrendelendő csomag adatai sikeresen rögzítésre kerültek!</p>";
                            }
                            if ($_GET["error"]== "stmtfailed") {
                                echo "<p class='red'>Valami nem stimmel, próbálkozzon újra!</p>";
                            }
                        }
                    ?>
                </div>
            </form>
        </div>
        <?php
            $query="SELECT * FROM food WHERE fIsOrdered=0;";
            $result=mysqli_query($conn, $query);
            $queryResults=mysqli_num_rows($result);
        ?>
        <div class="col-lg-8 col-md-6 col-sm-12 ">
            <h2 class="text-center mb-5">Megrendelendő hidegcsomagok listája</h2>
            <table class="table table-dark table-hover">
                <thead class="thead-light ">
                    <tr>
                        <th>#</th>
                        <th>Dátum</th>
                        <th>Nap</th>
                        <th>Időpont</th>
                        <th>Csapat</th>
                        <th>Fő</th>
                        <th>Csomag</th>
                        <th>Helyszín</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    if ($queryResults>0) {
                        while ($row=mysqli_fetch_assoc($result)) {
                            ?>
                    <tr>
                        <td> <?php echo $i; ?>
                        </td>
                        <td><?php echo $row['fDate']; ?>
                        </td>
                        <td><?php echo $row['fDay']; ?>
                        </td>
                        <td><?php echo $row['fWhen']; ?>
                        </td>
                        <td><?php echo $row['fTeam']; ?>
                        </td>
                        <td><?php echo $row['fNop']; ?>
                        </td>
                        <td><?php echo $row['fWhat']; ?>
                        </td>
                        <td><?php echo $row['fWhere']; ?>
                        </td>
                    </tr>
                    <?php $i++;
                        }
                    }?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
    include 'footer.php';
?>

<script>
    // function preventFormSubmit() {
    //     var forms = document.querySelectorAll('form');
    //     for (var i = 0; i < forms.length; i++) {
    //         forms[i].addEventListener('submit', function(event) {
    //             event.preventDefault();
    //         });
    //     }
    // }
    // window.addEventListener('load', preventFormSubmit);

    // function handleFormSubmit(formObject) {
    //     google.script.run.processForm(formObject);
    //     document.getElementById("myForm").reset();
    // }

    function getDayName() {
        let _date = document.getElementById('fDate').value;
        let days = ['Vasárnap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'];
        let actual = new Date(_date);
        document.getElementById('fDay').value = days[actual.getDay()];
    }
</script>