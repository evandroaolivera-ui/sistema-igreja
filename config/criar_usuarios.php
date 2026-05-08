<?php

require_once "conexao.php";

$sql = "

CREATE TABLE IF NOT EXISTS usuarios (

    id SERIAL PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    senha VARCHAR(255)

);

";

try {

    $pdo->exec($sql);

    echo "Tabela de usuários criada!";

} catch(PDOException $e){

    echo "Erro: " . $e->getMessage();
}
?>
