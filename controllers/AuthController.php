<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/User.php';

$action = $_GET['action'] ?? '';
$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if ($action === 'login') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['ds_function'] = $user['ds_function'];
            
            // Redireciona com base na função
            //REVISA ISSO ZE RUELA  
            $redirect = ($user['ds_function'] === 'garcom') ? '../views/comanda.php' : '../views/caixa.php';
            header("Location: $redirect");
            exit;   
        } else {
            $_SESSION['erro'] = 'Usuário ou senha inválidos.';
            header('Location: ../views/login.php');
            exit;
        }
    }

    //AQUI FALTA OU SEPARAR OU MUDAR A ALTERAÇÃO DE SENHA
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