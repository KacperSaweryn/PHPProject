<?php
function get_visits($id){
include("C:/xampp/htdocs/PHPProject/CRUD/init.php");
$server = init();
$sql = "SELECT wizyta.id, data_wizyty, czas_wizyty, lekarz.imie AS imie_lekarza, lekarz.nazwisko AS nazwisko_lekarza, pacjent.imie AS imie_pacjenta, pacjent.nazwisko AS nazwisko_pacjenta, opis
FROM wizyta
JOIN uzytkownik AS lekarz ON wizyta.lekarz_id = lekarz.uzytkownik_id
JOIN uzytkownik AS pacjent ON wizyta.pacjent_id = pacjent.uzytkownik_id
where pacjent.uzytkownik_id=$id order by data_wizyty, czas_wizyty";

$res;
if($server){
    try {
        $res = mysqli_query($server, $sql);
    } catch (\Throwable $th) {
        echo $th;
    }
    
}


if($res){
    $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $data;
}
return [];
}
?>