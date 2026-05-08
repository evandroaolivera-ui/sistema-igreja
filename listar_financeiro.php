<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

require_once "config/conexao.php";

$sql = "SELECT * FROM financeiro
ORDER BY id DESC";

$stmt = $pdo->query($sql);

$lancamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            padding:30px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        th{
            background:#166534;
            color:white;
            padding:15px;
        }

        td{
            padding:12px;
            border-bottom:1px solid #ddd;
        }

        tr:hover{
            background:#f1f5f9;
        }

        .novo{
            background:#16a34a;
            color:white;
            padding:10px 15px;
            border-radius:8px;
            text-decoration:none;
            display:inline-block;
            margin-bottom:20px;
        }

    </style>

</head>
<body>

<div class="topo">

    <h1>Lançamentos Financeiros</h1>

</div>

<div class="container">

    <a class="novo"
    href="financeiro.php">

        Novo Lançamento

    </a>

    <table>

        <tr>

            <th>ID</th>
            <th>Membro</th>
            <th>Tipo</th>
            <th>Valor</th>
            <th>Data</th>

        </tr>

        <?php foreach($lancamentos as $item): ?>

        <tr>

            <td><?= $item['id'] ?></td>

            <td><?= $item['membro'] ?></td>

            <td><?= $item['tipo'] ?></td>

            <td>
                R$
                <?= number_format($item['valor'],2,',','.') ?>
            </td>

            <td><?= $item['data_lancamento'] ?></td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
