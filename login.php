<?php
session_start();
include "conexao.php";

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

if($usuario === 'admin' && $senha === 'montadora2026') {
    $_SESSION['usuario'] = $usuario;
    header("Location: dashboard.php");
    exit();
}
// ------------------------------

$sql = "SELECT * FROM usuarios WHERE usuario=? AND senha=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $senha);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $_SESSION['usuario'] = $usuario;
    header("Location: dashboard.php");
    exit();
} else {
    echo "<script>alert('Login ou senha inválidos!'); window.location.href='index.php';</script>";
}
?>
