<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Produto.php';
header('Content-Type: application/json');

$produtoModel = new Produto($pdo);
$nome = trim($_POST['nome'] ?? '');
// Substitui vírgula por ponto para evitar erros no formato decimal do MySQL
$preco = (float)str_replace(',', '.', $_POST['preco'] ?? '0');

if (empty($nome) || $preco <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha um nome e um preço válido.']);
    exit;
}

try {
    $produtoModel->criar($nome, $preco);
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Produto registado com sucesso!']);
} catch (\PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao registar o produto.']);
}
?>