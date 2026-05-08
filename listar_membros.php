<?php

session_start();

if (!isset($_SESSION['usuario'])) {

    header("Location: login.php");

    exit;
}

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
            padding:30px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            box-shadow:0 2px 10px rgba(0,0,0,0.1);
        }

        th{
            background:#1e293b;
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

        .btn{
            padding:8px 12px;
            border-radius:6px;
            text-decoration:none;
            color:white;
            font-size:14px;
        }

        .editar{
            background:#2563eb;
        }

        .excluir{
            background:#dc2626;
        }

        .novo{
            background:#16a34a;
            display:inline-block;
            margin-bottom:20px;
        }

    </style>

</head>
<body>

<div class="topo">

    <h1>Lista de Membros</h1>

</div>

<div class="container">

    <a href="cadastro_membro.php"
    class="btn novo">

        Novo Membro

    </a>

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

                <a
                class="btn editar"
                href="editar_membro.php?id=<?= $membro['id'] ?>">

                    Editar

                </a>

                <a
                class="btn excluir"
                href="excluir_membro.php?id=<?= $membro['id'] ?>"
                onclick="return confirm('Deseja excluir este membro?')">

                    Excluir

                </a>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
