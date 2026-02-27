<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['vender'])){

    $id_peca = $_POST['id_peca'];
    $id_cliente = $_POST['id_cliente'];
    $quantidade = $_POST['quantidade'];
    $data = date("Y-m-d");

    $estoque = $conn->prepare("SELECT quantidade, preco FROM pecas WHERE id_peca = ?");
    $estoque->bind_param("i", $id_peca);
    $estoque->execute();
    $resultado = $estoque->get_result();
    $peca = $resultado->fetch_assoc();

    if($peca['quantidade'] < $quantidade){
        echo "<script>alert('Estoque insuficiente!');</script>";
    } else {

        $stmt = $conn->prepare("INSERT INTO vendas (id_peca, id_cliente, data_venda) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $id_peca, $id_cliente, $data);
        $stmt->execute();

        // Descontar estoque
        $update = $conn->prepare("UPDATE pecas SET quantidade = quantidade - ? WHERE id_peca = ?");
        $update->bind_param("ii", $quantidade, $id_peca);
        $update->execute();

        echo "<script>alert('Venda registrada com sucesso!');</script>";
    }
}

$pecas = $conn->query("SELECT * FROM pecas");
$clientes = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Registrar Venda</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>Registrar Venda</header>

<div class="container">

<form method="POST">

<label>Peça</label>
<select name="id_peca" required>
<?php while($p = $pecas->fetch_assoc()): ?>
<option value="<?= $p['id_peca'] ?>">
<?= $p['nome'] ?> (Estoque: <?= $p['quantidade'] ?>)
</option>
<?php endwhile; ?>
</select>

<label>Cliente</label>
<select name="id_cliente" required>
<?php while($c = $clientes->fetch_assoc()): ?>
<option value="<?= $c['id_cliente'] ?>">
<?= $c['nome'] ?>
</option>
<?php endwhile; ?>
</select>

<label>Quantidade</label>
<input type="number" name="quantidade" min="1" required>

<button type="submit" name="vender">Registrar Venda</button>

</form>

<br>
<a href="dashboard.php">Voltar</a>

</div>

</body>
</html>