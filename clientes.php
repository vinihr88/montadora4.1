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

    $stmt = $conn->prepare("INSERT INTO clientes (nome, telefone) VALUES (?, ?)");
    if($stmt === false) die("Erro na estrutura da tabela: " . $conn->error);
    $stmt->bind_param("ss", $nome, $telefone);
    
    if($stmt->execute()){
        header("Location: clientes.php?sucesso=1");
        exit();
    } else {
        die("Erro ao salvar no banco: " . $stmt->error);
    }
}

$clientes = $conn->query("SELECT * FROM clientes ORDER BY id_cliente DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes - BYD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-page">

<header>Gerenciamento de Clientes</header>

<div class="container">
    
    <?php if(isset($_GET['sucesso'])): ?>
        <p style="color: #28a745; background: #d4edda; padding: 10px; border-radius: 5px;">
            ✅ Cliente cadastrado com sucesso!
        </p>
    <?php endif; ?>

    <h2>Novo Cadastro de Clientes</h2>
    <form method="POST" class="form-unificado" style="margin-bottom:30px;">
        <input type="text" name="nome" placeholder="Nome da empresa/cliente" required>
        <input type="text" name="telefone" placeholder="Telefone (ex: 11 99999-9999)" required>
        <button type="submit" name="cadastrar_cliente">Cadastrar</button>
    </form>

    <hr style="border-color: #333; margin: 20px 0;">

    <h2>Lista de Clientes Cadastrados</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            <?php if($clientes && $clientes->num_rows > 0): ?>
                <?php while($c = $clientes->fetch_assoc()): ?>
                <tr>
                    <td><?= $c['id_cliente'] ?></td>
                    <td><?= htmlspecialchars($c['nome']) ?></td>
                    <td><?= htmlspecialchars($c['telefone']) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align:center;">Nenhum cliente encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="dashboard.php">⬅ Voltar ao Dashboard</a>
</div>

</body>
</html>
