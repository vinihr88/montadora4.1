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
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>Dashboard - BYD</header>

<div class="container">
<a href="balanceamento.php">Balanceamento</a>  |
<a href="pecas.php">Gerenciar Peças</a> |
<a href="clientes.php">Clientes</a> |
<a href="vendas.php">Vendas</a> |
<a href="logout.php">Sair</a>  |

<h2>Peças em Estoque</h2>

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
<td><?= $row['nome'] ?></td>
<td><?= $row['quantidade'] ?></td>
<td>R$ <?= $row['preco'] ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>
