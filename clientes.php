<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['cadastrar_cliente'])){
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];

    $stmt = $conn->prepare("INSERT INTO clientes (nome, telefone) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $telefone);
    $stmt->execute();
}

$clientes = $conn->query("SELECT * FROM clientes");
?>

<link rel="stylesheet" href="style.css">

<header>Clientes</header>
<div class="container">

<h2>Cadastrar Cliente</h2>

<form method="POST" style="margin-bottom:30px; display:flex; gap:15px; flex-wrap:wrap;">
    <input type="text" name="nome" placeholder="Nome da empresa" required>
    <input type="text" name="telefone" placeholder="Telefone" required>
    <button type="submit" name="cadastrar_cliente">Cadastrar</button>
</form>

<h2>Lista de Clientes</h2>

<table>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Telefone</th>
</tr>

<?php while($c = $clientes->fetch_assoc()): ?>
<tr>
<td><?= $c['id_cliente'] ?></td>
<td><?= htmlspecialchars($c['nome']) ?></td>
<td><?= htmlspecialchars($c['telefone']) ?></td>
</tr>
<?php endwhile; ?>

</table>

<a href="dashboard.php">Voltar</a>

</div>