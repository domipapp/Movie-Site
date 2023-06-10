-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
SET SQL_SAFE_UPDATES = 0;
SET CHARSET utf8 ;
DROP SCHEMA IF EXISTS hazi;
CREATE SCHEMA IF NOT EXISTS hazi;
USE hazi;

DROP TABLE IF EXISTS felhasznalo ;
CREATE TABLE IF NOT EXISTS felhasznalo (
  felhasznalonev VARCHAR(50) NOT NULL,
  emailcim VARCHAR(100) NOT NULL,
  jelszo VARCHAR(255) NOT NULL,
  idfilm INT, 
  admin BOOL,
  CONSTRAINT fk_felhasznalo_film
  FOREIGN KEY (idfilm)
  REFERENCES film (idfilm)
  );

  DROP TABLE IF EXISTS rendezo ;
CREATE TABLE IF NOT EXISTS rendezo (
  idrendezo INT AUTO_INCREMENT,
  nev VARCHAR(45) NOT NULL,
  PRIMARY KEY (idrendezo)
  );

DROP TABLE IF EXISTS film;
CREATE TABLE IF NOT EXISTS film (
  idfilm INT AUTO_INCREMENT,
  cim VARCHAR(100) NOT NULL,
  hossz TIME NOT NULL,
  idrendezo INT,
  mufaj VARCHAR(45) NOT NULL,
  PRIMARY KEY (idfilm),
  CONSTRAINT fk_film_rendezo
  FOREIGN KEY (idrendezo)
  REFERENCES rendezo (idrendezo)
);

DROP TABLE IF EXISTS szinesz;
CREATE TABLE IF NOT EXISTS szinesz (
  idszinesz INT AUTO_INCREMENT,
  nev VARCHAR(45) NOT NULL,
  kor VARCHAR(9),
  nem VARCHAR(1) NOT NULL,
  PRIMARY KEY (idszinesz)
  );
  
DROP TABLE IF EXISTS szerepel;
CREATE TABLE IF NOT EXISTS szerepel (
  idfilm INT,
  idszinesz INT,
  PRIMARY KEY (idfilm, idszinesz),
  CONSTRAINT fk_film_has_szinesz_film
    FOREIGN KEY (idfilm)
    REFERENCES film (idfilm),
  CONSTRAINT fk_film_has_szinesz_szinesz1
    FOREIGN KEY (idszinesz)
    REFERENCES szinesz (idszinesz)
);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

insert into rendezo(nev) values('Joss Whedon');
insert into rendezo(nev) values('Scott Derrickson');
insert into rendezo(nev) values('Joe Russo');
insert into rendezo(nev) values('James Gunn');
insert into rendezo(nev) values('Jon Watts');

insert into film(cim, hossz, idrendezo, mufaj) values('Bosszúállók', '2:22:00',(select idrendezo from rendezo where nev = 'Joss Whedon'), 'akció');
insert into film(cim, hossz, idrendezo, mufaj) values('Doctor Strange', '1:55:00',(select idrendezo from rendezo where nev ='Scott Derrickson'), 'fantasy');
insert into film(cim, hossz, idrendezo, mufaj) values('Amerika Kapitány: Polgárháború', '2:28:00',(select idrendezo from rendezo where nev ='Joe Russo'), 'dráma');
insert into film(cim, hossz, idrendezo, mufaj) values('A galaxis őrzői', '2:02:00',(select idrendezo from rendezo where nev ='James Gunn'), 'sci-fi');
insert into film(cim, hossz, idrendezo, mufaj) values('Pókember: Hazatérés', '2:13:00',(select idrendezo from rendezo where nev ='Jon Watts'), 'kaland');

insert into szinesz(nev, kor, nem) values('Robert Downey Jr.', '57', 'M');
insert into szinesz(nev, kor, nem) values('Scarlett Johansson', '37', 'F');
insert into szinesz(nev, kor, nem) values('Chris Hemsworth', '38', 'M');
insert into szinesz(nev, kor, nem) values('Chris Evans', '40', 'M');
insert into szinesz(nev, kor, nem) values('Mark Ruffalo', '54', 'M');
insert into szinesz(nev, kor, nem) values('Josh Brolin', '54', 'M');
insert into szinesz(nev, kor, nem) values('Elizabeth Olsen', '33', 'F');
insert into szinesz(nev, kor, nem) values('Tom Holland', '25', 'M');
insert into szinesz(nev, kor, nem) values('Paul Bettany', '50', 'M');
insert into szinesz(nev, kor, nem) values('Sebastian Stan', '39', 'M');
insert into szinesz(nev, kor, nem) values('Chris Pratt', '42', 'M');
insert into szinesz(nev, kor, nem) values('Chadwick Boseman', 'deceased', 'M');
insert into szinesz(nev, kor, nem) values('Don Cheadle', '57', 'M');
insert into szinesz(nev, kor, nem) values('Benedict Cumberbatch', '45', 'M');
insert into szinesz(nev, kor, nem) values('Karen Gillan', '34', 'F');
insert into szinesz(nev, kor, nem) values('Anthony Mackie', '43', 'M');
insert into szinesz(nev, kor, nem) values('Tom Hiddleston', '41', 'M');
insert into szinesz(nev, kor, nem) values('Zoë Saldana', '43', 'F');
insert into szinesz(nev, kor, nem) values('Pom Klementieff', '35', 'F');
insert into szinesz(nev, kor, nem) values('Peter Dinklage', '52', 'M');
insert into szinesz(nev, kor, nem) values('Bradley Cooper', '47', 'M');
insert into szinesz(nev, kor, nem) values('Danai Gurira', '44', 'F');
insert into szinesz(nev, kor, nem) values('Vin Diesel', '54', 'M');

insert into felhasznalo(felhasznalonev, emailcim, jelszo,  admin) values('admin', 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3',  true);

insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo1', 'alma@gmail.com', 'ebbc3c26a34b609dc46f5c3378f96e08',  (select idfilm from film where cim = 'Bosszúállók'), false);
insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo1', 'alma@gmail.com', 'ebbc3c26a34b609dc46f5c3378f96e08',  (select idfilm from film where cim = 'Doctor Strange'), false);
insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo1', 'alma@gmail.com', 'ebbc3c26a34b609dc46f5c3378f96e08',  (select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'), false);

insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo2', 'korte@gmail.com', '597c6286705463db3f00bdfeed2a5296',  (select idfilm from film where cim = 'Bosszúállók'), false);
insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo2', 'korte@gmail.com', '597c6286705463db3f00bdfeed2a5296',  (select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'), false);

insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo3', 'banan@gmail.com', 'aec7bd708ed2ad3435b9a9883ac7f45c',  (select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'), false);
insert into felhasznalo(felhasznalonev, emailcim, jelszo, idfilm, admin) values('felhasznalo3', 'banan@gmail.com', 'aec7bd708ed2ad3435b9a9883ac7f45c',  (select idfilm from film where cim = 'Doctor Strange'), false);
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Robert Downey Jr.'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Scarlett Johansson'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Chris Hemsworth'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Chris Evans'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Mark Ruffalo'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Don Cheadle'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Tom Hiddleston'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Sebastian Stan'));
insert into szerepel values((select idfilm from film where cim = 'Bosszúállók'),(select idszinesz from szinesz where nev = 'Paul Bettany'));

insert into szerepel values((select idfilm from film where cim = 'Doctor Strange'),(select idszinesz from szinesz where nev = 'Benedict Cumberbatch')); 

insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Chris Evans'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Anthony Mackie'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Sebastian Stan'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Robert Downey Jr.'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Scarlett Johansson'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Elizabeth Olsen'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Tom Holland'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Chadwick Boseman'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Paul Bettany'));
insert into szerepel values((select idfilm from film where cim = 'Amerika Kapitány: Polgárháború'),(select idszinesz from szinesz where nev = 'Don Cheadle'));

insert into szerepel values((select idfilm from film where cim = 'A galaxis őrzői'),(select idszinesz from szinesz where nev = 'Chris Pratt'));
insert into szerepel values((select idfilm from film where cim = 'A galaxis őrzői'),(select idszinesz from szinesz where nev = 'Zoë Saldana'));
insert into szerepel values((select idfilm from film where cim = 'A galaxis őrzői'),(select idszinesz from szinesz where nev = 'Vin Diesel'));
insert into szerepel values((select idfilm from film where cim = 'A galaxis őrzői'),(select idszinesz from szinesz where nev = 'Karen Gillan'));
insert into szerepel values((select idfilm from film where cim = 'A galaxis őrzői'),(select idszinesz from szinesz where nev = 'Bradley Cooper'));
insert into szerepel values((select idfilm from film where cim = 'A galaxis őrzői'),(select idszinesz from szinesz where nev = 'Pom Klementieff'));

insert into szerepel values((select idfilm from film where cim = 'Pókember: Hazatérés'),(select idszinesz from szinesz where nev = 'Tom Holland'));
insert into szerepel values((select idfilm from film where cim = 'Pókember: Hazatérés'),(select idszinesz from szinesz where nev = 'Robert Downey Jr.'));
 