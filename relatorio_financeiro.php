<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

require_once "config/conexao.php";

$mes = $_GET['mes'] ?? date('m');
$buscaMembro = $_GET['busca_membro'] ?? '';

$sql = "

SELECT
    membro,
    tipo,
    COALESCE(SUM(valor),0) as total

FROM financeiro

WHERE EXTRACT(MONTH FROM data_lancamento) = :mes

";

if($buscaMembro != ''){

    $sql .= " AND membro ILIKE :membro ";

}

$sql .= "

GROUP BY membro, tipo

ORDER BY membro ASC

";

$stmt = $pdo->prepare($sql);

$params = [
    ':mes' => $mes
];

if($buscaMembro != ''){

    $params[':membro'] = "%".$buscaMembro."%";

}

$stmt->execute($params);

$relatorio = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlBusca = "
SELECT DISTINCT membro
FROM financeiro
ORDER BY membro ASC
";

$stmtBusca = $pdo->query($sqlBusca);

$membrosBusca = $stmtBusca->fetchAll(PDO::FETCH_ASSOC);

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

select,
input{
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    min-width:220px;
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

.relatorio-info{
    margin-top:20px;
    margin-bottom:20px;
    padding:15px;
    background:#ecfdf5;
    border-left:5px solid #166534;
    border-radius:8px;
}

.titulo-impressao{
    display:none;
    text-align:center;
    margin-bottom:20px;
}

.data-impressao{
    font-size:14px;
    color:#555;
}

#resultadoBusca{
    position:absolute;
    background:white;
    width:100%;
    max-height:200px;
    overflow-y:auto;
    border:1px solid #ccc;
    border-radius:8px;
    z-index:999;
    margin-top:5px;
    display:none;
}

.itemBusca{
    padding:10px;
    cursor:pointer;
    border-bottom:1px solid #eee;
}

.itemBusca:hover{
    background:#f1f5f9;
}

@media print {

    @page{
        size:A4;
        margin:15mm;
    }

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
    input,
    label,
    #resultadoBusca{
        display:none;
    }

    .titulo-impressao{
        display:block;
    }

    table{
        font-size:14px;
    }

    th{
        background:#166534 !important;
        color:white !important;
    }

    .card{
        padding:0;
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

        <div class="titulo-impressao">

            <h1>Relatório Financeiro da Igreja</h1>

            <p class="data-impressao">
                Emitido em <?= date('d/m/Y H:i') ?>
            </p>

        </div>

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

            <div style="position:relative;">

                <input
                type="text"
                id="buscaMembro"
                name="busca_membro"
                placeholder="Digite o nome do membro"
                value="<?= $buscaMembro ?>"
                autocomplete="off">

                <div id="resultadoBusca"></div>

            </div>

            <button type="submit">
                Pesquisar
            </button>

            <button
            type="button"
            onclick="window.print()">

                Imprimir

            </button>

        </form>

        <div class="relatorio-info">

            <strong>Mês selecionado:</strong>
            <?= $mes ?>

            <?php if($buscaMembro != ''): ?>

                <br>

                <strong>Pesquisa:</strong>
                <?= $buscaMembro ?>

            <?php endif; ?>

        </div>

        <table>

            <tr>

                <th>Membro</th>
                <th>Tipo</th>
                <th>Total</th>

            </tr>

            <?php foreach($relatorio as $item): ?>

            <?php $totalGeral += (float)$item['total']; ?>

            <tr>

                <td>
                    <?= $item['membro'] ?>
                </td>

                <td>
                    <?= $item['tipo'] ?>
                </td>

                <td class="total">

                    R$
                    <?= number_format((float)$item['total'],2,',','.') ?>

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

<script>

const membros = [

<?php foreach($membrosBusca as $m): ?>

    "<?= addslashes($m['membro']) ?>",

<?php endforeach; ?>

];

const input = document.getElementById('buscaMembro');
const resultado = document.getElementById('resultadoBusca');

input.addEventListener('keyup', function(){

    let valor = this.value.toLowerCase();

    resultado.innerHTML = '';

    if(valor == ''){

        resultado.style.display = 'none';
        return;
    }

    let filtrados = membros.filter(nome =>
        nome.toLowerCase().includes(valor)
    );

    if(filtrados.length > 0){

        resultado.style.display = 'block';

        filtrados.forEach(nome => {

            let div = document.createElement('div');

            div.classList.add('itemBusca');

            div.innerText = nome;

            div.onclick = function(){

                input.value = nome;

                resultado.style.display = 'none';
            }

            resultado.appendChild(div);

        });

    }else{

        resultado.style.display = 'none';
    }

});

</script>

</body>
</html>
