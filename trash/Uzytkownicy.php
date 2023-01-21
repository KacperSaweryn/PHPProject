<?php
include('Functions.php');
session_start();
$userId = $_SESSION['userId'];

function printUsers()
{
    global $connection;
    $zapytanie = "select * from uzytkownik";
    $wynik = mysqli_query($connection, $zapytanie);

    $naglowki = array("Typ", "Imię", "Nazwisko", "Login", "Hasło");
    print("<form method='POST'>");
    print("<b>Użytkownicy</b><br>");
    print("<table border = 1><tr>");
    foreach ($naglowki as $naglowek) print("<td><b>$naglowek</b></td>");
    print("<td align='center'><b><input type='submit' name='przycisk[-1]' value='Dodaj nowego'></b></td>");
    print("</tr>");
    while ($wiersz = mysqli_fetch_row($wynik)) {
        print("<tr>");
        foreach ($wiersz as $p => $pole)
            if ($p != 0) {
                if ($p == 1) {
                    $typ = $pole;
                    $zapytanieTyp = "select typ from typ where typ_id = $typ";
                    $wynikTyp = mysqli_query($connection, $zapytanieTyp);
                    $wierszTyp = mysqli_fetch_array($wynikTyp, MYSQLI_ASSOC);
                    $typ = $wierszTyp['typ'];
                    print("<td>$typ</td>");
                } else if ($p == 5) {
                    print("<td>***</td>");
                } else {
                    print("<td>$pole</td>");
                }
            }

        print("<td align='center'><input type='submit' name='przycisk[$wiersz[0]]' value='Edytuj'>
									  <input type='submit' name='przycisk[$wiersz[0]]' value='Usuń'></td>");
        print("</tr>");

    }
    print("</table>");
    print("</form>");
    mysqli_free_result($wynik);
}

function editUsers($nr = -1)
{
    global $connection;

    if ($nr != -1) {
        $rozkaz = "select typ_id, imie, nazwisko, login, password from uzytkownik where uzytkownik_id=$nr;";
        $rekord = mysqli_query($connection, $rozkaz) or exit("Błąd w zapytaniu: " . $rozkaz);

        $user = mysqli_fetch_row($rekord);
        $typ_id = $user[0];
        $imie = $user[1];
        $nazwisko = $user[2];
        $login = $user[3];
        $password = $user[4];

    } else {
        $typ_id = "";
        $imie = '';
        $nazwisko = '';
        $login = "";
        $password = "";
    }

    echo " 
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<td>Typ</td><td colspan=2>
	<input type=text name='typ_id' value='$typ_id' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Imię</td><td colspan=2>
	<input type=text name='imie' value='$imie' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td>Nazwisko</td><td colspan=2>
	<input type=text name='nazwisko' value='$nazwisko' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<tr>
	<td>Login</td><td colspan=2>
	<input type=text name='login' value='$login' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<tr>
	<td>Hasło</td><td colspan=2>
	<input type=text name='password' value='$password' size=15 style='text-align: left'></td>
	</tr>
	<tr>
	<td colspan=3>
	<input type=submit name='przycisk[$nr]' value='Zapisz' style='width:200px'></td>
	</tr>
	</table></form>";
}

function saveUser($nr)
{
    global $connection;
    $typ_id = $_POST['typ_id'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    if ($nr != -1)
        $rozkaz = "update uzytkownik set typ_id='$typ_id', imie='$imie', nazwisko='$nazwisko', login='$login', password='$password' where uzytkownik_id=$nr;";
    else $rozkaz = "insert into uzytkownik values(null,'$typ_id', '$imie', '$nazwisko','$login','$password');";
    mysqli_query($connection, $rozkaz) or exit("Błąd w zapytaniu: " . $rozkaz);
}


function deleteUser($nr)
{
    global $connection;

    $rozkaz = "delete from uzytkownik where uzytkownik_id=$nr;";
    mysqli_query($connection, $rozkaz) or exit("Błąd w zapytaniu: $rozkaz");
}

?>
<html>
<head>
    <meta charset="utf-8">

</head>
<body bgcolor=#add8e6>

<hr>
<center>
    <?php

    $polecenie = '';
    if (isset($_POST['przycisk'])) {
        $nr = key($_POST['przycisk']);
        $polecenie = $_POST['przycisk'][$nr];
    }

    openConnection();

    switch ($polecenie) {
        case 'Edytuj':
            editUsers($nr);
            break;
        case 'Dodaj nowego':
            editUsers();
            break;
        case 'Usuń':
            deleteUser($nr);
            break;
        case 'Zapisz':
            saveUser($nr);
            break;

    }
    printUsers();
    closeConnection();
    ?>
</center>
</body>
</html>