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
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

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
            border-radius:12px;
            overflow:hidden;
        }

        th{
            background:#1e293b;
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

        .btn{
            padding:8px 12px;
            border-radius:6px;
            text-decoration:none;
            color:white;
            font-size:14px;
            display:inline-block;
            transition:0.3s;
        }

        .editar{
            background:#2563eb;
        }

        .editar:hover{
            background:#1d4ed8;
        }

        .excluir{
            background:#dc2626;
        }

        .excluir:hover{
            background:#b91c1c;
        }

        .novo{
            background:#16a34a;
            display:inline-block;
            margin-bottom:20px;
        }

        .novo:hover{
            background:#15803d;
        }

        .status{
            font-weight:bold;
            color:#16a34a;
        }

        .acoes{
            display:flex;
            justify-content:center;
            gap:10px;
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

            <td>
                <?= $membro['id'] ?>
            </td>

            <td>
                <?= $membro['nome'] ?>
            </td>

            <td>
                <?= $membro['telefone'] ?>
            </td>

            <td>
                <?= $membro['cargo'] ?>
            </td>

            <td class="status">
                <?= $membro['status'] ?>
            </td>

            <td>

                <div class="acoes">

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

                </div>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>

</body>
</html>
