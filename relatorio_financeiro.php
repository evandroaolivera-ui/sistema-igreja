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
    tipo,
    SUM(valor) as total

FROM financeiro

WHERE EXTRACT(MONTH FROM data_lancamento) = :mes

GROUP BY tipo

";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':mes' => $mes
]);

$relatorio = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
}

td{
    padding:15px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

form{
    margin-bottom:20px;
}

select{
    padding:10px;
    border-radius:8px;
}

button{
    padding:10px 15px;
    border:none;
    background:#166534;
    color:white;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#15803d;
}

.total{
    font-weight:bold;
    color:#166534;
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

        </form>

        <table>

            <tr>

                <th>Tipo</th>
                <th>Total</th>

            </tr>

            <?php foreach($relatorio as $item): ?>

            <tr>

                <td>
                    <?= $item['tipo'] ?>
                </td>

                <td class="total">

                    R$
                    <?= number_format($item['total'],2,',','.') ?>

                </td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>
