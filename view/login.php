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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">
    <div class="bg-slate-800 p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-3xl font-bold text-white mb-8 text-center">Entrar</h2>
        
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="bg-red-500/20 text-red-400 p-3 rounded mb-4 text-sm text-center">
                <?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../controllers/AuthController.php?action=login">
            <div class="mb-4">
                <label class="block text-slate-300 text-sm font-bold mb-2">Usuário</label>
                <input type="text" name="username" class="w-full p-4 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:border-blue-500" required autofocus>
            </div>
            
            <div class="mb-8">
                <label class="block text-slate-300 text-sm font-bold mb-2">Senha</label>
                <input type="password" name="password" class="w-full p-4 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:border-blue-500" required>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded text-lg transition">
                Acessar
            </button>
        </form>
    </div>
</body>
</html>