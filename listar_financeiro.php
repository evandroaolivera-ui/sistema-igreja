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
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

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
            border-radius:12px;
            overflow:hidden;
        }

        th{
            background:#166534;
            color:white;
            padding:15px;
            text-align:center;
        }

        td{
            padding:15px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        tr:hover{
            background:#f1f5f9;
        }

        .novo{
            background:#16a34a;
            color:white;
            padding:12px 18px;
            border-radius:8px;
            text-decoration:none;
            display:inline-block;
            margin-bottom:20px;
            transition:0.3s;
        }

        .novo:hover{
            background:#15803d;
        }

        .valor{
            font-weight:bold;
            color:#166534;
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

            <td>
                <?= $item['id'] ?>
            </td>

            <td>
                <?= $item['membro'] ?>
            </td>

            <td>
                <?= $item['tipo'] ?>
            </td>

            <td class="valor">

                R$
                <?= number_format($item['valor'],2,',','.') ?>

            </td>

            <td>
                <?= $item['data_lancamento'] ?>
            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
