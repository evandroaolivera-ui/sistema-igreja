<?php

require_once "config/conexao.php";

$id = $_GET['id'];

$sql = "DELETE FROM membros WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

echo "<h3>Membro excluído com sucesso!</h3>";

echo "<a href='listar_membros.php'>
Voltar para lista
</a>";

?>
