<?php
include 'session.php';
include 'my_funcs.php';
//csak bejelentkezés után lehet használni
if (!isset($_SESSION["user"]))
    header("Location:login.php");
//mezei felhasználó 
if (!$admin)
    header("Location:user.php");
?>
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
</head>


<body>
    <div class="udvozles">
        <?php include "admin_menu.php"; ?>
    </div>

    <div class="torzs">
        <!--Felhasználók kilistázása-->
        <?php
        if (isset($felhasznalok)) {
            //tábla eleje stílussal
            echo 'Felhasználók
                <table id = "felhasz_table" >
                    <thead>
                        <tr>
                        <th>Felhasználónév</th>
                        <th>Email cím</th>
                        <th>jelszó</th>
                        </tr>
                    </thead>';
            //táblába kilistázza az összes felhasználót az adatbázisból
            $query = "select felhasznalo.felhasznalonev, felhasznalo.emailcim, felhasznalo.jelszo
                    from felhasznalo group by felhasznalo.felhasznalonev order by felhasznalo.felhasznalonev ASC";
            $res = $con->query($query);
            while ($row = mysqli_fetch_row($res)) {
                echo '      <tr>
                            <td>' . $row[0] . '</td>
                            <td>' . $row[1] . '</td>
                            <td>' . $row[2] . '</td>
                            </tr>';
            };
            echo '</table>';
        }

        ?>

        <!--Új felhasználó létrehozása-->
        <?php
        if (isset($uj_felhasznalo)) {
            //új felhasználó form
            include "formok/uj_felhasznalo_form.html";
        }
        //Minden mezőbe be lett bépelve valami
        if (isset($uj_felhasznalo_felhasznalonev) && isset($uj_felhasznalo_emailcim) && isset($uj_felhasznalo_jelszo)) {
            //új jelszó md5 titkosítva
            $query = "insert into felhasznalo(felhasznalonev, emailcim, jelszo,  admin)
                values('" . $uj_felhasznalo_felhasznalonev . "', '" . $uj_felhasznalo_emailcim . "', 
                '" . md5($uj_felhasznalo_jelszo) . "',  false);";
            $res = $con->query($query);
            echo "Új felhasználó létrehozva!";
        }
        ?>

        <!--Felhasználó törlése-->
        <?php
        if (isset($felhasznalo_torles)) {
            //felhasználó törlés form
            include "formok/felhasznalo_torles_form.html";
        }
        if (isset($felhasznalo_torles_felhasznalonev)) {
            //ha van ilyen nevű felhasználó az adatbázisban
            if (valid_username($felhasznalo_torles_felhasznalonev)) {
                $query = "delete from  felhasznalo where felhasznalo.felhasznalonev = '" . $felhasznalo_torles_felhasznalonev . "';";
                $res = $con->query($query);
                echo "Felhasználó törölve!";
            } else { //nincs ilyen felhasználó, újra próbálkozás
                echo "Nincs ilyen nevű felhasználó!";
                include "formok/felhasznalo_torles_form.html";
            }
        }
        ?>

        <!--Színészek kilistázása-->
        <?php
        if (isset($szineszek)) {
            //tábla eleje stílussal
            echo '
                
                <table id="szinesz_table">
                    <thead>
                        <tr>
                            <th>Név</th>
                            <th>Kor</th>    
                            <th>Nem</th>
                        </tr>   
                    </thead>';

            $query = "select szinesz.nev, szinesz.kor, szinesz.nem from szinesz order by szinesz.nev ASC";
            $res = $con->query($query);
            while ($row = mysqli_fetch_row($res)) {
                //a színész neve egy link, amelyre kattintva megtekinthetőek az adatai(milyen filmben szerepel etc.)
                echo '  <tr>
                        <td><a href = "admin.php?szinesznev=' . $row[0] . '"' . 'title = "Szinesz adatok megtekintése"/>' . $row[0] . '</td>
                        <td>' . $row[1] . '</td>
                        <td>' . $row[2] . '</td>
                        </tr>';
            };
            echo '</table>';
        }
        ?>

        <!--Színész név alapján kilistássa a színészek adatait-->
        <?php
        //színésznév linkre kattintva ez dolgozódik fel
        if (isset($szinesznev))
            include "szinesz_adat_listazas.php";
        ?>

        <!--új színész létrhozása-->
        <?php
        if (isset($uj_szinesz)) {
            //új színész form
            include "formok/uj_szinesz_form.html";
        }
        //ha minden mezőbe került valami
        if (isset($uj_szinesz_nev) && isset($uj_szinesz_kor) && isset($uj_szinesz_nem) && isset($uj_szinesz_szerepel)) {
            $uj_szinesz_nem = strtoupper($uj_szinesz_nem); //nagybetűvel tároljuk az nemet az adatbázisban
            if (new_actor_valid_inputs($uj_szinesz_kor, $uj_szinesz_nem, $uj_szinesz_szerepel)) { //minden bemenet érvényes
                //színész létrehozása
                $query1 = "insert into szinesz(nev, kor, nem)
                values('" . $uj_szinesz_nev . "', '" . $uj_szinesz_kor . "', '" . $uj_szinesz_nem . "');";
                //szereplés létrehozása
                $query2 = "insert into szerepel values((select idfilm from film where cim = '" . $uj_szinesz_szerepel . "'),
                (select idszinesz from szinesz where nev = '" . $uj_szinesz_nev . "'));";
                $res = $con->query($query1);
                $res = $con->query($query2);
                echo "Új színész létrehozva!";
            } else
                include "formok/uj_szinesz_form.html"; //valamelyik bemenet nem volt megfelelő
        }
        ?>

        <!--Színész törlése-->
        <?php
        if (isset($szinesz_torles)) {
            //színész törlés form
            include "formok/szinesz_torles_form.html";
        }
        if (isset($szinesz_torles_nev)) {
            $query = "select * from szinesz where nev = '" . $szinesz_torles_nev . "'";
            $res = $con->query($query);
            if (mysqli_fetch_row($res)) { //van-e ilyen nevű színész az adatbázisban
                //elsőnek szereplések törlése
                $query1 = "delete from  szerepel where szerepel.idszinesz in (select idszinesz from szinesz where nev = '" . $szinesz_torles_nev . "');";
                //színész törlése
                $query2 = "delete from  szinesz where szinesz.nev = '" . $szinesz_torles_nev . "';";
                $res = $con->query($query1);
                $res = $con->query($query2);
                echo "Színész törölve!";
            } else {
                echo 'Nincs ilyen nevű színész!';
                include "formok/szinesz_torles_form.html";
            }
        }
        ?>

        <!--Színész módosítása-->
        <?php
        if (isset($szinesz_modositas))
            //színész módosítás form
            include "formok/szinesz_modositas_kit_form.html";
        if (isset($szinesz_modositas_kit)) {
            //érvényes-e a név
            $query = "select kor, nem from szinesz where nev = '" . $szinesz_modositas_kit . "'";
            $res = $con->query($query);
            if ($res = mysqli_fetch_row($res)) //érvényes név
                include "formok/szinesz_modositas_form.html"; //új adatok
            else {
                echo 'Nincs ilyen nevű színész!';
                include "formok/szinesz_modositas_kit_form.html";
            }
        }
        if (isset($szinesz_modositas_clicked)) { //form elküldve
            //név szerint eredeti adatok elérése
            $query = "select kor, nem from szinesz where nev = '" . $szinesz_modositas_kit . "'";
            $res = $con->query($query);
            $res = mysqli_fetch_row($res);
            //amelyik adatot nem adta meg a felhasználó, az marad a régi
            //szinesz_modositas_kit-->regi nev
            if (empty($szinesz_modositas_nev))
                $szinesz_modositas_nev = $szinesz_modositas_kit;
            if (empty($szinesz_modositas_kor))
                $szinesz_modositas_kor = $res[0];
            if (empty($szinesz_modositas_nem))
                $szinesz_modositas_nem = $res[1];
            //módosítás
            $query = "update szinesz set nev = '" . $szinesz_modositas_nev . "', kor = " . $szinesz_modositas_kor . ", 
            nem ='" . $szinesz_modositas_nem . "' where nev = '" . $szinesz_modositas_kit . "';";
            $res = $con->query($query);
            echo 'Sikeres módosítás!';
        }
        ?>

        <!--Osszes film kilistazasa-->
        <?php
        if (isset($filmek)) {
            $query = "select film.cim from film order by film.cim ASC;";
            $res = $con->query($query);
            while ($row = mysqli_fetch_row($res)) //get kérés film címmel, film_adat_lisazas.php dolgozza fel
                echo '<tr><a href = "admin.php?filmcim=' . $row[0] . '"' . 'title = "Film adatok megtekintése"/>' . $row[0] . "</tr><br>";
        }
        ?>

        <!--Filmcím alapján kilistázza a film adatait-->
        <?php
        if (isset($filmcim)) //filmcímre kattitás itt dolgozódik fel
            include "film_adat_listazas.php";
        ?>

        <!--Új film létrehozása-->
        <?php
        if (isset($uj_film)) //új film form
            include 'formok/uj_film_form.html';
        if (isset($uj_film_clicked)) { //form el lett küldve
            if (new_movie_valid_inputs($uj_film_hossz, $uj_film_rendezo, $uj_film_mufaj)) { //minden bemenet érvényes
                //beszúrás
                $query = "insert into film(cim, hossz, idrendezo, mufaj) values('$uj_film_cim', '$uj_film_hossz',
                            (select idrendezo from rendezo where nev = '$uj_film_rendezo'), '$uj_film_mufaj');";
                $res = $con->query($query);
                echo 'Új film létrehozva';
            } else //valamelyik bemenet nem volt érvényes
                include 'formok/uj_film_form.html';
        }
        ?>

        <!--Film törlése-->
        <?php
        if (isset($film_torles)) //film törlése form
            include "formok/film_torles_form.html";
        if (isset($film_torles_cim)) { //form elküldve
            if (valid_movie_title($film_torles_cim)) { //van ilyen film az adatbázisban
                //filmhez kapcsolódó szereplések törlése
                $query1 = "delete from szerepel where idfilm in (select idfilm from film where cim = '$film_torles_cim') ;";
                //film törlése
                $query2 = "delete from film where cim = '$film_torles_cim';";
                $res = $con->query($query1);
                $res = $con->query($query2);
                echo 'Film törölve';
            } else {
                echo "Nincs ilyen című film!";
                include "formok/film_torles_form.html";
            }
        }
        ?>

        <!--Film módosítása-->
        <?php
        if (isset($film_modositas)) //film módosítás form
            include "formok/film_modositas_filmcim_form.html";
        if (isset($film_modositas_melyiket)) { //form elküldve
            if (valid_movie_title(($film_modositas_melyiket))) //érvényes cím
                include "formok/film_modositas_form.html";
            else {
                echo 'Nincs ilyen című film!';
                include "formok/film_modositas_filmcim_form.html";
            }
        }
        if (isset($film_modositas_clicked)) { //film módosítására vonatkozó adatok elküldve
            $query = "select cim, hossz, rendezo.nev, mufaj from film
                    join rendezo on film.idrendezo = film.idrendezo where cim = '" . $film_modositas_melyiket . "'";
            $res = $con->query($query);
            $res = mysqli_fetch_row($res);
            //csak azt adja meg a felhasználó amit módosítani szeretne, ha ne m adtott meg semmit a régi adat marad
            if (empty($film_modositas_cim))
                $film_modositas_cim = $res[0];
            if (empty($film_modositas_hossz))
                $film_modositas_hossz = $res[1];
            if (empty($film_modositas_rendezo))
                $film_modositas_rendezo = $res[2];
            if (empty($film_modositas_mufaj))
                $film_modositas_mufaj = $res[3];
            //érvényesek a bemenetek
            if (new_movie_valid_inputs($film_modositas_hossz, $film_modositas_rendezo, $film_modositas_mufaj)) {
                $query = "update film set cim = '" . $film_modositas_cim . "', hossz = '" . $film_modositas_hossz . "', 
            idrendezo =(select idrendezo from rendezo where nev = '$film_modositas_rendezo'),
            mufaj = '$film_modositas_mufaj' where cim = '" . $film_modositas_melyiket . "';";
                $res = $con->query($query);
                echo 'Sikeres módosítás!';
            }
        }
        ?>

        <!--Szereplések hozzárendelése filmhez-->
        <?php
        if (isset($szereples_hozzaadas)) //szereplés hozzáadás, melyik filmhez form
            include "formok/szereples_hozzaadas_filmcim_form.html";
        if (isset($szereples_hozzaadas_filmcim)) {
            if (valid_movie_title(($szereples_hozzaadas_filmcim))) { //érvényes név
                add_actors_checkbox($szereples_hozzaadas_filmcim); //filmben nem szereplő színészek checkboxos kilistázása
            } else {
                echo 'Nincs ilyen című film!';
                include "formok/szereples_hozzaadas_filmcim_form.html";
            }
        }
        //checkbox visszatér a $szereples_hozzaadas_szineszek_tomb-el
        if (isset($szereples_hozzaadas_szineszek_tomb, $szereples_hozzaadas_filmcim)) {
            $added_actors = add_actors_to_movie($szereples_hozzaadas_szineszek_tomb, $szereples_hozzaadas_filmcim); //színészek hozzáadása
            if ($added_actors == 1) //add_actors_to_movie visszatérési értéke, hány színészt adott hozzá
                echo "Színész hozzáadva!";
            if ($added_actors > 1)
                echo "Színészek hozzáadva!";
        }
        ?>

        <!--Szereplés törlése-->
        <?php
        if (isset($szereples_torlese)) //szereplés törlése melyik filmből form
            include "formok/szereples_torles_filmcim_form.html";
        if (isset($szereples_torles_filmcim)) {
            if (valid_movie_title(($szereples_torles_filmcim))) { //érvényes cím
                delete_actors_checkbox($szereples_torles_filmcim); //a filmben szereplő színészeket checkboxxal kilistázza

            } else {
                echo 'Nincs ilyen című film!';
                include "formok/szereples_torles_filmcim_form.html";
            }
        }
        //a checkboxx $szereples_torles_szineszek_tomb tömbbel tér vissza
        if (isset($szereples_torles_szineszek_tomb, $szereples_torles_filmcim)) {
            $deleted_actors = delete_actors_from_movie($szereples_torles_szineszek_tomb, $szereples_torles_filmcim); //színészek törlése
            if ($deleted_actors == 1) //delete_actors_from_movie visszatérési értéke, ennyi színészt törölt
                echo "Színész törölve!";
            if ($deleted_actors > 1)
                echo "Színészek törölve!";
        }
        ?>

        <!--Rendezők kilistázása-->
        <?php
        if (isset($rendezok)) {
            $query = "select nev from rendezo order by nev asc;";
            $res = $con->query($query);
            while ($row = mysqli_fetch_row($res))
                echo $row[0] . '<br>';
        }
        ?>

        <!--Új rendező létrehozása-->
        <?php
        if (isset($uj_rendezo)) //új rendező form
            include "formok/uj_rendezo_form.html";
        if (isset($uj_rendezo_nev)) {
            //új rendező létrehozása
            $query = "insert into rendezo(nev) values('$uj_rendezo_nev');";
            $res = $con->query($query);
            echo 'Rendező létrehozva!';
        }
        ?>

        <!--Rendező törlése-->
        <?php
        if (isset($rendezo_torles)) //Rendező törlés form
            include "formok/rendezo_torles_form.html";
        if (isset($rendezo_torles_nev)) {
            //Rendező név validálása
            if (valid_director_name($rendezo_torles_nev)) {
                $query = "delete from rendezo where nev = '$rendezo_torles_nev';";
                $res = $con->query($query);
                echo 'Rendező törölve!';
            } else {
                echo 'Nincs ilyen nevű rendező!';
                include "formok/rendezo_torles_form.html";
            }
        }
        ?>

        <!--Rendező módosítása-->
        <?php
        if (isset($rendezo_modositas)) //rendező módosítás form
            include "formok/rendezo_modositas_kit_form.html";
        if (isset($rendezo_modositas_kit)) {
            //Rendező név validálása
            if (valid_director_name($rendezo_modositas_kit))
                include "formok/rendezo_modositas_kire_form.html";
            else {
                echo 'Nincs ilyen nevű rendező!';
                include "formok/rendezo_modositas_kit_form.html";
            }
        }
        if (isset($rendezo_modositas_kire)) {
            $query = "update rendezo set nev = '" . $rendezo_modositas_kire . "'
                     where nev = '" . $rendezo_modositas_kit . "';";
            $res = $con->query($query);
            echo 'Rendező módosítva!';
        }
        ?>

        <!--Kijelentkezés-->
        <?php
        if (isset($kijelentkezes)) {
            session_destroy(); //session törlése
            header("Location: login.php"); //vissza bejelentkező felületre
        }
        ?>

    </div>
</body>

<?php include "footer.php"; ?>

</html>