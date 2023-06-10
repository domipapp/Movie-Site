# Film adatbázis
A projekt a 4. féléves Informatika 2 tárgy házi feladatának megvalósítása.
## Specifikáció 
### Feladat formális leírása
A feladat célja egy olyan stream szerű oldal megvalósítása melyen filmek vásárolhatóak meg. Az adatbázisban tároljuk, hogy melyik felhasználó melyik filmeket tekintheti meg és mely filmekben mely színészek játszanak. A felhasználó belépés után lekérheti a filmek listáját, magához rendelhet filmet, megnézheti a filmhez tartozó színészeket etc. .
### Elérhető funkciók
- Színészek kezelése :person_fencing:
  - Új színész létrehozása
  - Meglévő színész adatainak módosítása
  - Színészek törlése
  - Az adatbázisban tárolt színészek listázása, keresés a színészek neve alapján
 
- Filmek kezelése 🎦
  - Új film létrehozása
  - Meglévő film adatainak módosítása
  - Filmek törlése
  - Az adatbázisban tárolt filmek listázása, keresés a filmek címe alapján

- Felhasználók kezelése 🧍
  - Új felhasznló létrehozása
  - Meglévő felhasználó adatainak módosítása belépés után (csak saját: email cím, jelszó, stb.)
  - Felhasználók saját magának törlése

### Adatbázis séma
Az adatbázisban a következő entitásokat és attribútumokat tároljuk:
- Színész: A színész neve, kora, neme és egyedi azonosítója
- Film: A film címe, hossza, rendezőjének a neve, műfaja és egyedi azonosítója
- Felhasználó: A felhasználó felhasználóneve, email címe, jelszava és egyedi azonosítója


![sema](https://user-images.githubusercontent.com/100694551/164995841-331aa5c5-8d53-4f80-8fdd-483cc1ef3d7f.png)

