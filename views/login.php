<?php 
session_start(); 
// Se já estiver logado, manda para a tela certa
if (isset($_SESSION['user_id'])) {
    header('Location: ' . ($_SESSION['ds_function'] === 'garcom' ? 'comanda.php' : 'caixa.php'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container login-container">
        <div class="login-left">
            <img src="icons/logo.jpeg" alt="Logo" class="login-logo">
        </div>
        <div class="login-right">
            <h2 class="login-title">Login</h2>

            <?php if (isset($_SESSION['erro'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?>
                </div>
            <?php endif; ?>

            <!-- Ação aponta para o Controller -->
            <form method="POST" action="../controllers/AuthController.php?action=login">
                <div class="input-group">
                    <label>Usuário</label>
                    <input type="text" name="username" required autofocus>
                </div>
                <br>
                <div class="input-group">
                    <label>Senha</label>
                    <input type="password" name="password"  required>
                </div>
                
                <button type="submit" class="btn-entrar">Entrar</button>
            </form>
        </div>
    </div>
</body>
</html>
