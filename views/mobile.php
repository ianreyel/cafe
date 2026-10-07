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
    <title>Mobile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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