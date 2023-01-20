<?php
include('functions.php');
session_start();
function logout(){
    echo "<script>
      location.href='/PHPProject/pages/login.php';
      </script>";
    session_destroy();
    exit;
}
logout();
?>