<?php

require_once "conexao.php";

$sql = "

CREATE TABLE IF NOT EXISTS financeiro (

    id SERIAL PRIMARY KEY,
    membro VARCHAR(150),
    tipo VARCHAR(50),
    valor NUMERIC(10,2),
    data_lancamento DATE,
    observacao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

";

try {

    $pdo->exec($sql);

    echo "Tabela financeira criada com sucesso!";

} catch(PDOException $e){

    echo "Erro: " . $e->getMessage();
}

?>
