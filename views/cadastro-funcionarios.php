<?php 
require_once __DIR__ . '/../config/connection.php';
if(!isset($_SESSION['user_id']) || $_SESSION['ds_function'] !== 'admin') {
    header('Location: route.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body class="bg-slate-900 flex items-center justify-center h-screen">
    <div class="bg-slate-800 p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold text-white mb-6 text-center">Novo Usuário</h2>
        
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="bg-red-500/20 text-red-400 p-3 rounded mb-4 text-sm text-center">
                <?= htmlspecialchars($_SESSION['erro']); unset($_SESSION['erro']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['sucesso'])): ?>
            <div class="bg-green-500/20 text-green-400 p-3 rounded mb-4 text-sm text-center">
                <?= htmlspecialchars($_SESSION['sucesso']); unset($_SESSION['sucesso']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="../controllers/AuthController.php?action=register">
            <div class="mb-4">
                <label class="block text-slate-300 text-sm font-bold mb-2">Usuário</label>
                <input type="text" name="username" class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-slate-300 text-sm font-bold mb-2">Senha</label>
                <input type="password" name="password" class="w-full p-3 rounded bg-slate-700 text-white border border-slate-600 focus:outline-none focus:border-blue-500" required>
            </div>

            <div class="mb-6">
                <label class="block">Função</label>
                <select name="ds_function" class="w-full p-3">
                    <option value="garcom">Garçom</option>
                    <option value="caixa">Caixa</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition">
                Cadastrar
            </button>
        </form>
    </div>
</body>
</html>