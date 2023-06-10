<style>
    footer {
        position: fixed;
        right: 1%;
        bottom: 2%;
        color: white;
        text-align: center;
    }
</style>

<footer>
    <form action="" method="post">
        <select class="gomb" size="1" name="css">
            <option <?php if ($css == "bezs_css") echo 'selected = "selected"' ?>value="bezs_css">Bézs</option>
            <option <?php if ($css == "piros_css") echo 'selected = "selected"' ?>value="piros_css">Piros</option>
            <option <?php if ($css == "lila_css") echo 'selected = "selected"' ?>value="lila_css">Lila</option>
        </select>
        <input class="gomb" type="submit" value="Téma váltás" />
    </form>
</footer>