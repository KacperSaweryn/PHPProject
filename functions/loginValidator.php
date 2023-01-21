<?php
include('functions.php');
session_start();

function checkCredentials()
{
    openConnection();
    global $connection;
    $login = $_GET['login'];
    $password = $_GET['password'];
    $login = stripcslashes($login);
    $password = stripcslashes($password);
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $_SESSION['userId'] = '';
    $_SESSION['userType'] = '';
    $_SESSION['name'] = '';
    $_SESSION['surname'] = '';

    $zapytanie = "select * from uzytkownik where login ='$login' and password ='$password'";

    $wynik = mysqli_query($connection, $zapytanie);
    $row = mysqli_fetch_array($wynik, MYSQLI_ASSOC);
    $count = mysqli_num_rows($wynik);

    if ($count == 1) {
        $userId = $row['uzytkownik_id'];
        $_SESSION['userId'] = $userId;
        $_SESSION['name'] = $row['imie'];
        $_SESSION['surname'] = $row['nazwisko'];
        $_SESSION['userType'] = $row['typ_id'];
        switch ($_SESSION['userType']) {
            case "1":
                echo "<script> location.href='../pages/adminPanel.php'; </script>";
                exit;
            case "2":
                echo "<script> location.href='../pages/doctorPanel.php'; </script>";
                exit;
            case "3":
                echo "<script> location.href='../pages/patientPanel.php'; </script>";
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
    closeConnection();
    session_destroy();
    exit;
}
?>

<?php
checkCredentials();
?>
