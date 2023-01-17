<?php

function otworz_polaczenie(){
    global $polaczenie;
    $serwer = "127.0.0.1";
    $uzytkownik = "root";
    $haslo = "";
    $baza = "przychodnia";

    $polaczenie = mysqli_connect($serwer, $uzytkownik, $haslo) or exit("Nieudane połączenie z serwerem");


    if(!mysqli_select_db($polaczenie, $baza)) {

        if(mysqli_errno($polaczenie) == 1049) {
            utworz_baze();
            mysqli_select_db($polaczenie, $baza);
            utworz_tabele();
            wstaw_dane_testowe();
        }
        else echo("Połączenie z bazą danych $baza nieudane<br>");
    }
    mysqli_set_charset($polaczenie, "utf8");
}

function zamknij_polaczenie(){
    global $polaczenie;
    mysqli_close($polaczenie);
}

function utworz_baze() {
    $polaczenie = mysqli_connect("127.0.0.1", "root", "") or exit("Nieudane połączenie z serwerem");
    $baza = 'przychodnia';

    echo "Tworzę bazę danych '$baza' ... <br>";
    mysqli_query($polaczenie, "CREATE DATABASE `$baza` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;")
    or exit("Błąd w zapytaniu tworzącym bazę");
}

function utworz_tabele() {
    global $polaczenie;

    $rozkaz = 	"create table typ " .
        "(typ_id int NOT NULL AUTO_INCREMENT ," .
        "typ varchar(32), " .
        "PRIMARY KEY (`typ_id`))";
    mysqli_query($polaczenie, $rozkaz) or exit("Błąd w zapytaniu: $rozkaz");

    $rozkaz = 	"create table uzytkownik " .
        "(uzytkownik_id int NOT NULL AUTO_INCREMENT ," .
        "typ_id int," .
        "imie varchar(32), " .
        "nazwisko varchar(32), " .
        "PRIMARY KEY (`uzytkownik_id`), FOREIGN KEY (typ_id) REFERENCES typ(typ_id))";
    mysqli_query($polaczenie, $rozkaz) or exit("Błąd w zapytaniu: $rozkaz");

    $rozkaz = 	"create table wizyta " .
        "(id int NOT NULL AUTO_INCREMENT ," .
        "data_wizyty DATE, " .
        "czas_wizyty TIME, " .
        "lekarz_id int, " .
        "pacjent_id int, " .
        "opis text(500), " .
        "PRIMARY KEY (`id`)," .
        "FOREIGN KEY (lekarz_id) REFERENCES uzytkownik(uzytkownik_id)," .
        "FOREIGN KEY (pacjent_id) REFERENCES uzytkownik(uzytkownik_id))";
    mysqli_query($polaczenie, $rozkaz) or exit("Błąd w zapytaniu: $rozkaz");
}

function wstaw_dane_testowe() {
    global $polaczenie;
    mysqli_set_charset($polaczenie, "utf8");
    $rozkazy = array("insert into typ values(null, 'Admin');",
        "insert into typ values(null, 'Lekarz');",
        "insert into typ values(null, 'Pacjent');");
    foreach($rozkazy as $rozkaz)
        mysqli_query($polaczenie, $rozkaz) or exit("Błąd w zapytaniu: ".$rozkaz);

    $rozkazy = array("insert into uzytkownik values(null, 1, 'admin', 'admin');",
        "insert into uzytkownik values(null, 2, 'Lekarz', 'Lekarski');",
        "insert into uzytkownik values(null, 3, 'Pacjent', 'Pacjentowy');");
    foreach($rozkazy as $rozkaz)
        mysqli_query($polaczenie, $rozkaz) or exit("Błąd w zapytaniu: ".$rozkaz);

    $rozkazy = array("insert into wizyta values(null ,'2023-01-16' ,'17:29:16', 2, 3,'lorem ipsum');",
        "insert into wizyta values(null ,'2023-01-16' ,'17:29:16', 2, 3,'lorem ipsum');");
    foreach($rozkazy as $rozkaz)
        mysqli_query($polaczenie, $rozkaz) or exit("Błąd w zapytaniu: ".$rozkaz);
}

?>