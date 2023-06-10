<?php include 'session.php';
if (!isset($_SESSION["user"]))
    header("Location:login.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="skin.css">
</head>

<body>
    <h2>Film adatok</h2>
    <?php
    if (!$admin)
        $site = 'user.php';
    else
        $site = 'admin.php';
    ?>

    <!--Film adatainak kilistazasa-->
    <?php
    //lekérdezés
    /*$query = "select rendezo.nev, film.hossz, film.mufaj, szinesz.nev, szinesz.kor, szinesz.nem from szerepel
            join szinesz on szerepel.idszinesz = szinesz.idszinesz
            join film on szerepel.idfilm = film.idfilm
            join rendezo on rendezo.idrendezo = film.idrendezo
            where film.cim = '$filmcim'";*/
    $query = "select rendezo.nev, film.hossz, film.mufaj from film
            join rendezo on rendezo.idrendezo = film.idrendezo
            where film.cim = '$filmcim'";
    $res = $con->query($query);
    $row = mysqli_fetch_row($res);
    echo '<h3>' . $filmcim . '</h3>
         <h4>Rendezte: ' . $row[0] . '</h4>
         Hossz: ' . $row[1] . ', Műfaj: ' . $row[2] . '<br>';

    $query = "select szinesz.nev, szinesz.kor, szinesz.nem from szerepel
    join szinesz on szerepel.idszinesz = szinesz.idszinesz
    join film on szerepel.idfilm = film.idfilm
    where film.cim = '$filmcim'";
    $res = $con->query($query);
    if (mysqli_num_rows($res) != 0) {
        echo '<table id="szinesz_table">
        <thead>
            <tr>
                <th>Név</th>
                <th>Kor</th>
                <th>Nem</th>
            </tr>
        </thead>';

        while ($row = mysqli_fetch_row($res)) {
            echo '<tr><td><a href = "' . $site . '?szinesznev=' . $row[0] . '"' .
                'title = "Szinesz adatok megtekintése"/>' . $row[0] . "</td><td>" . "$row[1]" . "</td><td>" . "$row[2]" . "</td></tr>";
        }
    } else echo "Nem szerepel ebben a filmben egy színész sem!";
    ?>
</body>

</html>