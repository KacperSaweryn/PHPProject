<?php
include('../functions/functions.php');
include('../functions/welcome.php');
session_start();
$userId = $_SESSION['userId'];
$lastVisit = $_COOKIE['lastVisit'] ?? "";
setcookie('lastVisit', date('d/m/y - G:i'), time() + (60 * 60 * 12 * 365));
function printUsers()
{
    echo "
    <div class='container'>
    <h2>Lista użytkowników</h2>";
    global $connection;
    openConnection();
    $query = "select * from uzytkownik";
    $result = mysqli_query($connection, $query);
    $headTitles = array("Typ", "Imię", "Nazwisko", "Login", "Hasło");
    print("<form method='POST'>");
    print("<table class='table table-striped'>
                <thead>
                <tr>");
    foreach ($headTitles as $headTitle) print("<th scope='col'>$headTitle</th>");

    print("<th style='text-align: center'><b><input type='submit' name='button[-1]' class='btn btn-primary btn-block' value='Dodaj'
                                /></th>");
    print("</tr>");
    echo "
    </tr>
    </thead>
    <tbody>
    <tr>";

    while ($row = mysqli_fetch_row($result)) {
        print("<tr>");
        foreach ($row as $f => $field)
            if ($f != 0) {
                if ($f == 1) {
                    $type = $field;
                    $queryType = "select typ from typ where typ_id = $type";
                    $resultType = mysqli_query($connection, $queryType);
                    $rowType = mysqli_fetch_array($resultType, MYSQLI_ASSOC);
                    $type = $rowType['typ'];
                    print("<td>$type</td>");
                } else if ($f == 5) {
                    $x = "*";
                    $strLen = str_repeat($x, strlen($field));
                    print("<td>$strLen</td>");
                } else {
                    print("<td>$field</td>");
                }
            }
        print("<td align='center' xmlns=\'http://www.w3.org/1999/html\'>
                       <input type='submit' name='button[$row[0]]'
                       class='btn btn-primary btn-block' value='Edytuj'
                       />
                       <input type='submit' name='button[$row[0]]'
                       class='btn btn-primary btn-block' value='Usuń'
                      /></td>");
    }
    print("</table>");
    print("</form></div>");
    mysqli_free_result($result);

}

function editUsers($nr = -1)
{
    global $connection;
    if ($nr != -1) {
        $order = "select typ_id, imie, nazwisko, login, password from uzytkownik where uzytkownik_id=$nr;";
        $record = mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
        $types = ['Admin' => 1, 'Lekarz' => 2, 'Pacjent' => 3];

        $user = mysqli_fetch_row($record);
        $typeId = $user[0];
        $name = $user[1];
        $surname = $user[2];
        $login = $user[3];
        $password = $user[4];

    } else {
        $name = '';
        $surname = '';
        $login = "";
        $password = "";
    }
    echo " 
    <br>
    <div class='container'>
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<label for='typeId'><strong>Typ</strong></label>
    <select class='form-select' name='typeId'>
                                <option selected value='1'>Admin</option>
                                <option value='2'>Lekarz</option>
                                <option value='3'>Pacjent</option>
    </select>
	</tr>
	<tr>
	<label for='name'><strong>Imię</strong></label>
    <input type='text' value='$name' class='form-control' id='name' name='name' placeholder='Imię' required>
	</tr>
	<tr>
	<label for='surname'><strong>Nazwisko</strong></label>
    <input type='text' value='$surname' class='form-control' id='surname' name='surname' placeholder='Nazwisko' required>
	</tr>
	<tr>
	<label for='login'><strong>Login</strong></label>
    <input type='text' value='$login' class='form-control' id='login' name='login' placeholder='Login' required>
	</tr>
	<tr>
	<tr>
	<label for='password'><strong>Hasło</strong></label>
    <input type='password' value='$password' class='form-control' id='password' name='password' placeholder='Hasło' required>
	</tr>
	<tr>
	<td colspan=3>
	<input type=submit name='button[$nr]' class='btn btn-primary btn-block' value='Zapisz' style='width:200px'></td>
	</tr>
	</table></form></div>";
}

function saveUser($nr)
{
    global $connection;
    $typeId = $_POST['typeId'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    if ($nr != -1)
        $order = "update uzytkownik set typ_id='$typeId', imie='$name', nazwisko='$surname', login='$login', password='$password' where uzytkownik_id=$nr;";
    else $order = "insert into uzytkownik values(null,'$typeId', '$name', '$surname','$login','$password');";
    mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
}


function deleteUser($nr)
{
    global $connection;

    $rozkaz = "delete from uzytkownik where uzytkownik_id=$nr;";
    mysqli_query($connection, $rozkaz) or exit("Błąd w zapytaniu: $rozkaz");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel admina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="../styles/styles.css" rel="stylesheet">
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
<section>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container d-flex justify-content-between">
            <div class="navbar-brand">Przychodnia</div>
            <div id="ftco-nav">
                <ul class="navbar-nav" id="myTab" role="tablist">
                    <li class="nav-item menu-item" role="presentation"><a href='visitPanel.php'
                                                                          class="nav-link">Wizyty </a></li>
                    <li class="nav-item menu-item" role="presentation"><a href='../pages/usersPanel.php'
                                                                          class="nav-link">Użytkownicy </a></li>
                    </li>
                    <li class="nav-item"><a href='../functions/logout.php' class="nav-link">Wyloguj się <i
                                    class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

</section>
<?php

$orderValue = '';
if (isset($_POST['button'])) {
    $nr = key($_POST['button']);
    $orderValue = $_POST['button'][$nr];
}
openConnection();
switch ($orderValue) {
    case 'Edytuj':
        editUsers($nr);
        break;
    case 'Dodaj':
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

</body>
<footer>
    <div class="container">
        <?php
        welcome($userId);
        echo " | ";
        getLastVisit($lastVisit);
        ?>
    </div>

</footer>
</html>