<!DOCTYPE html>
<html>
<head>
    <title>Login - BYD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

<div class="login-panel">
    <h2>Login do Sistema - BYD</h2>
    <form action="login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
    <p><a href="cadastro.php">Cadastrar usuario</a></p>
</div>

</body>
</html>
