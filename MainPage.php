<?php
include('Functions.php');
session_start();
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Wyniki egzaminu wstępnego - podsumowanie</title>
</head>
<body bgcolor=#add8e6>
<?php
otworz_polaczenie();
global $polaczenie;
$login = $_POST['login'];
$password = $_POST['password'];
$login = stripcslashes($login);
$password = stripcslashes($password);

$zapytanie = "select * from uzytkownik where login ='$login' and password ='$password'";

$wynik = mysqli_query($polaczenie, $zapytanie);
$row = mysqli_fetch_array($wynik, MYSQLI_ASSOC);
$count = mysqli_num_rows($wynik);

if ($count != 1) {
    echo "<h1> Problem z zalogowaniem.</h1><input type=button value='WRÓĆ' onClick=window.location='Login.php'>";
    zamknij_polaczenie();
    session_destroy();

} else {
    echo "<h1><center> Witaj </center></h1>";
}
?>
<br>
<hr>
<div style='text-align:center'>
</div>
</body>
</html>
