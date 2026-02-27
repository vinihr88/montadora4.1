<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}

$estoque_total = 0;
$estoque = $conn->query("SELECT SUM(preco * quantidade) AS total FROM pecas");

if($estoque && $estoque->num_rows > 0){
    $estoque_total = $estoque->fetch_assoc()['total'] ?? 0;
}

$total_vendas = 0;
$vendas = $conn->query("
    SELECT SUM(pecas.preco * vendas.quantidade) AS total 
    FROM vendas
    JOIN pecas ON vendas.id_peca = pecas.id_peca
");

if($vendas){
    $total_vendas = $vendas->fetch_assoc()['total'] ?? 0;
}

$total_compras = 0;
$compras = $conn->query("
    SELECT SUM(valor_unitario * quantidade) AS total 
    FROM compras
");

if($compras){
    $total_compras = $compras->fetch_assoc()['total'] ?? 0;
}

// =======================
// LUCRO
// =======================
$lucro = $total_vendas - $total_compras;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Balanceamento Geral</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>Balanceamento Geral</header>

<div class="container">

<div class="card">
    <h2>Valor Total em Estoque</h2>
    <p>R$ <?= number_format($estoque_total,2,",",".") ?></p>
</div>

<div class="card">
    <h2>Total de Vendas</h2>
    <p>R$ <?= number_format($total_vendas,2,",",".") ?></p>
</div>

<div class="card">
    <h2>Total de Compras</h2>
    <p>R$ <?= number_format($total_compras,2,",",".") ?></p>
</div>

<div class="card lucro">
    <h2>Lucro Atual</h2>
    <p>R$ <?= number_format($lucro,2,",",".") ?></p>
</div>

<br>
<a href="dashboard.php">Voltar</a>

</div>

</body>
</html>