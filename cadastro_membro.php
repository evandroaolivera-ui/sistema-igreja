<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

require_once "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $cargo = $_POST["cargo"];
    $data_batismo = $_POST["data_batismo"];
    $status = $_POST["status"];

    $sql = "INSERT INTO membros
    (nome, telefone, endereco, cargo, data_batismo, status)
    VALUES
    (:nome, :telefone, :endereco, :cargo, :data_batismo, :status)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':endereco' => $endereco,
        ':cargo' => $cargo,
        ':data_batismo' => $data_batismo,
        ':status' => $status
    ]);

    $sucesso = "Membro cadastrado com sucesso!";
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Cadastro de Membros</title>

    <style>

        body{
            margin:0;
            font-family:Arial;
            background:#f4f6f9;
        }

        .topo{
            background:#1e293b;
            color:white;
            padding:20px;
        }

        .container{
            max-width:700px;
            margin:30px auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        input,
        textarea,
        select{
            width:100%;
            padding:12px;
            margin-top:5px;
            margin-bottom:20px;
            border:1px solid #ccc;
            border-radius:8px;
        }

        button{
            background:#1e293b;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#334155;
        }

        .sucesso{
            background:#dcfce7;
            color:#166534;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
        }

        .voltar{
            display:inline-block;
            margin-top:20px;
            text-decoration:none;
            color:#1e293b;
        }

    </style>

</head>
<body>

<div class="topo">

    <h1>Cadastro de Membros</h1>

</div>

<div class="container">

    <?php if(isset($sucesso)): ?>

        <div class="sucesso">
            <?= $sucesso ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Nome</label>

        <input type="text"
        name="nome"
        required>

        <label>Telefone</label>

        <input type="text"
        name="telefone">

        <label>Endereço</label>

        <textarea name="endereco"></textarea>

        <label>Cargo</label>

        <input type="text"
        name="cargo">

        <label>Data de Batismo</label>

        <input type="date"
        name="data_batismo">

        <label>Status</label>

        <select name="status">

            <option>Ativo</option>
            <option>Visitante</option>
            <option>Desviado</option>

        </select>

        <button type="submit">
            Cadastrar Membro
        </button>

    </form>

    <a class="voltar"
    href="listar_membros.php">

        ← Voltar para lista

    </a>

</div>

</body>
</html>
