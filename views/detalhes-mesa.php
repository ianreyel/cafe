<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Mesa.php';
require_once __DIR__ . '/../models/Comanda.php'; 


if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$mesaModel = new Mesa($pdo);
$mesa_id = $_GET['id'] ?? 0;
$mesa = $mesaModel->findById($mesa_id);

if (!$mesa) {
    die("Mesa não encontrada.");
}
$comandaAtual = $mesaModel->comanda_atual($mesa_id);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa <?= htmlspecialchars($mesa['numero']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-slate-900 text-white">

    <div class="app-container p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Mesa <?= htmlspecialchars($mesa['numero']) ?></h1>
            <p class="text-slate-400">Capacidade: <?= htmlspecialchars($mesa['capacidade']) ?> lugares</p>
        </div>

        <?php if ($comandaAtual): ?>
            <div class="bg-slate-800 p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-green-400">Comanda Aberta (#<?= $comandaAtual['id'] ?>)</h2>
                    <span class="text-slate-300">Total Atual: R$ <?= number_format($comandaAtual['total'], 2, ',', '.') ?></span>
                </div>

                <?php if (!empty($comandaAtual['pedidos'])): ?>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-slate-400 border-b border-slate-700">
                                <th class="pb-2">Qtd</th>
                                <th class="pb-2">Produto</th>
                                <th class="pb-2">Valor Un.</th>
                                <th class="pb-2">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($comandaAtual['pedidos'] as $item): ?>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3"><?= $item['quantidade'] ?>x</td>
                                    <td class="py-3 font-semibold"><?= htmlspecialchars($item['nome']) ?></td>
                                    <td class="py-3">R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                                    <td class="py-3 text-green-400">R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-slate-400">Nenhum item lançado nesta comanda ainda.</p>
                <?php endif; ?>
                
                <div class="mt-6 flex gap-4">
                    <button class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded font-bold">Lançar Novo Pedido</button>
                    <button class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded font-bold">Fechar Conta</button>
                </div>
            </div>

        <?php else: ?>
            <!-- SE A MESA ESTIVER LIVRE -->
            <div class="bg-slate-800 p-8 rounded-lg shadow-lg text-center border-dashed border-2 border-slate-600">
                <h2 class="text-2xl font-bold text-slate-300 mb-4">Mesa Livre</h2>
                <p class="mb-6 text-slate-400">Não há nenhuma comanda ativa para esta mesa no momento.</p>
            
                <button onclick="abrirComanda(<?= $mesa_id ?>)" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg text-lg">
                    Abrir Comanda
                </button>
            </div>
        <?php endif; ?>
        
        <br>
        <a href="home.php"> Voltar para o Mapa de Mesas</a>
    </div>

</body>
<script>
    function abrirComanda(mesaId) {
        let btn = event.target;
        btn.disabled = true;
        btn.innerHTML = "A abrir...";

        let formData = new FormData();
        formData.append('mesa_id', mesaId);

        fetch('../controllers/ComandaController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'sucesso') {
                window.location.reload();
            } else {
                alert(data.mensagem);
                btn.disabled = false;
                btn.innerHTML = "Abrir Comanda";
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert("Erro de comunicação com o servidor.");
            btn.disabled = false;
            btn.innerHTML = "Abrir Comanda";
        });
    }
</script>
</html>