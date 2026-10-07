<?php
require_once __DIR__ . '/../config/connection.php';

class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criar($nome, $preco) {
        $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, preco) VALUES (?, ?)");
        return $stmt->execute([$nome, $preco]);
    }
}
?>