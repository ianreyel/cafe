<?php 
session_start();
require_once __DIR__ . '/../models/MobileVerify.php';
$env = parse_ini_file(__DIR__ . '/../.env');

$mobile = new mobile();
$mobile = $mobile->verify();


$host = $env["DB_HOST"];
$db   = $env["DB_NAME"];
$user = $env["DB_USER"];
$pass = $env["DB_PASS"];
$charset = 'utf8mb4';

function isMobile() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    return preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent);
}

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>