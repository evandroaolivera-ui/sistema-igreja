<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

require_once "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $membro = $_POST["membro"];
    $tipo = $_POST["tipo"];
    $valor = $_POST["valor"];
    $data = $_POST["data"];
    $observacao = $_POST["observacao"];

    $sql = "INSERT INTO financeiro
    (membro, tipo, valor, data_lancamento, observacao)
    VALUES
    (:membro, :tipo, :valor, :data, :observacao)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':membro' => $membro,
        ':tipo' => $tipo,
        ':valor' => $valor,
        ':data' => $data,
        ':observacao' => $observacao
    ]);

    $sucesso = "Lançamento registrado com sucesso!";
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Financeiro</title>

    <style>

        body{
            margin:0;
            font-family:Arial;
            background:#f4f6f9;
        }

        .topo{
            background:#166534;
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
            background:#166534;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:8px;
            cursor:pointer;
        }

        button:hover{
            background:#15803d;
        }

        .sucesso{
            background:#dcfce7;
            color:#166534;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
        }

    </style>

</head>
<body>

<div class="topo">

    <h1>Financeiro da Igreja</h1>

</div>

<div class="container">

    <?php if(isset($sucesso)): ?>

        <div class="sucesso">
            <?= $sucesso ?>
        </div>

    <?php endif; ?>

    <form method="POST">

        <label>Membro</label>

        <input type="text"
        name="membro"
        required>

        <label>Tipo</label>

        <select name="tipo">

            <option>Dízimo</option>
            <option>Oferta</option>
            <option>Missões</option>
            <option>Campanha</option>

        </select>

        <label>Valor</label>

        <input type="number"
        step="0.01"
        name="valor"
        required>

        <label>Data</label>

        <input type="date"
        name="data"
        required>

        <label>Observação</label>

        <textarea name="observacao"></textarea>

        <button type="submit">
            Salvar Lançamento
        </button>

    </form>

</div>

</body>
</html>
