<?php

$host = "dpg-d7udiireo5us73cvg7k0-a.oregon-postgres.render.com";
$dbname = "igreja_db_wams";
$user = "igreja_db_wams_user";
$password = "lC9jH9W3cJJ0QXrk1sJBUr3Hoy2fqfJ0";
$port = "5432";
try {

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch (PDOException $e) {

    echo "Erro na conexão: " . $e->getMessage();
}
?>
