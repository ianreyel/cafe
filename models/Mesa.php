<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/comanda.php';

class Mesa {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function criar($numero, $capacidade) {
        $stmt = $this->pdo->prepare("INSERT INTO mesa (numero, capacidade) VALUES (?, ?)");
        return $stmt->execute([$numero, $capacidade]);
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM mesa");
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM mesa WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function comanda_atual($mesa_id) {
        $comandaModel = new Comanda($this->pdo);
        $stmt = $this->pdo->prepare("SELECT * FROM comanda WHERE mesa_id = ? AND estado = 'aberta'");
        $stmt->execute([$mesa_id]);

        $comanda = $stmt->fetch();
        
        if ($comanda) {
            $comanda['pedidos'] = $comandaModel->pedidos($comanda['id']);
            return $comanda; 
        }
        return false; 
    }
}
?>