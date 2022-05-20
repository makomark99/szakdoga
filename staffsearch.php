<?php
    include_once 'includes\dbh.inc.php';

    $search=mysqli_real_escape_string($conn, $_POST['name']);
    $sql = "SELECT * FROM staff WHERE sName LIKE '%$search%'";
    $result=mysqli_query($conn, $sql);
    $queryResults=mysqli_num_rows($result);
    $th=1;
    if ($queryResults>0) {
        echo "<h3 class='mt-2'>A keresésnek $queryResults találata van!</h3>"
    ?>
<div class="container-fluid mt-4">
  <h1 class="text-center m-4">Munkatársak adatai</h1>

  <table class="table table-dark table-hover">
    <thead class="thead-light">
      <tr>
        <th>#</th>
        <th>Név</th>
        <th>Személy kód</th>
        <th>Belső E-mail</th>
        <th>E-mail</th>
        <th>Telefonszám</th>
        <th>Beosztás</th>
        <th>Műveletek</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row=mysqli_fetch_assoc($result)) {
        ?>
      <tr>
        <td class="align-middle"> <?php echo $th++; ?>
        </td>
        <td class="align-middle"> <?php echo $row['sName']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['sCode']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['sEmail']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['sEmail2']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['sTel']; ?>
        </td>
        <td class="align-middle"> <?php echo $row['sPost']; ?>
        </td>
        <td>
          <a href="" title="Szerkesztés" class="btn btn-outline-warning">
            <?php include 'img/pencil.svg' ?>
          </a>
          <a href="" title="Törlés" class="btn btn-outline-danger">
            <?php include 'img/trash.svg' ?>
          </a>
        </td>
      </tr>
      <?php
    }
    } else {
        echo "<h3 class='mt-2'>Nem található a megadott paramétereknek megfelelő személy</h3>";
    }
?>
    </tbody>
  </table>

</div>