<?php 
session_start();
$env = parse_ini_file(__DIR__ . '/../.env');

$host = $env["DB_HOST"];
$db   = $env["DB_NAME"];
$user = $env["DB_USER"];
$pass = $env["DB_PASS"];
$charset = 'utf8mb4';

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