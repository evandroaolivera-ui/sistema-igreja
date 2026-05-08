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

        $erro = "Email ou senha inválidos!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Login do Sistema</title>

    <style>

        body{
            margin:0;
            font-family:Arial;
            background:#0f172a;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .login-box{
            background:white;
            padding:40px;
            border-radius:12px;
            width:350px;
            box-shadow:0 5px 20px rgba(0,0,0,0.3);
        }

        h1{
            text-align:center;
            color:#1e293b;
        }

        input{
            width:100%;
            padding:12px;
            margin-top:5px;
            margin-bottom:20px;
            border:1px solid #ccc;
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            background:#1e293b;
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            font-size:16px;
        }

        button:hover{
            background:#334155;
        }

        .erro{
            color:red;
            text-align:center;
            margin-bottom:15px;
        }

    </style>

</head>
<body>

<div class="login-box">

    <h1>Login</h1>

    <?php if(isset($erro)): ?>

        <div class="erro">
            <?= $erro ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Email</label>

        <input type="email"
        name="email"
        required>

        <label>Senha</label>

        <input type="password"
        name="senha"
        required>

        <button type="submit">
            Entrar
        </button>

    </form>

</div>

</body>
</html>
