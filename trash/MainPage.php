<?php
include('Functions.php');
session_start();

function checkCredentials()
{
    openConnection();
    global $polaczenie;
    $login = $_GET['login'];
    $password = $_GET['password'];
    $login = stripcslashes($login);
    $password = stripcslashes($password);
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['userId'] = '';
    $_SESSION['userTyp'] = '';
    $_SESSION['imie'] = '';
    $_SESSION['nazwisko'] = '';

    $zapytanie = "select * from uzytkownik where login ='$login' and password ='$password'";

    $wynik = mysqli_query($polaczenie, $zapytanie);
    $row = mysqli_fetch_array($wynik, MYSQLI_ASSOC);
    $count = mysqli_num_rows($wynik);

    if ($count == 1) {
        $userId = $row['uzytkownik_id'];
        $_SESSION['userId'] = $userId;
        $_SESSION['imie'] = $row['imie'];
        $_SESSION['nazwisko'] = $row['nazwisko'];
        $_SESSION['userTyp'] = $row['typ_id'];
        switch ($_SESSION['userTyp']) {
            case "1":
                echo "<div style='text-align:left'>
                <input type=button value='Wizyty' onClick=window.location='Wizyty.php'>
                <input type=button value='Uzytkownicy' onClick=window.location='Uzytkownicy.php'></div>";
//                echo "<script> location.href='../pages/adminPanel.php'; </script>";
                exit;
                break;
            case "3":
            case "2":
                echo "<div style='text-align:left'><input type=button value='Wizyty' onClick=window.location='Wizyty.php'></div>";
                break;
            default:
                echoLoginProblem();

        }

    } else {
        echoLoginProblem();
    }
}

function echoLoginProblem()
{
    echo "<h1> Problem z zalogowaniem.</h1><input type=button value='WRÓĆ' onClick=window.location='Login.php'>";
    closeConnection();
    session_destroy();
}

?>
<html>
<head>
    <meta charset="utf-8">
    <title>Strona główna</title>
</head>
<body bgcolor=#add8e6>
<div style='text-align:right'>
    <form method=GET action='Login.php'>
        <input type=submit value='Wyloguj'></td>
    </form>
</div>
<?php
checkCredentials();
?>
</body>
</html>
