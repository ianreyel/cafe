<?php
include "../config/conection.php";
if(isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}else {
    header('Location: login.php');
    exit();
}
?>