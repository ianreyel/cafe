<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Comanda.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Utilizador não autenticado.']);
    exit;
}

$comandaModel = new Comanda($pdo);


$mesa_id = (int)($_POST['mesa_id'] ?? 0);
$user_id = $_SESSION['user_id'];

if ($mesa_id <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID de mesa inválido.']);
    exit;
}

try {
    $comandaModel->criar($user_id, $mesa_id);
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Comanda aberta com sucesso!']);
} catch (\PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro interno ao abrir a comanda.']);
}
?>