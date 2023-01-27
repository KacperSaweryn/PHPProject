<?php
function init()
{
    $server = mysqli_connect("localhost", "root", "")
    or exit("Nie mozna połączyć się z serwerem bazy danych");
    $baza = mysqli_select_db($server, "przychodnia")
    or exit ("Nie mozna połączyć się z bazą uzytkownicy");
    mysqli_set_charset($server, "utf8");
    return $server;
}

?>