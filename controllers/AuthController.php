<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/User.php';

$action = $_GET['action'] ?? '';
$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'register') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $ds_function = $_POST['ds_function'] ?? 'garcom';

        if (empty($username) || empty($password)) {
            $_SESSION['erro'] = 'Preencha todos os campos.';
        } else {
            try {
                $userModel->create($username, $password, $ds_function);
                $_SESSION['sucesso'] = 'Usuário cadastrado com sucesso!';
            } catch (\PDOException $e) {
                if ($e->getCode() == 23000) { // Constraint de UNIQUE
                    $_SESSION['erro'] = 'Este nome de usuário já existe.';
                } else {
                    $_SESSION['erro'] = 'Erro ao cadastrar usuário.';
                }
            }
        }
        header('Location: ../views/cadastro.php');
        exit;
    }
}
?>