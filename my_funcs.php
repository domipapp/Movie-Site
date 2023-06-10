<?php

function new_actor_valid_inputs($age, $sex, $title)
{
    $valid = true;
    if (!is_numeric($age)) {
        echo "Kérem számot adjon meg kornak!<br>";
        $valid = false;
    }
    $sex = strtoupper($sex);
    if ($sex !== "M" && $sex !== "F") {
        echo "Érvénytelen nem!<br>";
        $valid = false;
    }
    if (!valid_movie_title($title)) {
        echo "Nincs ilyen című film az adatbázisban!<br>";
        $valid = false;
    }
    return $valid;
}


function isValidLength(string $date, string $format = 'H:i:s'): bool
{
    $dateObj = DateTime::createFromFormat($format, $date);
    return $dateObj && $dateObj->format($format) == $date;
}

function new_movie_valid_inputs($length, $director, $genre)
{
    $valid = true;
    if (!isValidLength($length)) {
        echo "Hibás hossz formátum!<br>";
        $valid = false;
    }

    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select * from rendezo where nev = '$director'";
    $res = $con->query($query);
    if (mysqli_num_rows($res) == 0) {
        $valid = false;
        echo 'Nincs ilyen nevű rendező az adatbázisban!<br>';
    }

    if (preg_match('~[0-9]+~', $genre)) {
        echo 'Kérem ne használjon számot a műfaj megadásakor!<br>';
        $valid = false;
    }
    return $valid;
}


function valid_movie_title($title)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select * from film where cim = '" . $title . "'";
    $res = $con->query($query);
    if (mysqli_fetch_row($res))
        return true;
    else
        return false;
}

function valid_username($username)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select * from  felhasznalo where felhasznalo.felhasznalonev = '" . $username . "';";
    $res = $con->query($query);
    if (mysqli_fetch_row($res))
        return true;
    else
        return false;
}

function add_actors_checkbox($title)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select szinesz.nev from szinesz where szinesz.nev not in(select szinesz.nev from szerepel
            join szinesz on szerepel.idszinesz = szinesz.idszinesz
            join film on szerepel.idfilm = film.idfilm
            join rendezo on rendezo.idrendezo = film.idrendezo
            where film.cim = '$title') order by szinesz.nev ASC;";
    $res = $con->query($query);
    echo 'Válassza ki, kiket szeretne hozzárendelni<br>
        <form action="" method="post">';
    while ($row = mysqli_fetch_row($res))
        echo $row[0] . '<input type="checkbox" name="szereples_hozzaadas_szineszek_tomb[]" value="' . $row[0] . '"><br>';
    echo '<input class="gomb" type = "submit" value = "Hozzáadás">
        </form>';
}

function add_actors_to_movie($actors, $title)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $count = 0;
    foreach ($actors as $actor) {
        $query = "insert into szerepel values((select idfilm from film where cim = '$title'),
    (select idszinesz from szinesz where nev = '$actor'));";
        $res = $con->query($query);
        $count++;
    }
    unset($actor);
    return $count;
}

function delete_actors_checkbox($title)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select szinesz.nev from szerepel
            join szinesz on szerepel.idszinesz = szinesz.idszinesz
            join film on szerepel.idfilm = film.idfilm
            join rendezo on rendezo.idrendezo = film.idrendezo
            where film.cim = '$title' order by szinesz.nev ASC;";
    $res = $con->query($query);
    echo 'Válassza ki, kiket szeretne törölni<br>
        <form action="" method="post">';
    while ($row = mysqli_fetch_row($res))
        echo $row[0] . '<input type="checkbox" name="szereples_torles_szineszek_tomb[]" value="' . $row[0] . '"><br>';
    echo '<input class="gomb" type = "submit" value = "Törlés">
        </form>';
}

function delete_actors_from_movie($actors, $title)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $count = 0;
    foreach ($actors as $actor) {
        $query = "delete from szerepel where szerepel.idszinesz = (select szinesz.idszinesz from szinesz
            where szinesz.nev = '$actor') and szerepel.idfilm =(select film.idfilm from film
            where film.cim = '$title') ;";
        $res = $con->query($query);
        $count++;
    }
    unset($actor);
    return $count;
}

function user_movies_checkbox($username)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select film.cim from film where film.cim not in(select film.cim from felhasznalo
            join film on felhasznalo.idfilm = film.idfilm
            where felhasznalo.felhasznalonev = '$username');";
    $res = $con->query($query);
    echo 'Válassza ki, melyeket szeretné megvásárolni<br>
        <form action="" method="post">';
    while ($row = mysqli_fetch_row($res))
        echo $row[0] . '<input type="checkbox" name="user_film_vasarlas_tomb[]" value="' . $row[0] . '"><br>';
    echo '<input class="gomb" type = "submit" value = "Vásárlás">
        </form>';
}

function add_movies_to_user($username, $movies)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $count = 0;
    $query = "select  emailcim, jelszo from felhasznalo where felhasznalonev = '$username'";
    $res = $con->query($query);
    $res = mysqli_fetch_row($res);
    $email = $res[0];
    $password = $res[1];
    foreach ($movies as $movie) {
        $query = "insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin)
         values('$username', '$email', '$password',  (select idfilm from film where cim = '$movie'), false);";
        $res = $con->query($query);
        $count++;
    }
    unset($movie);
    return $count;
}

function valid_director_name($name)
{
    $con = mysqli_connect("localhost", "root", "", "hazi")
        or exit("Nem sikerült csatlakozni az adatbázishoz.");
    $query = "select  * from rendezo where nev = '$name'";
    $res = $con->query($query);
    if (mysqli_fetch_row($res))
        return true;
    return false;
}
?><?php ?>