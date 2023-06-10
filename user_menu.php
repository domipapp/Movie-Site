<div class="user_menu">
    <h2 class="udv">Üdvözlünk <?php echo "$username"; ?>!</h2>
    <form action="user.php" method="post">
        <input class="user_menu_gomb" type="submit" name="user_edit" value="Felhasználónév módosítás" />
        <input class="user_menu_gomb" type="submit" name="pass_edit" value="Jelszó módosítas" />
        <input class="user_menu_gomb" type="submit" name="filmjeim" value="Filmjeim" />
        <input class="user_menu_gomb" type="submit" name="osszes_film" value="Elérhető filmek" />
        <input class="user_menu_gomb" type="submit" name="film_vasarlas" value="Film vásárlás" />
        <input class="user_menu_gomb" type="submit" name="kijelentkezes" value="Kijelentkezés" />
    </form>
    <form action="kereses.php" method="post">
        <input type="text" name="kereses" value="Keresés" />
    </form>
</div>