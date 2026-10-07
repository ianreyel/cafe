<?php
require_once __DIR__ . '/../config/connection.php';

class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT id, username, password, ds_function FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function create($username, $password, $ds_function) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (username, password, ds_function) VALUES (?, ?, ?)");
        return $stmt->execute([$username, $hash, $ds_function]);
    }
}
?>