<?php

require_once "config/conexao.php";

$id = $_GET['id'];

$sql = "SELECT * FROM membros WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([':id' => $id]);

$membro = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $cargo = $_POST["cargo"];
    $status = $_POST["status"];

    $update = "UPDATE membros
    SET nome = :nome,
        telefone = :telefone,
        cargo = :cargo,
        status = :status
    WHERE id = :id";

    $stmtUpdate = $pdo->prepare($update);

    $stmtUpdate->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':cargo' => $cargo,
        ':status' => $status,
        ':id' => $id
    ]);

    echo "<h3>Membro atualizado com sucesso!</h3>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Membro</title>
</head>
<body>

<h1>Editar Membro</h1>

<form method="POST">

    <label>Nome:</label><br>
    <input type="text" name="nome"
    value="<?= $membro['nome'] ?>"><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone"
    value="<?= $membro['telefone'] ?>"><br><br>

    <label>Cargo:</label><br>
    <input type="text" name="cargo"
    value="<?= $membro['cargo'] ?>"><br><br>

    <label>Status:</label><br>

    <select name="status">

        <option <?= $membro['status']=="Ativo"?"selected":"" ?>>
            Ativo
        </option>

        <option <?= $membro['status']=="Visitante"?"selected":"" ?>>
            Visitante
        </option>

        <option <?= $membro['status']=="Desviado"?"selected":"" ?>>
            Desviado
        </option>

    </select>

    <br><br>

    <button type="submit">Salvar Alterações</button>

</form>

</body>
</html>
