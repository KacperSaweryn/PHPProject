<?php
include('../functions/functions.php');
include('../components/visitsList.php');
include('../functions/welcome.php');
session_start();
$userId = $_SESSION['userId'];
$lastVisit = $_COOKIE['lastVisit'] ?? "";
setcookie('lastVisit', date('d/m/y - G:i'), time() + (60 * 60 * 12 * 365));
function printVisits()
{
    echo "
    <div class='container'>
    <h2>Lista wizyt</h2>";
    global $connection;
    openConnection();

    $query = "select * from wizyta order by data_wizyty, czas_wizyty";
    $result = mysqli_query($connection, $query);
    $headTitles = array("Data wizyty", "Godzina wizyty", "Lekarz", "Pacjent", "Opis");
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
                if ($f == 3) {
                    $doctor = "";
                    $doctorId = $field;
                    if ($field != null) {
                        $queryDoctorId = "select imie, nazwisko from uzytkownik where uzytkownik_id = $doctorId";
                        $resultDoctor = mysqli_query($connection, $queryDoctorId);
                        $rowDoctor = mysqli_fetch_array($resultDoctor, MYSQLI_ASSOC);
                        $doctorName = $rowDoctor['imie'];
                        $doctorSurname = $rowDoctor['nazwisko'];
                        $doctor = $doctorName . ' ' . $doctorSurname;
                    }
                    print("<td>$doctor</td>");
                } else if ($f == 4) {
                    $patient = "";
                    if ($field != null) {
                        $patientId = $field;
                        $queryPatientId = "select imie, nazwisko from uzytkownik where uzytkownik_id = $patientId";
                        $resultPatient = mysqli_query($connection, $queryPatientId);
                        $rowPatient = mysqli_fetch_array($resultPatient, MYSQLI_ASSOC);
                        $patientName = $rowPatient['imie'];
                        $patientSurname = $rowPatient['nazwisko'];
                        $patient = $patientName . ' ' . $patientSurname;
                    }
                    print("<td>$patient</td>");
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

function editVisit($nr = -1)
{
    global $connection;
    $doctorsOrder = "select imie, nazwisko, uzytkownik_id from uzytkownik where typ_id = 2";
    $doctorRecord = mysqli_query($connection, $doctorsOrder) or exit("Błąd w zapytaniu: " . $doctorsOrder);
    $patientsOrder = "select imie, nazwisko, uzytkownik_id from uzytkownik where typ_id = 3";
    $patientRecord = mysqli_query($connection, $patientsOrder) or exit("Błąd w zapytaniu: " . $patientsOrder);
    if ($nr != -1) {
        $order = "select data_wizyty, czas_wizyty, lekarz_id, pacjent_id, opis  from wizyta where id=$nr";
        $record = mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
        $visit = mysqli_fetch_row($record);
        $visitDate = $visit[0];
        $visitTime = $visit[1];
        $doctorId = $visit[2];
        $patientId = $visit[3];
        $description = $visit[4];


    } else {
        $visitDate = "";
        $visitTime = "";
        $doctorId = null;
        $patientId = null;
        $description = "";
    }
    echo " 
    <br>
    <div class='container'>
	<form method=POST action=''> 
	<table border=0>
	<tr>
	<label for='doctor'><strong>Lekarz</strong></label>
    <select class='form-select' name='doctorId'>";
    while ($doctors = mysqli_fetch_array($doctorRecord)) {
        echo "<option value='" . $doctors['uzytkownik_id'] . "'>" . $doctors['imie'] . " " . $doctors['nazwisko'] . "</option>";
    }
    echo "
	</tr>
	<tr>
	<label for='patient'><strong>Pacjent</strong></label>
    <select class='form-select' name='patientId'>";
    while ($patients = mysqli_fetch_array($patientRecord)) {
        echo "<option value='" . $patients['uzytkownik_id'] . "'>" . $patients['imie'] . " " . $patients['nazwisko'] . "</option>";
    }
    echo "
	</tr>
	<tr>
	<label for='visitDate'><strong>Data</strong></label>
    <input type='date' value='$visitDate' class='form-control' id='visitDate' name='visitDate' placeholder='Data' required>
	</tr>
	<tr>
	<label for='visitTime'><strong>Godzina</strong></label>
    <input type='time' value='$visitTime' class='form-control' id='visitTime' name='visitTime' placeholder='Godzina' required>
	</tr>
	<tr>
	<label for='opis'><strong>Opis</strong></label>
    <input type='text' value='$description' class='form-control' id='opis' name='description' placeholder='Opis'>
	</tr>
	<tr>
	<td colspan=3>
	<input type=submit name='button[$nr]' class='btn btn-primary btn-block' value='Zapisz' style='width:200px'></td>
	</tr>
	</table></form></div>";
}

function saveVisit($nr)
{
    global $connection;

    $visitDate = $_POST['visitDate'];
    $visitTime = $_POST['visitTime'];
    $doctorId = $_POST['doctorId'];
    $patientId = $_POST['patientId'];
    $description = $_POST['description'];
    if ($nr != -1)
        $order = "update wizyta set data_wizyty='$visitDate', czas_wizyty='$visitTime', lekarz_id='$doctorId', pacjent_id='$patientId', opis='$description' where id=$nr;";
    else $order = "insert into wizyta values(null,'$visitDate', '$visitTime', '$doctorId','$patientId','$description');";
    mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
}

function deleteVisit($nr)
{
    global $connection;

    $rozkaz = "delete from wizyta where id=$nr;";
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


                    <li class="nav-item"><a href='../functions/logout.php' class="nav-link">Wyloguj się <i
                                    class="bi bi-box-arrow-right"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>
</section>
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
        editVisit($nr);
        break;
    case 'Dodaj':
        editVisit();
        break;
    case 'Usuń':
        deleteVisit($nr);
        break;
    case 'Zapisz':
        saveVisit($nr);
        break;

}
printVisits();
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