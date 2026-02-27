<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}

$result = $conn->query("SELECT * FROM pecas");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard - BYD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-page">

<header>Dashboard - BYD</header>

<div class="container">
    <a href="balanceamento.php">Balanceamento</a>  |
    <a href="pecas.php">Gerenciar Peças</a> |
    <a href="clientes.php">Clientes</a> |
    <a href="vendas.php">Vendas</a> |
    <a href="logout.php">Sair</a>  

    <h2 style="margin-top: 30px;">Peças em Estoque</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço</th>
        </tr>

        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_peca'] ?></td>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= $row['quantidade'] ?></td>
            <td>R$ <?= number_format($row['preco'], 2, ',', '.') ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
