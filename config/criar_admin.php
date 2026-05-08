<?php

require_once "conexao.php";

$nome = "Administrador";
$email = "admin@igreja.com";

$senha = password_hash("123456", PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios
(nome, email, senha)
VALUES
(:nome, :email, :senha)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':nome' => $nome,
    ':email' => $email,
    ':senha' => $senha
]);

echo "Usuário administrador criado com sucesso!";
?>
