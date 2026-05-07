<?php

require_once "conexao.php";

$sql = "

CREATE TABLE IF NOT EXISTS membros (

    id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    telefone VARCHAR(30),
    endereco TEXT,
    cargo VARCHAR(100),
    data_batismo DATE,
    status VARCHAR(30),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

";

try {

    $pdo->exec($sql);

    echo "Tabela de membros criada com sucesso!";

} catch (PDOException $e) {

    echo "Erro: " . $e->getMessage();
}
?>
