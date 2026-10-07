<?php
require_once __DIR__ . '/../config/connection.php';

class mobile {
    function verify() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent);
    }
}
?>