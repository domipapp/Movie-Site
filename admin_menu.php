<div class="admin_menu">
    <h2 class="udv">Üdvözlünk <?php echo "$username"; ?>!</h2>
    <form action="admin.php" method="post" class="admin_menu">
        <input class="admin_menu_gomb" type="submit" name="felhasznalok" value="Felhasználók">
        <input class="admin_menu_gomb" type="submit" name="uj_felhasznalo" value="Új felhasználó létrehozása" />
        <input class="admin_menu_gomb" type="submit" name="felhasznalo_torles" value="Felhasználó törlése" />

        <input class="admin_menu_gomb" type="submit" name="szineszek" value="Színészek" />
        <input class="admin_menu_gomb" type="submit" name="uj_szinesz" value="Új színész létrehozása" />
        <input class="admin_menu_gomb" type="submit" name="szinesz_torles" value="Színész törlése" />
        <input class="admin_menu_gomb" type="submit" name="szinesz_modositas" value="Színész módosítása" />

        <input class="admin_menu_gomb" type="submit" name="filmek" value="Filmek" />
        <input class="admin_menu_gomb" type="submit" name="uj_film" value="Új film létrehozása" />
        <input class="admin_menu_gomb" type="submit" name="film_torles" value="Film törlése" />
        <input class="admin_menu_gomb" type="submit" name="film_modositas" value="Film módosítása" />

        <input class="admin_menu_gomb" type="submit" name="rendezok" value="Rendezők" />
        <input class="admin_menu_gomb" type="submit" name="uj_rendezo" value="Új rendező létrehozása" />
        <input class="admin_menu_gomb" type="submit" name="rendezo_torles" value="Rendező törlése" />
        <input class="admin_menu_gomb" type="submit" name="rendezo_modositas" value="Rendező módosítása" />

        <input class="admin_menu_gomb" type="submit" name="szereples_hozzaadas" value="Szereplés hozzáadása" />
        <input class="admin_menu_gomb" type="submit" name="szereples_torlese" value="Szereplés törlése" />

        <input class="admin_menu_gomb" type="submit" name="kijelentkezes" value="Kijelentkezés" />
    </form>
</div>