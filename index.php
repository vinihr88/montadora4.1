<!DOCTYPE html>
<html>
<head>
    <title>Login - BYD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page"> <header>BYD - Sistema</header>

<div class="container login-container"> <h2>Login</h2>

    <form action="login.php" method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>

    <p><a href="cadastro.php">Cadastrar</a></p>
</div>

</body>
</html>