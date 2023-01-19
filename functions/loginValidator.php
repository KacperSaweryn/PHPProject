<?php
include('functions.php');
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
                echo "<script> location.href='/pages/adminPanel.html'; </script>";
                exit;
            case "2":
                echo "<script> location.href='/pages/doctorPanel.html'; </script>";
                exit;
            case "3":
                echo "<script> location.href='/pages/patientPanel.html'; </script>";
                exit;
            default:
                echoLoginProblem();
        }

    } else {
        echoLoginProblem();
    }
}

function echoLoginProblem()
{
    echo "<script> alert('Niepoprawne dane')
          location.href='/pages/login.php';
          </script>";

    //echo "<script> window.location.href='pages/login.php'; </script>";

    closeConnection();
    session_destroy();
    exit;
}

?>

<?php
checkCredentials();
?>
