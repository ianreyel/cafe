<?php 
require_once __DIR__ . '/../config/connection.php';
if(!isset($_SESSION['user_id']) || $_SESSION['ds_function'] !== 'admin') {
    header('Location: route.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registar Mesa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="app-container">
        <h2>Nova Mesa</h2>
        <form id="formMesa">
            <div class="input-group">
                <label>Número da Mesa</label>
                <input type="number" name="numero" min="1" required>
            </div>
            <br>
            <div class="input-group">
                <label>Capacidade (Pessoas)</label>
                <input type="number" name="capacidade" min="1" required>
            </div>
            <br>
            <button type="submit" class="btn-entrar">Salvar Mesa</button>
        </form>
        <div id="mensagem-servidor" style="margin-top: 15px; font-weight: bold; text-align: center;"></div> 
    </div>

    <script>
        document.getElementById('formMesa').addEventListener('submit', function (e) {
            e.preventDefault(); 
            let formData = new FormData(this);
            let divMsg = document.getElementById('mensagem-servidor');
            
            divMsg.innerHTML = "A guardar...";
            divMsg.style.color = "gray";

            fetch('../controllers/MesaController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                divMsg.innerHTML = data.mensagem;
                divMsg.style.color = (data.status === 'sucesso') ? "green" : "red";
                if (data.status === 'sucesso') {
                    this.reset(); // Limpa o formulário após sucesso
                }
            })
            .catch(() => {
                divMsg.innerHTML = "Erro de comunicação com o servidor.";
                divMsg.style.color = "red";
            });
        });
    </script>
</body>
</html>