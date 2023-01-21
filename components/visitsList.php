<?php
function visitsList(){
include("../CRUD/visits/get_visits.php");

$data = get_visits();

if (count($data)){
   foreach ($data as $item){
    echo '<tr>';
    echo '<th scope="row">'.$item['data_wizyty'].'</th>';
    echo '<td>'.$item['czas_wizyty'].'</td>';
    echo '<td>'.$item['imie_pacjenta'].' '.$item['nazwisko_pacjenta'].'</td>';
    echo '<td>'.$item['imie_lekarza'].' '.$item['nazwisko_lekarza'].'</td>';
    echo '<td>'.$item['opis'].'</td>';
    echo '<td><button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#visit-modal">Edytuj</button></td>';
    echo '</tr>';
   }
   
}else{
    echo("<tr></tr>");
}}