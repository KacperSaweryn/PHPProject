<?php
function welcome($id)
{
    openConnection();
    global $connection;
    $query = "select imie, nazwisko from uzytkownik WHERE uzytkownik_id = $id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_row($result);
    $name = $row[0];
    $surname = $row[1];
    echo "Użytkownik: " . $name . ' ' . $surname;
}

?>
