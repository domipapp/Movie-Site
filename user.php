<?php
include 'session.php';
include "my_funcs.php";
if (!isset($_SESSION["user"]))
    header("Location:login.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <meta charset="utf-8">
    <?php
    if (isset($css)) {
        if ($css == "bezs_css")
            echo '<link rel="stylesheet" href="bezs.css">';
        if ($css == "piros_css")
            echo '<link rel="stylesheet" href="piros.css">';
        if ($css == "lila_css")
            echo '<link rel="stylesheet" href="lila.css">';
    }
    ?>
    <!--Fejléc-->

    <?php include 'user_menu.php'; ?>
</head>

<body>

    <div class="torzs">

        <!--Felhasznalonev modositas-->
        <?php
        if (isset($user_edit))
            include "formok/user_uj_felhasznalonev_form.html";
        //felhasználó begépelt valamit
        if (isset($newusername)) {
            //db parancs
            $query = "update felhasznalo set felhasznalonev = '$newusername' where felhasznalonev = '$username';";
            //session változók frissítése
            $_SESSION["user"] = $newusername;
            $res = $con->query($query);
            header("Refresh:0");
        }
        ?>

        <!--Jelszó modositas-->
        <?php

        if (isset($pass_edit)) {
            //új jelszó form
            include "formok/jelszo_modositas_form.html";
        }
        //felhasználó begépelt valamit
        if (isset($old_pass) and isset($new_pass)) {
            if (empty($old_pass) or empty($new_pass)) {
                echo 'Kérem töltsön ki minden mezőt!';
                include "formok/jelszo_modositas_form.html";
            } else
            if (md5($old_pass) == $password) { //helyes régi jelszóse
                //lekérdezés
                $new_pass = md5($new_pass);
                $query = "update felhasznalo set jelszo = '$new_pass' where jelszo = '$password'
                        and felhasznalonev = '$username';";
                $_SESSION["password"] = $new_pass; //session változó frissítése
                $res = $con->query($query);
                echo "Sikeres módosítás!";
                include "formok/jelszo_modositas_form.html";
            } else {
                //nem egyezik a begépelt jelszó a jelenlegi jelszóval, újrapróbálkozás
                echo 'A régi jelszó nem egyezik a begépelt jelszóval, próbálja újra!';
                include "formok/jelszo_modositas_form.html";
            }
        }
        ?>


        <!--Filmjeim kilistazasa-->
        <?php
        if (isset($filmjeim)) {
            //lekérdezés
            $query = "select film.cim from felhasznalo 
                    join film on felhasznalo.idfilm = film.idfilm
                    where felhasznalonev = '$username'
                    order by film.cim ASC;";
            $res = $con->query($query);
            //kiírás
            //a filmek linket kapnak amelyre rákattintva meg lehet tekinteni az adott film adatait
            while ($row = mysqli_fetch_row($res)) {
                echo '<tr><a href = "user.php?filmcim=' . $row[0] . '"' .
                    'title = "Film adatok megtekintése"/>' . $row[0] . "</tr><br>";
            }
        }
        ?>


        <!--Osszes film kilistazasa-->
        <?php
        if (isset($osszes_film)) {
            //lekérdezés
            $query = "select film.cim from film order by film.cim ASC;";
            $res = $con->query($query);
            //kiírás
            //a filmek linket kapnak amelyre rákattintva meg lehet tekinteni az adott film adatait
            while ($row = mysqli_fetch_row($res)) {
                echo '<tr><a href = "user.php?filmcim=' . $row[0] . '"' .
                    'title = "Film adatok megtekintése"/>' . $row[0] . "</tr><br>";
            }
        }

        ?>
        <!--Filmcím alapján kilistássa a filmeket-->
        <?php
        if (isset($filmcim))
            include "film_adat_listazas.php";
        ?>

        <!--Színész név alapján kilistássa a színészeket-->
        <?php
        if (isset($szinesznev))
            include "szinesz_adat_listazas.php";
        ?>

        <!--Film vásárlás-->
        <?php
        if (isset($film_vasarlas))
            user_movies_checkbox($username);
        if (isset($added_movies)) {
            if ($added_movies == 1)
                echo "Film megvásárolva!";
            if ($added_movies > 1)
                echo "Filmek megvásárolva!";
        }

        if (isset($user_film_vasarlas_tomb)) {
            $added_movies = add_movies_to_user($username, $user_film_vasarlas_tomb);
            header("Location: user.php?added_movies=$added_movies");
        }

        ?>



        <!--Kijelentkezés-->
        <?php
        if (isset($kijelentkezes)) {
            session_destroy();
            header("Location: login.php");
        }

        ?>
    </div>
</body>
<?php include "footer.php" ?>

</html>