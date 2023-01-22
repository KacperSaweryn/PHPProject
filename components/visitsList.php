<?php
function visitsList()
{
    include("../CRUD/visits/get_visits.php");

    $data = get_visits();

    if (count($data)) {
        foreach ($data as $item) {
            $id = $item['id'];
            $buttonId = "button[$id]";
            echo '<tr>';
            echo '<th scope="row">' . $item['data_wizyty'] . '</th>';
            echo '<td>' . $item['czas_wizyty'] . '</td>';
            echo '<td>' . $item['imie_pacjenta'] . ' ' . $item['nazwisko_pacjenta'] . '</td>';
            echo '<td>' . $item['imie_lekarza'] . ' ' . $item['nazwisko_lekarza'] . '</td>';
            echo '<td>' . $item['opis'] . '</td></tr>';
//            echo "<td><input type='button' name='$buttonId' class='btn btn-primary btn-block' data-bs-toggle='modal' data-bs-target='#visit-modal'>Edytuj</input></td>";
//            echo "<td><input type='submit' name='$buttonId' value='Usuń' class='btn btn-primary btn-block' >Usuń</input></td>";
//            echo '</tr>';

        }

    } else {
        echo("<tr></tr>");
    }
}

