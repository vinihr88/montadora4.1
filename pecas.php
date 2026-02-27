<?php
session_start();
include "conexao.php";

if(!isset($_SESSION['usuario'])){
    header("Location: index.php");
    exit();
}

if(isset($_POST['processar_entrada'])){
    $nome_peca = $_POST['nome_peca'];
    $quantidade = $_POST['quantidade'];
    $valor_unitario = $_POST['valor_unitario'];
    $preco_venda_sugerido = $_POST['preco_venda'] ?? ($valor_unitario * 1.3);
    $data = date("Y-m-d");

    $check = $conn->prepare("SELECT id_peca FROM pecas WHERE nome = ?");
    $check->bind_param("s", $nome_peca);
    $check->execute();
    $res = $check->get_result();

    if($res->num_rows > 0){
        $id_peca = $res->fetch_assoc()['id_peca'];
        $update = $conn->prepare("UPDATE pecas SET quantidade = quantidade + ?, preco_custo = ? WHERE id_peca = ?");
        $update->bind_param("idi", $quantidade, $valor_unitario, $id_peca);
        $update->execute();
    } else {
        $descricao = "Cadastrado via entrada de estoque";
        $ins = $conn->prepare("INSERT INTO pecas (nome, descricao, preco, preco_custo, quantidade) VALUES (?, ?, ?, ?, ?)");
        $ins->bind_param("ssddi", $nome_peca, $descricao, $preco_venda_sugerido, $valor_unitario, $quantidade);
        $ins->execute();
        $id_peca = $conn->insert_id;
    }

    $stmt = $conn->prepare("INSERT INTO compras (id_peca, quantidade, valor_unitario, data_compra) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iids", $id_peca, $quantidade, $valor_unitario, $data);
    $stmt->execute();

    echo "<script>alert('Entrada registada com sucesso!'); window.location='pecas.php';</script>";
}

$pecas_query = $conn->query("SELECT * FROM pecas");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estoque BYD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-page">

<header>Entrada de Peças (Compras)</header>

<div class="container">
    <h2>Registrar Compra</h2>
    
    <form method="POST">
        <div style="width: 100%; margin-bottom: 15px;">
            <label style="display:block; margin-bottom:5px;">Nome da Peça:</label>
            <input list="lista-pecas" name="nome_peca" id="nome_peca" placeholder="Selecione ou digite nova..." required autocomplete="off" style="width:100%;">
            <datalist id="lista-pecas">
                <?php 
                $pecas_query->data_seek(0);
                while($p = $pecas_query->fetch_assoc()): ?>
                    <option value="<?= htmlspecialchars($p['nome']) ?>">
                <?php endwhile; ?>
            </datalist>
        </div>

        <div class="form-unificado" style="width:100%;">
            <div>
                <label>Qtd:</label>
                <input type="number" name="quantidade" required style="width: 100px;">
            </div>
            <div>
                <label>Custo (R$):</label>
                <input type="number" step="0.01" name="valor_unitario" required>
            </div>
            <div>
                <label>Venda (R$):</label>
                <input type="number" step="0.01" name="preco_venda" placeholder="Opcional">
            </div>
        </div>

        <button type="submit" name="processar_entrada" style="margin-top:15px; width: auto;">Confirmar Entrada</button>
    </form>

    <hr style="border-color: #333; margin: 30px 0;">

    <h2>Inventário Atual</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Peça</th>
                <th>Custo Atual</th>
                <th>Venda</th>
                <th>Estoque</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $pecas_query->data_seek(0);
            while($p = $pecas_query->fetch_assoc()): ?>
            <tr>
                <td><?= $p['id_peca'] ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td>R$ <?= number_format($p['preco_custo'], 2, ",", ".") ?></td>
                <td>R$ <?= number_format($p['preco'], 2, ",", ".") ?></td>
                <td style="font-weight:bold; color: <?= $p['quantidade'] < 5 ? '#ff4d4d' : '#28a745' ?>;">
                    <?= $p['quantidade'] ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>
    <a href="dashboard.php">⬅ Voltar ao Painel</a>
</div>

</body>
</html>
