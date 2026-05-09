<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

require_once "config/conexao.php";

$mes = $_GET['mes'] ?? date('m');

$sql = "

SELECT
    membro,
    tipo,
    SUM(valor) as total

FROM financeiro

WHERE EXTRACT(MONTH FROM data_lancamento) = :mes

GROUP BY membro, tipo

ORDER BY membro ASC

";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':mes' => $mes
]);

$relatorio = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalGeral = 0;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">

<title>Relatório Financeiro</title>

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

.card{
    background:white;
    padding:25px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
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

form{
    margin-bottom:20px;
    display:flex;
    gap:10px;
    align-items:center;
    flex-wrap:wrap;
}

select{
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

button{
    padding:10px 15px;
    border:none;
    background:#166534;
    color:white;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#15803d;
}

.total{
    font-weight:bold;
    color:#166534;
}

.total-geral{
    background:#dcfce7;
    font-size:18px;
    font-weight:bold;
}

@media print {

    body{
        background:white;
    }

    .topo{
        background:white;
        color:black;
        border-bottom:2px solid black;
    }

    button,
    select,
    label{
        display:none;
    }

    .card{
        box-shadow:none;
        border:none;
    }

}

</style>

</head>

<body>

<div class="topo">

    <h1>Relatório Financeiro</h1>

</div>

<div class="container">

    <div class="card">

        <form method="GET">

            <label>Mês:</label>

            <select name="mes">

                <option value="1">Janeiro</option>
                <option value="2">Fevereiro</option>
                <option value="3">Março</option>
                <option value="4">Abril</option>
                <option value="5">Maio</option>
                <option value="6">Junho</option>
                <option value="7">Julho</option>
                <option value="8">Agosto</option>
                <option value="9">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>

            </select>

            <button type="submit">
                Filtrar
            </button>

            <button
            type="button"
            onclick="window.print()">

                Imprimir

            </button>

        </form>

        <table>

            <tr>

                <th>Membro</th>
                <th>Tipo</th>
                <th>Total</th>

            </tr>

            <?php foreach($relatorio as $item): ?>

            <?php $totalGeral += $item['total']; ?>

            <tr>

                <td>
                    <?= $item['membro'] ?>
                </td>

                <td>
                    <?= $item['tipo'] ?>
                </td>

                <td class="total">

                    R$
                    <?= number_format($item['total'],2,',','.') ?>

                </td>

            </tr>

            <?php endforeach; ?>

            <tr class="total-geral">

                <td colspan="2">
                    TOTAL GERAL
                </td>

                <td>

                    R$
                    <?= number_format($totalGeral,2,',','.') ?>

                </td>

            </tr>

        </table>

    </div>

</div>

</body>
</html>
