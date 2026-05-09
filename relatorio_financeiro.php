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
</html>
