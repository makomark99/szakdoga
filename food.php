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
            <form id="myForm" action="includes/addfood.inc.php" method="post">
                <!-- onsubmit="handleFormSubmit(this)" -->
                <h2 class=" text-center">Hidegcsomag rögzítés</h2>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <label class="form-label" for="Date">Dátum*</label>
                        <input type="date" class="form-control" onchange="getDayName()" id="Date" min=<?php echo date('Y-m-d') ?>
                        max=9999-12-31
                        name="Date" required>
                    </div>
                    <div class=" col-md-6">
                        <label class="form-label" for="Day">Nap (auto)</label>
                        <input type="text" class="form-control" id="Day" name="Day" disabled>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-4">
                        <label class="form-label" for="Date">Időpont*</label>
                        <input type="time" class="form-control" id="Date" name="When" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="Team">Csapat*</label>
                        <select name="Team" id="Team" class="form-select" required>
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
                            <option value="other">MKC</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="Nop">Fő*</label>
                        <input type="number" min=1 max=60 class="form-control" value="15" id="nop" name="Nop" required>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-5">
                        <label class="form-label" for="Activity">Tevékenység</label>
                        <select name="Activity" id="Activity" class="form-select" required>
                            <option value="Mérkőzés">Mérkőzés</option>
                            <option value="Torna">Torna</option>
                            <option value="Edzőmérkőzés">Edzőmérkőzés</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <label class="form-label" for="What">Csomag kiválasztása*</label>
                        <select name="What" id="What" class="form-select">
                            <option value="Hidegcsomag">Hidegcsomag</option>
                            <option value="Rántotthúsos szendvics">Rántotthúsos szendvics</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <label for="loc" class="form-label">Helyszín*</label>
                        <input type="text" class="form-control" placeholder="Mérkőzés helyszíne" id="loc" name="Where"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">E-mail beszállító*</label>
                        <input type="email" name="Email" value="roli96@t-online.hu" class="form-control" id="email1"
                            disabled>
                    </div>
                </div>
                <div class="row g-3 my-1">
                    <div class="col-md-6">
                        <label for="email2" class="form-label">2. E-mail</label>
                        <input type="email" name="Email2" value="mark.mako@mkcse.hu" class="form-control" id="email2">
                    </div>
                    <div class="col-md-6">
                        <label for="email3" class="form-label">3. E-mail</label>
                        <input type="email" name="Email3" class="form-control" id="email3">
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" name="addFood" class="btn btn-primary">Rögzítés</button>
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
                    <tr>
                        <td>1.</td>
                        <td>2022.10.10</td>
                        <td>Hétfő</td>
                        <td>13:00</td>
                        <td>Ifi</td>
                        <td>16</td>
                        <td>Hidegcsomag</td>
                        <td>Példa</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

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
        let _date = document.getElementById('Date').value;
        let days = ['Vasárnap', 'Hétfő', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat'];
        let actual = new Date(_date);
        document.getElementById('Day').value = days[actual.getDay()];
    }
</script>