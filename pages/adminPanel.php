<?php
include($_SERVER['DOCUMENT_ROOT'].'\functions\functions.php');
session_start();

function printUsers(){

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

    print("<th><b><button type='button' name='button[-1]' class='btn btn-primary btn-block' data-bs-toggle='modal'
                                data-bs-target='#user-modal' value='Dodaj'/>Dodaj</th>");
    print("</tr>");
    echo "
                    
                </tr>
                </thead>
                <tbody>
                <tr>
                  ";

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
                    print("<td>***</td>");
                } else {
                    print("<td>$field</td>");
                }
            }
        print("<td align='center' xmlns=\'http://www.w3.org/1999/html\'>
                       <button type='button' name='button[$row[0]]'
                       class='btn btn-primary btn-block' data-bs-toggle='modal'
                       data-bs-target='#user-modal'>Edytuj</button>
                       <button type='button' name='button[$row[0]]'
                       class='btn btn-primary btn-block' data-bs-toggle='modal'
                       data-bs-target='#user-modal'>Usuń</button></td>");
    }
    print("</table>");
    print("</form>");
    mysqli_free_result($result);


}

function saveUser($nr)
{
    global $connection;
    $typeId = $_POST['typ_id'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $name = $_POST['imie'];
    $surname = $_POST['nazwisko'];
    if ($nr != -1)
        $order = "update uzytkownik set typ_id='$typeId', imie='$name', nazwisko='$surname', login='$login', password='$password' where uzytkownik_id=$nr;";
    else $order = "insert into uzytkownik values(null,'$typeId', '$name', '$surname','$login','$password');";
    mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
}

function deleteUser($nr)
{
    global $connection;

    $order = "delete from uzytkownik where uzytkownik_id=$nr;";
    mysqli_query($connection, $order) or exit("Błąd w zapytaniu: $order");
}

function editUsers($nr = -1)
{
    global $connection;

    if ($nr != -1) {
        $order = "select typ_id, imie, nazwisko, login, password from uzytkownik where uzytkownik_id=$nr;";
        $record = mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);


        $user = mysqli_fetch_row($record);
        $typeId = $user[0];
        $name = $user[1];
        $surname = $user[2];
        $login = $user[3];
        $password = $user[4];

    } else {
        $typeId = 1;
        $name = '';
        $surname = '';
        $login = "";
        $password = "";
    }
echo"
    <form method='post' action=''>
        <div class='modal fade' id='user-modal' tabindex='-1' role='dialog' aria-labelledby='user-modalLabel'
             aria-hidden='true'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='user-modalLabel'>Edytuj uzytkownika</h5>
                    </div>
                    <div class='modal-body'>
                    
                        <label for='name'>Imię</label>
                        <input type='text' class='form-control' id='name' value='$name' placeholder='Imię'>
                        <label for='surname'>Nazwisko</label>
                        <input type='text' class='form-control' id='surname' value='$surname' placeholder='Nazwisko'>
                        <label for='login'>Login</label>
                        <input type='text' class='form-control' id='login' value='$login' placeholder='Login'>
                        <label for='surname'>Hasło</label>
                        <input type='password' class='form-control' id='password' value='$password' placeholder='Hasło'>


                        <select class='form-select'>
                            <option selected>--- Wybierz typ ---</option>
                            <option value='2'>Lekarz</option>
                            <option value='3'>Pacjent</option>
                            <option value='1'>Admin</option>
                        </select>

                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Zamknij</button>
                        <button type='submit' name='button[$nr]' class='btn btn-primary'>Zapisz i zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    ";
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
</head>

<body>
<section>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
        <div class="container d-flex justify-content-between">
            <div class="navbar-brand">Przychodnia</div>
            <div id="ftco-nav">
                <ul class="navbar-nav" id="myTab" role="tablist">
                    <li class="nav-item menu-item" role="presentation">
                            <span class="nav-link active" id="visits-tab" data-bs-toggle="tab"
                                  data-bs-target="#visitsList" role="tab" aria-controls="visitsList"
                                  aria-selected="true">Wizyty</span>
                    </li>
                    <li class="nav-item menu-item" role="presentation">
                            <span class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#userList"
                                  role="tab" aria-controls="userList" aria-selected="false">Uzytkownicy</span>
                    </li>
                    <li class="nav-item"><a href='/functions/logout.php' class="nav-link">Wyloguj się <i
                                    class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>

</section>
<div class="container">
    <!-- MODAL VISIT START -->
    <form action="">
        <div class="modal fade" id="visit-modal" tabindex="-1" role="dialog" aria-labelledby="visit-modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visit-modalLabel">Edytuj wizyte</h5>
                    </div>
                    <div class="modal-body">
                        <label for="patient">Pacjent</label>
                        <input type="text" class="form-control" id="patient" placeholder="Pacjent"
                               aria-label="Pacjent" aria-describedby="basic-addon1">
                        <label for="date">Data</label>
                        <input type="date" class="form-control" id="date">

                        <select class="form-select">
                            <option selected>--- Wybierz godzine ---</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <label for="time">Czas wizyty (w minutach)</label>
                        <input type="text" class="form-control" id="time" placeholder="Czas wizyty"
                               aria-describedby="basic-addon1">
                        <span>Status</span>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                   id="flexRadioDefault1">
                            <label class="form-check-label" for="flexRadioDefault1">
                                Odbyła się
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault"
                                   id="flexRadioDefault2" checked>
                            <label class="form-check-label" for="flexRadioDefault2">
                                Odbędzie się
                            </label>
                        </div>

                        <div class="form-floating">

                            <textarea class="form-control" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Opis</label>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="button" class="btn btn-primary">Zapisz i zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- MODAL VISIT END -->


    <!-- MODAL USER START -->
<!--    <form method="post" action="">-->
<!--        <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-labelledby="user-modalLabel"-->
<!--             aria-hidden="true">-->
<!--            <div class="modal-dialog" role="document">-->
<!--                <div class="modal-content">-->
<!--                    <div class="modal-header">-->
<!--                        <h5 class="modal-title" id="user-modalLabel">Edytuj uzytkownika</h5>-->
<!--                    </div>-->
<!--                    <div class="modal-body">-->
<!--                        <label for="name">Imię</label>-->
<!--                        <input type="text" class="form-control" id="name" placeholder="Imię">-->
<!--                        <label for="surname">Nazwisko</label>-->
<!--                        <input type="text" class="form-control" id="surname" placeholder="Nazwisko">-->
<!---->
<!---->
<!--                        <select class="form-select">-->
<!--                            <option selected>--- Wybierz typ ---</option>-->
<!--                            <option value="2">Lekarz</option>-->
<!--                            <option value="3">Pacjent</option>-->
<!--                            <option value="1">Admin</option>-->
<!--                        </select>-->
<!---->
<!--                    </div>-->
<!--                    <div class="modal-footer">-->
<!--                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>-->
<!--                        <button type="button" class="btn btn-primary">Zapisz i zamknij</button>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->
    <!-- MODAL USER END -->



    <div class="tab-content" id="myTabContent">
        <!-- VISITS START -->
        <div class="tab-pane fade show active" id="visitsList" role="tabpanel" aria-labelledby="visits-tab"
             tabindex="0">
            <h2>Lista wizyt</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Data wizyty</th>
                    <th scope="col">Czas wizyty</th>
                    <th scope="col">Pacjent</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">21.12.2022</th>
                    <td>0:30h</td>
                    <td>Jan Kowalski</td>
                    <td>Odbyła się</td>
                    <td><button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal"
                                data-bs-target="#visit-modal">Edytuj</button></td>
                </tr>
                <tr>
                    <th scope="row">21.12.2022</th>
                    <td>0:30h</td>
                    <td>Jan Kowalski</td>
                    <td>Odbędzie się</td>
                    <td><button type="button" class="btn btn-primary btn-block">Edytuj</button></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- VISITS END -->



        <!-- USERS START -->
        <div class="tab-pane fade" id="userList" role="tabpanel" aria-labelledby="user-tab" tabindex="0">
            <h2>Lista uzytkowników</h2>
            <?php
            printUsers();
            ?>

        </div>
        <!-- USERS END -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
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
closeConnection();
?>

</body>

</html>