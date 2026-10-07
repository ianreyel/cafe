<?php
require_once __DIR__ . '/../config/connection.php';
if(isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}else {
    header('Location: login.php');
    exit();
}
?>