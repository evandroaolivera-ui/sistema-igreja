<?php

require_once "config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $cargo = $_POST["cargo"];
    $data_batismo = $_POST["data_batismo"];
    $status = $_POST["status"];

    $sql = "INSERT INTO membros
    (nome, telefone, endereco, cargo, data_batismo, status)
    VALUES
    (:nome, :telefone, :endereco, :cargo, :data_batismo, :status)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':endereco' => $endereco,
        ':cargo' => $cargo,
        ':data_batismo' => $data_batismo,
        ':status' => $status
    ]);

    echo "<h3>Membro cadastrado com sucesso!</h3>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Membros</title>
</head>
<body>

<h1>Cadastro de Membros</h1>

<form method="POST">

    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone"><br><br>

    <label>Endereço:</label><br>
    <textarea name="endereco"></textarea><br><br>

    <label>Cargo:</label><br>
    <input type="text" name="cargo"><br><br>

    <label>Data de Batismo:</label><br>
    <input type="date" name="data_batismo"><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option>Ativo</option>
        <option>Visitante</option>
        <option>Desviado</option>
    </select><br><br>

    <button type="submit">Cadastrar</button>

</form>

</body>
</html>
