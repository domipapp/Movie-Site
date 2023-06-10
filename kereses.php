<?php include 'session.php';
if (!isset($_SESSION["user"]))
    header("Location:login.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <meta charset="utf-8">
    <?php
    if (!$admin)
        $site = 'user.php';
    else
        $site = 'admin.php';

    if (isset($css)) {
        if ($css == "bezs_css")
            echo '<link rel="stylesheet" href="bezs.css">';
        if ($css == "piros_css")
            echo '<link rel="stylesheet" href="piros.css">';
        if ($css == "lila_css")
            echo '<link rel="stylesheet" href="lila.css">';
    }
    ?>



    <?php include 'user_menu.php'; ?>
</head>

<body>
    <div class="torzs">
        <h2>Találatok</h2>
        <?php

        $hit = false;
        //szinesz nevre keresett ra?
        $query_szinesz_nev = "select nev, kor, nem from szinesz where szinesz.nev like" . "'%$kereses%'" . "or szinesz.kor like" .
            "'%$kereses%'" . " or szinesz.nem like" . "'%$kereses%'" . ";";
        $res = $con->query($query_szinesz_nev);
        if (!empty($res)) {
            echo '
                <table id="szinesz_table">
                <thead> 
                    <tr>
                        <th>Név</th>
                        <th>Kor</th>
                        <th>Nem</th>
                    </tr>
                </thead>';
            while ($row = mysqli_fetch_row($res))
                echo '<tr><td><a href = "' . $site . '?szinesznev=' . $row[0] . '"' .
                    'title = "Szinesz adatok megtekintése"/>' . $row[0] . "</td><td>" . "$row[1]" .
                    "</td><td>" . "$row[2]" . "</td></tr>";
            echo '</table>';
            $hit = true;
        }

        //filmre keresett ra?
        $queryfilm = "select cim from film where cim like " . "'%$kereses%'" . ";";
        $res = $con->query($queryfilm);
        if (!empty($res)) {
            echo '<table id="szinesz_table">';
            while ($row = mysqli_fetch_row($res)) {
                if (empty($row)) break;
                $hit = true; //talalt
                echo '<tr><a href = "' . $site . '?filmcim=' . $row[0] . '"' .
                    'title = "Film adatok megtekintése"/>' . $row[0] . "</tr><br>";
            }
            echo '</table>';
        }
        //mufajra keresett ra?
        $querymufaj = "select cim, mufaj from film where mufaj like " . "'%$kereses%'" . ";";
        $res = $con->query($querymufaj);
        if (!empty($res)) {
            echo '<table id="film_table">';
            echo '
            <thead> 
                    <tr>
                        <th>Film cím</th>
                        <th>Műfaj</th>
                    </tr>
                </thead>';
            while ($row = mysqli_fetch_row($res)) {
                $hit = true; //talalt
                echo '<tr><td><a href = "' . $site . '?filmcim=' . $row[0] . '"' .
                    'title = "Film adatok megtekintése"/>' . $row[0] . "</td>  <td>" . $row[1] . "</td></tr>";
            }
            echo '</table>';
        }
        if (!$hit)
            echo "A '" . $kereses . "' keresésre nincs megfelelő találat. Próbálja újra!<br>";
        ?>

    </div>


</body>
<?php include "footer.php"; ?>

</html>