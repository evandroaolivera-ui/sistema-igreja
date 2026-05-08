<?php

session_start();

require_once "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "SELECT * FROM usuarios WHERE email = :email";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':email' => $email
    ]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {

        $_SESSION['usuario'] = $usuario['nome'];

        header("Location: painel.php");

        exit;

    } else {

        echo "<h3>Email ou senha inválidos!</h3>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h1>Login do Sistema</h1>

<form method="POST">

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha"><br><br>

    <button type="submit">
        Entrar
    </button>

</form>

</body>
</html>
