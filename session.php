<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();

$con = mysqli_connect("localhost", "root", "", "hazi")
    or exit("Nem sikerült csatlakozni az adatbázishoz.");

if (isset($_SESSION["user"]))
    $username = $_SESSION["user"];
else if ($_SERVER['PHP_SELF'] !== "/hazi/login.php")
    header("Location:login.php");

if (isset($_SESSION["password"]))
    $password = $_SESSION["password"];

if (isset($_SESSION["admin"]))
    $admin = $_SESSION["admin"];

if (isset($_GET["filmcim"]))
    $filmcim = $_GET["filmcim"];

if (isset($_POST["kereses"]))
    $kereses = $_POST["kereses"];

if (isset($_GET["szinesznev"]))
    $szinesznev = $_GET["szinesznev"];

if (isset($_POST["szineszek"]))
    $szineszek = $_POST["szineszek"];

if (isset($_POST["user_edit"]))
    $user_edit = $_POST["user_edit"];

if (isset($_POST["pass_edit"]))
    $pass_edit = $_POST["pass_edit"];

if (isset($_POST["newusername"]))
    $newusername = $_POST["newusername"];

if (isset($_POST["old_pass"]))
    $old_pass = $_POST["old_pass"];

if (isset($_POST["new_pass"]))
    $new_pass = $_POST["new_pass"];

if (isset($_POST["filmjeim"]))
    $filmjeim = $_POST["filmjeim"];

if (isset($_POST["osszes_film"]))
    $osszes_film = $_POST["osszes_film"];

if (isset($_POST["kijelentkezes"]))
    $kijelentkezes = $_POST["kijelentkezes"];

if (isset($_POST["felhasznalok"]))
    $felhasznalok = $_POST["felhasznalok"];

if (isset($_POST["uj_felhasznalo"]))
    $uj_felhasznalo = $_POST["uj_felhasznalo"];

if (isset($_POST["uj_felhasznalo_felhasznalonev"]))
    $uj_felhasznalo_felhasznalonev = $_POST["uj_felhasznalo_felhasznalonev"];

if (isset($_POST["uj_felhasznalo_emailcim"]))
    $uj_felhasznalo_emailcim = $_POST["uj_felhasznalo_emailcim"];

if (isset($_POST["uj_felhasznalo_jelszo"]))
    $uj_felhasznalo_jelszo = $_POST["uj_felhasznalo_jelszo"];

if (isset($_POST["felhasznalo_torles"]))
    $felhasznalo_torles = $_POST["felhasznalo_torles"];

if (isset($_POST["felhasznalo_torles_felhasznalonev"]))
    $felhasznalo_torles_felhasznalonev = $_POST["felhasznalo_torles_felhasznalonev"];

if (isset($_POST["uj_szinesz"]))
    $uj_szinesz = $_POST["uj_szinesz"];

if (isset($_POST["uj_szinesz_nev"]))
    $uj_szinesz_nev = $_POST["uj_szinesz_nev"];

if (isset($_POST["uj_szinesz_kor"]))
    $uj_szinesz_kor = $_POST["uj_szinesz_kor"];

if (isset($_POST["uj_szinesz_nem"]))
    $uj_szinesz_nem = $_POST["uj_szinesz_nem"];

if (isset($_POST["uj_szinesz_szerepel"]))
    $uj_szinesz_szerepel = $_POST["uj_szinesz_szerepel"];

if (isset($_POST["szinesz_torles"]))
    $szinesz_torles = $_POST["szinesz_torles"];

if (isset($_POST["szinesz_torles_nev"]))
    $szinesz_torles_nev = $_POST["szinesz_torles_nev"];

if (isset($_POST["szinesz_modositas"]))
    $szinesz_modositas = $_POST["szinesz_modositas"];

if (isset($_GET["szinesz_modositas_kit"]))
    $szinesz_modositas_kit = $_GET["szinesz_modositas_kit"];

if (isset($_POST["szinesz_modositas_nev"]))
    $szinesz_modositas_nev = $_POST["szinesz_modositas_nev"];

if (isset($_POST["szinesz_modositas_kor"]))
    $szinesz_modositas_kor = $_POST["szinesz_modositas_kor"];

if (isset($_POST["szinesz_modositas_nem"]))
    $szinesz_modositas_nem = $_POST["szinesz_modositas_nem"];

if (isset($_POST["szinesz_modositas_clicked"]))
    $szinesz_modositas_clicked = $_POST["szinesz_modositas_clicked"];

if (isset($_POST["filmek"]))
    $filmek = $_POST["filmek"];

if (isset($_POST["uj_film"]))
    $uj_film = $_POST["uj_film"];

if (isset($_POST["uj_film_cim"]))
    $uj_film_cim = $_POST["uj_film_cim"];

if (isset($_POST["uj_film_hossz"]))
    $uj_film_hossz = $_POST["uj_film_hossz"];

if (isset($_POST["uj_film_rendezo"]))
    $uj_film_rendezo = $_POST["uj_film_rendezo"];

if (isset($_POST["uj_film_mufaj"]))
    $uj_film_mufaj = $_POST["uj_film_mufaj"];

if (isset($_POST["uj_film_clicked"]))
    $uj_film_clicked = $_POST["uj_film_clicked"];

if (isset($_POST["film_torles"]))
    $film_torles = $_POST["film_torles"];

if (isset($_POST["film_torles_cim"]))
    $film_torles_cim = $_POST["film_torles_cim"];

if (isset($_POST["film_modositas"]))
    $film_modositas = $_POST["film_modositas"];

if (isset($_GET["film_modositas_melyiket"]))
    $film_modositas_melyiket = $_GET["film_modositas_melyiket"];

if (isset($_POST["film_modositas_cim"]))
    $film_modositas_cim = $_POST["film_modositas_cim"];

if (isset($_POST["film_modositas_hossz"]))
    $film_modositas_hossz = $_POST["film_modositas_hossz"];

if (isset($_POST["film_modositas_rendezo"]))
    $film_modositas_rendezo = $_POST["film_modositas_rendezo"];

if (isset($_POST["film_modositas_mufaj"]))
    $film_modositas_mufaj = $_POST["film_modositas_mufaj"];

if (isset($_POST["film_modositas_clicked"]))
    $film_modositas_clicked = $_POST["film_modositas_clicked"];

if (isset($_POST["szereples_hozzaadas"]))
    $szereples_hozzaadas = $_POST["szereples_hozzaadas"];

if (isset($_GET["szereples_hozzaadas_filmcim"]))
    $szereples_hozzaadas_filmcim = $_GET["szereples_hozzaadas_filmcim"];

if (isset($_POST["szereples_hozzaadas_szineszek_tomb"]))
    $szereples_hozzaadas_szineszek_tomb = $_POST["szereples_hozzaadas_szineszek_tomb"];

if (isset($_GET["added_actors"]))
    $added_actors = $_GET["added_actors"];

if (isset($_POST["szereples_torlese"]))
    $szereples_torlese = $_POST["szereples_torlese"];

if (isset($_GET["szereples_torles_filmcim"]))
    $szereples_torles_filmcim = $_GET["szereples_torles_filmcim"];

if (isset($_POST["szereples_torles_szineszek_tomb"]))
    $szereples_torles_szineszek_tomb = $_POST["szereples_torles_szineszek_tomb"];

if (isset($_GET["deleted_actors"]))
    $deleted_actors = $_GET["deleted_actors"];

if (isset($_POST["css"]))
    $css = $_SESSION["css"] = $_POST["css"];

if (isset($_SESSION["css"]))
    $css = $_SESSION["css"];

if (isset($_POST["film_vasarlas"]))
    $film_vasarlas = $_POST["film_vasarlas"];

if (isset($_POST["user_film_vasarlas_tomb"]))
    $user_film_vasarlas_tomb = $_POST["user_film_vasarlas_tomb"];

if (isset($_GET["added_movies"]))
    $added_movies = $_GET["added_movies"];

if (isset($_POST["rendezok"]))
    $rendezok = $_POST["rendezok"];

if (isset($_POST["uj_rendezo"]))
    $uj_rendezo = $_POST["uj_rendezo"];

if (isset($_POST["uj_rendezo_nev"]))
    $uj_rendezo_nev = $_POST["uj_rendezo_nev"];

if (isset($_POST["rendezo_torles"]))
    $rendezo_torles = $_POST["rendezo_torles"];

if (isset($_POST["rendezo_torles_nev"]))
    $rendezo_torles_nev = $_POST["rendezo_torles_nev"];

if (isset($_POST["rendezo_modositas"]))
    $rendezo_modositas = $_POST["rendezo_modositas"];

if (isset($_GET["rendezo_modositas_kit"]))
    $rendezo_modositas_kit = $_GET["rendezo_modositas_kit"];

if (isset($_POST["rendezo_modositas_kire"]))
    $rendezo_modositas_kire = $_POST["rendezo_modositas_kire"];

if (isset($_POST["kijelentkezes"]))
    $kijelentkezes = $_POST["kijelentkezes"];
