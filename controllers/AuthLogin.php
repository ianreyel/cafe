<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/User.php';
header('Content-Type: application/json');

$userModel = new User($pdo);

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$user = $userModel->findByUsername($username);

if (!$user) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário não encontrado.']);
    exit;
}

if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['ds_function'] = $user['ds_function'];
            
    // REVISADO: Define para onde o usuário vai com base na função
    $url_destino = ($user['ds_function'] === 'garcom') ? 'home.php' : 'home.php';
    
    echo json_encode([
        'status' => 'sucesso', 
        'mensagem' => 'Login realizado com sucesso!',
        'redirect' => $url_destino
    ]);
    exit;   
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Usuário ou senha inválidos.']);
    exit;
}
?>