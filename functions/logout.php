<?php
include('functions.php');
session_start();
function logout(){
    echo "<script>
      location.href='../pages/login.php';
      </script>";
    session_destroy();
    exit;
}
logout();
?>