<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}

$estoque_total = 0;
$estoque = $conn->query("SELECT SUM(preco * quantidade) AS total FROM pecas");
if($estoque && $estoque->num_rows > 0) $estoque_total = $estoque->fetch_assoc()['total'] ?? 0;

$total_vendas = 0;
$vendas = $conn->query("
    SELECT SUM(pecas.preco * vendas.quantidade) AS total 
    FROM vendas JOIN pecas ON vendas.id_peca = pecas.id_peca
");
if($vendas) $total_vendas = $vendas->fetch_assoc()['total'] ?? 0;

$total_compras = 0;
$compras = $conn->query("SELECT SUM(valor_unitario * quantidade) AS total FROM compras");
if($compras) $total_compras = $compras->fetch_assoc()['total'] ?? 0;

$lucro = $total_vendas - $total_compras;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Balanceamento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-page">

<header>Balanceamento Geral</header>

<div class="container">

    <div style="background: #1c1c1c; padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 5px solid #ff9900;">
        <h2>Valor Total em Estoque</h2>
        <p style="font-size: 24px; margin-top: 10px;">R$ <?= number_format($estoque_total,2,",",".") ?></p>
    </div>

    <div style="background: #1c1c1c; padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 5px solid #007bff;">
        <h2>Total de Vendas</h2>
        <p style="font-size: 24px; margin-top: 10px;">R$ <?= number_format($total_vendas,2,",",".") ?></p>
    </div>

    <div style="background: #1c1c1c; padding: 20px; border-radius: 10px; margin-bottom: 15px; border-left: 5px solid #dc3545;">
        <h2>Total de Compras</h2>
        <p style="font-size: 24px; margin-top: 10px;">R$ <?= number_format($total_compras,2,",",".") ?></p>
    </div>

    <div style="background: #1c1c1c; padding: 20px; border-radius: 10px; border-left: 5px solid <?= $lucro >= 0 ? '#28a745' : '#dc3545' ?>;">
        <h2>Lucro Atual</h2>
        <p style="font-size: 24px; margin-top: 10px; color: <?= $lucro >= 0 ? '#28a745' : '#ff4d4d' ?>;">
            R$ <?= number_format($lucro,2,",",".") ?>
        </p>
    </div>

    <a href="dashboard.php">⬅ Voltar ao Dashboard</a>

</div>

</body>
</html>
