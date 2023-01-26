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
    global $userId;
    openConnection();

    $query = "select * from wizyta WHERE lekarz_id = $userId";
    $result = mysqli_query($connection, $query);
    $headTitles = array("Data wizyty", "Godzina wizyty", "Lekarz", "Pacjent", "Opis");
    print("<form method='POST'>");
    print("<table class='table table-striped'>
                <thead>
                <tr>");
    foreach ($headTitles as $headTitle) print("<th scope='col'>$headTitle</th>");

    print("<th></th>");
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
                       </td>");
    }
    print("</table>");
    print("</form></div>");
    mysqli_free_result($result);

}

function editVisit($nr)
{
    global $connection;

    $order = "select opis from wizyta where id=$nr";
    $record = mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
    $visit = mysqli_fetch_row($record);
    $description = $visit[0];

    echo " 
 <div class='container'>
	<form method=POST action=''> 
	<table border=0>
	<br>
	<label for='opis'><strong>Opis</strong></label>
    <input type='text' maxlength='250' value='$description' class='form-control' id='opis' name='description' placeholder='Opis' required>
	</tr>
	<tr>
	<td colspan=3>
	<input type=submit name='button[$nr]' value='Zapisz' class='btn btn-primary btn-block' style='width:200px'></td>
	</tr>
	</table></form></div>";

}

function saveVisit($nr)
{
    global $connection;
    $description = $_POST['description'];
    $order = "update wizyta set opis='$description' where id=$nr;";
    mysqli_query($connection, $order) or exit("Błąd w zapytaniu: " . $order);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel lekarza</title>
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