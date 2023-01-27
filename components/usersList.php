<?php
function usersList(){
include("C:/xampp/htdocs/PHPProject/CRUD/users/get_users.php");

$data = get_users();

if (count($data)){
   foreach ($data as $item){
    echo '<tr>';
    echo '<th scope="row">'.$item['typ'].'</th>';
    echo '<td>'.$item['imie'].'</td>';
    echo '<td>'.$item['nazwisko'].'</td>';
    echo '<td><button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal"
    data-bs-target="#user-modal" data-value="'.$item['uzytkownik_id'].'">Edytuj</button></td>';
    echo '<td><button type="button" class="btn btn-primary btn-block" data-bs-toggle="modal"
    data-bs-target="#" data-value="'.$item['uzytkownik_id'].'">Lista wizyt</button></td>';
    echo '</tr>';
   }
   
}else{
    echo("<tr></tr>");
}}
?>