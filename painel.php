<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Painel</title>
</head>
<body>

<h1>Painel da Igreja</h1>

<h3>
Bem-vindo,
<?= $_SESSION['usuario'] ?>
</h3>

<ul>

    <li>
        <a href="cadastro_membro.php">
            Cadastrar Membro
        </a>
    </li>

    <li>
        <a href="listar_membros.php">
            Listar Membros
        </a>
    </li>

</ul>

</body>
</html>
