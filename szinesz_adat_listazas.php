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
    <h2>Színész adatok</h2>
    <?php
    if (!$admin)
        $site = 'user.php';
    else
        $site = 'admin.php';
    ?>


    <!--Színész adatainak kilistazasa-->
    <?php

    $query = "select szinesz.nev, szinesz.kor, szinesz.nem, film.cim from szerepel
            join szinesz on szerepel.idszinesz = szinesz.idszinesz
            join film on szerepel.idfilm = film.idfilm
            where szinesz.nev = '$szinesznev'";
    $res = $con->query($query);
    $row = mysqli_fetch_row($res);
    echo $row[0] . '    ' .
        ', Kor:' . $row[1] . '    ' .
        ', Nem: ' . $row[2];
    ?>
    <table id="film_table">
        <thead>
            <tr>
                <th>Filmjei</th>
            </tr>
        </thead>
        <?php
        echo '<tr><td><a href = "' . $site . '?filmcim=' . $row[3] . '"' .
            'title = "Film adatok megtekintése"/>' . $row[3] . "</td></tr><br>";
        while ($row = mysqli_fetch_row($res)) {
            echo '<tr><td><a href = "' . $site . '?filmcim=' . $row[3] . '"' .
                'title = "Film adatok megtekintése"/>' . $row[3] . "</td></tr><br>";
        }
        ?>

        <?php
        if (isset($_POST["kijelentkezes"])) {
            session_destroy();
            header("Location: login.php");
        }

        ?>
</body>

</html>