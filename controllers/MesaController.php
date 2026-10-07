<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Mesa.php';
header('Content-Type: application/json');

$mesaModel = new Mesa($pdo);
$numero = (int)($_POST['numero'] ?? 0);
$capacidade = (int)($_POST['capacidade'] ?? 0);

if ($numero <= 0 || $capacidade <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha os campos com valores maiores que zero.']);
    exit;
}

try {
    $mesaModel->criar($numero, $capacidade);
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Mesa registada com sucesso!']);
} catch (\PDOException $e) {
    if ($e->getCode() == 23000) { // UNIQUE constraint (evita mesas com o mesmo número)
        echo json_encode(['status' => 'erro', 'mensagem' => 'O número desta mesa já se encontra registado.']);
    } else {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Erro interno ao registar a mesa.']);
    }
}
?>