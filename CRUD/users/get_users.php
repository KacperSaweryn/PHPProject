<?php
    function get_users(){
        // include("C:/xampp/htdocs/PHPProject/CRUD/init.php");
        $server = init();
        $sql = "SELECT uzytkownik_id, typ.typ AS typ, nazwisko, imie, login, password FROM uzytkownik JOIN typ ON typ.typ_id=uzytkownik.typ_id";

        $res = null;
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