<?php
session_unset();
include 'session.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Bejelentkezés</title>
    <meta charset="utf-8">
    <?php

    if (!isset($css))
        $css = $_SESSION["css"] = "bezs_css";

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

    <h1>Bejelentkezés</h1>

    <!--Bejelentkeztető form-->
    <form action="" method="post">
        <label for="email">E-mail cím:</label>
        <input id="email" name="email" type="text" /><br>
        <label for="jelszo">Jelszó:</label>
        <input id="jelszo" name="jelszo" type="password" /><br>
        <input class="gomb" type="submit" value="Belépés" /><br>
    </form>

    <?php
    if (isset($_POST["email"]) and isset($_POST["jelszo"])) { //felhasználó begépelt valamit
        //felhasználó adatai
        $email = $_POST["email"];
        $pass = md5($_POST["jelszo"]);
        //lekérdezés
        $query = "select jelszo, felhasznalonev, admin from felhasznalo where
                    emailcim = '$email' and jelszo = '$pass'";
        //egy felhasználó
        $res = $con->query($query);

        $valid = false;
        if (mysqli_num_rows($res) != 0) {
            $row = mysqli_fetch_row($res);

            $valid = true; //ha visszatér adattal a db azaz helyes adatok
            $_SESSION["password"] = $row[0]; //kesobb felhasznalhato a jelszo
            $_SESSION["user"] = $row[1]; //kesobb felhasznalhato a felhasznalonev
            $_SESSION["admin"] = $row[2]; // admin bool
        }
        //ha admin és van egyezés akkor admin felület
        if ($valid == true && $_SESSION["admin"] == TRUE)
            header("Location: admin.php");
        //nem admin és van egyezés felhasználói felület
        else if ($valid)
            header("Location: user.php");
        //nincs egyezés
        else
            echo "Sikertelen belépés, próbálja újra!";
    }
    ?>
</body>

</html>

<?php
//css váltó gomb
include "footer.php";
?>