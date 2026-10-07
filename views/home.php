<?php
require_once __DIR__ . '/../config/connection.php';
require_once __DIR__ . '/../models/Mesa.php';
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$mesaModel = new Mesa($pdo);
$mesas = $mesaModel->listar();
?>
<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIDEBAR</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="app-container">
        <!-- SIDEBAR (Lado esquerdo) -->
        <div class="sidebar">
            <img src="icons/logo.jpeg" alt="Logo" class="logo-sidebar">
            <ul>
                <li>
                    <a href="#" class="selected">
                        <img src="icons/menu.svg" alt="Início">
                        <span>Início</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="icons/Basket.svg" alt="Cardapio">
                        <span>Cardapio</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="icons/Box_open.svg" alt="Pedidos">  
                        <span>Pedidos</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="icons/Group.svg" alt="Histórico">
                        <span>Histórico</span>
                    </a>
                </li>   
                <li>
                    <a href="#">
                        <img src="icons/graf.svg" alt="Caixa">
                        <span>Caixa</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <img src="icons/Settings.svg" alt="Gerencia">
                        <span>Gerencia</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- CONTEÚDO PRINCIPAL (Lado direito) -->
        <div class="main-content">
            <!-- Barra superior de pesquisa -->
            <div class="top-bar">
                <div class="search-box">Pesquisar</div>
                <div class="filter-box">Filtros</div>
            </div>

            <div class="content-area">
                <h2>Mesas disponíveis</h2>
                <?php foreach ($mesas as $mesa): ?>
                    <div class="mesa" data-id="<?= $mesa['id'] ?>">
                        <span><a href="detalhes-mesa.php?id=<?= $mesa['id'] ?>">Mesa <?= $mesa['numero'] ?></a></span>
                        <span>Capacidade: <?= $mesa['capacidade'] ?> pessoas</span>
                    </div>
                <?php endforeach; ?>
                <!-- Os quadrados das mesas entrarão aqui -->
                 <h2>Mesas indisponíveis</h2>
                 <!-- Os quadrados das mesas entrarão aqui -->
            </div>
        </div>

    </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
