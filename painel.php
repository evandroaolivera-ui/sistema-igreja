<?php

session_start();
require_once "config/conexao.php";

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");
    exit;
}

$sqlMembros = "SELECT COUNT(*) as total FROM membros";

$stmtMembros = $pdo->query($sqlMembros);

$totalMembros = $stmtMembros->fetch(PDO::FETCH_ASSOC)['total'];

$sqlFinanceiro = "SELECT SUM(valor) as total FROM financeiro";

$stmtFinanceiro = $pdo->query($sqlFinanceiro);

$totalFinanceiro = $stmtFinanceiro->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

$sqlGrafico = "SELECT tipo, SUM(valor) as total
FROM financeiro
GROUP BY tipo";

$stmtGrafico = $pdo->query($sqlGrafico);

$dadosGrafico = $stmtGrafico->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$valores = [];

foreach($dadosGrafico as $item){

    $labels[] = $item['tipo'];
    $valores[] = $item['total'];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Painel da Igreja</title>

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
            display:flex;
        }

        .menu{
            width:250px;
            background:#0f172a;
            height:100vh;
            padding-top:20px;
        }

        .menu a{
            display:block;
            color:white;
            text-decoration:none;
            padding:15px;
            margin:5px 10px;
            border-radius:8px;
            transition:0.3s;
        }

        .menu a:hover{
            background:#334155;
        }

        .conteudo{
            flex:1;
            padding:30px;
        }

        .cards{
            display:flex;
            gap:20px;
            flex-wrap:wrap;
        }

        .card{
            background:white;
            padding:25px;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
            width:250px;
        }

        .card h2{
            margin:0;
            color:#1e293b;
        }

        .card p{
            color:#666;
        }

        .grafico-card{
            width:100%;
        }

    </style>

</head>

<body>

<div class="topo">

    <h1>Sistema da Igreja</h1>

    <h3>
        Bem-vindo,
        <?= $_SESSION['usuario'] ?>
    </h3>

</div>

<div class="container">

    <div class="menu">

        <a href="painel.php">
            Dashboard
        </a>

        <a href="cadastro_membro.php">
            Cadastrar Membro
        </a>

        <a href="listar_membros.php">
            Listar Membros
        </a>

        <a href="financeiro.php">
            Novo Lançamento
        </a>

        <a href="listar_financeiro.php">
            Relatório Financeiro
        </a>

        <a href="logout.php">
            Sair do Sistema
        </a>

    </div>

    <div class="conteudo">

        <h2>Painel Administrativo</h2>

        <div class="cards">

            <div class="card grafico-card">

                <h2>Gráfico Financeiro</h2>

                <div style="height:300px; margin-top:20px;">

                    <canvas id="graficoFinanceiro"></canvas>

                </div>

            </div>

            <div class="card">

                <h2>
                    <?= $totalMembros ?>
                </h2>

                <p>
                    Membros cadastrados
                </p>

            </div>

            <div class="card">

                <h2>

                    R$
                    <?= number_format($totalFinanceiro,2,',','.') ?>

                </h2>

                <p>
                    Total arrecadado
                </p>

            </div>

            <div class="card">

                <h2>Relatórios</h2>

                <p>
                    Visualize informações da igreja.
                </p>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener("DOMContentLoaded", function(){

    const canvas = document.getElementById('graficoFinanceiro');

    if(canvas){

        const ctx = canvas.getContext('2d');

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: <?= json_encode($labels) ?>,

                datasets: [{

                    label: 'Total Arrecadado',

                    data: <?= json_encode($valores) ?>,

                    backgroundColor: [
                        '#2563eb',
                        '#16a34a',
                        '#dc2626',
                        '#ca8a04'
                    ],

                    borderWidth: 1
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    y: {

                        beginAtZero: true
                    }
                }
            }
        });
    }

});

</script>

</body>
</html>
