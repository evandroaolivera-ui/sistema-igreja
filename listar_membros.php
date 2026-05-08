<?php

require_once "config/conexao.php";

$sql = "SELECT * FROM membros ORDER BY id DESC";

$stmt = $pdo->query($sql);

$membros = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Membros</title>

    <style>

        body{
            font-family: Arial;
            margin:40px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th, td{
            border:1px solid #ccc;
            padding:10px;
            text-align:left;
        }

        th{
            background:#f0f0f0;
        }

    </style>

</head>
<body>

<h1>Lista de Membros</h1>

<table>

<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Telefone</th>
    <th>Cargo</th>
    <th>Status</th>
    <th>Ações</th>
</tr>

<?php foreach($membros as $membro): ?>

<tr>

    <td><?= $membro['id'] ?></td>
    <td><?= $membro['nome'] ?></td>
    <td><?= $membro['telefone'] ?></td>
    <td><?= $membro['cargo'] ?></td>
    <td><?= $membro['status'] ?></td>
    <td>
    <a href="editar_membro.php?id=<?= $membro['id'] ?>">
        Editar
    </a>
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>
