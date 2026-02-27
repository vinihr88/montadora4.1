<?php
include "conexao.php";

$mensagem = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE usuario = ?");
    $check->bind_param("s", $usuario);
    $check->execute();
    $res = $check->get_result();

    if($res->num_rows > 0) {
        $mensagem = "<p style='color: #ff4d4d; font-weight: bold; margin-bottom: 15px;'>❌ O usuário '$usuario' já existe!</p>";
    } else {
        $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $senha);

        if($stmt->execute()){

            echo "<script>
                    alert('✅ Administrador cadastrado com sucesso!');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            $mensagem = "<p style='color: #ff4d4d; font-weight: bold; margin-bottom: 15px;'>❌ Erro: " . $stmt->error . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - BYD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page"> <div class="login-panel"> <h2>Cadastrar Admin</h2>

    <?= $mensagem ?>

    <form method="POST">
        <input type="text" name="usuario" placeholder="Nome de Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Finalizar Cadastro</button>
    </form>

    <p><a href="index.php">⬅ Voltar ao Login</a></p>
</div>

</body>
</html>
