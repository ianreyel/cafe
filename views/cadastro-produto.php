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
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container login-container">
        <!-- Mantendo a estrutura visual que você já criou -->
        <div class="login-right" style="width: 100%;">
            <h2 class="login-title">Novo Produto</h2>

            <form id="formProduto">
                <div class="input-group">
                    <label>Nome do Produto</label>
                    <input type="text" name="nome" placeholder="Ex: Coca-Cola 350ml" required autofocus>
                </div>
                <br>
                <div class="input-group">
                    <label>Preço de Venda (R$)</label>
                    <input type="number" name="preco" step="0.01" min="0.01" placeholder="0,00" required>
                </div>
                
                <button type="submit" class="btn-entrar" style="margin-top: 20px;">Salvar Produto</button>
            </form>
            
            <!-- Mensagem de feedback do JS -->
            <div id="mensagem-servidor" style="margin-top: 15px; font-weight: bold; text-align: center;"></div> 
        </div>
    </div>

    <script>
        document.getElementById('formProduto').addEventListener('submit', function (e) {
            e.preventDefault(); 
            
            let formData = new FormData(this);
            let divMsg = document.getElementById('mensagem-servidor');
            
            divMsg.innerHTML = "Salvando...";
            divMsg.style.color = "gray";

            fetch('../controllers/ProdutoController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                divMsg.innerHTML = data.mensagem;
                
                if (data.status === 'sucesso') {
                    divMsg.style.color = "green";
                    this.reset(); // Limpa os campos para cadastrar o próximo rápido
                    document.querySelector('input[name="nome"]').focus(); // Volta o cursor pro nome
                } else {
                    divMsg.style.color = "red";
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                divMsg.innerHTML = "Erro de comunicação com o servidor.";
                divMsg.style.color = "red";
            });
        });
    </script>
</body>
</html>