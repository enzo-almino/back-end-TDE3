<?php

function carregarEnv($caminho) {
    if (!file_exists($caminho)) {
        return false;
    }

    $linhas = file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $linha) {
        if (strpos(trim($linha), '#') === 0) {
            continue;
        }

        if (strpos($linha, '=') !== false) {
            list($nome, $valor) = explode('=', $linha, 2);
            
            $_ENV[trim($nome)] = trim($valor);
        }
    }
}

carregarEnv(__DIR__ . '/.env');

$host = $_ENV['DB_HOST'] ?? '';
$port = $_ENV['DB_PORT'] ?? '';
$db   = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? '';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES   => false, 
    ]);

} catch (PDOException $e) {
    die("Falha ao conectar ao Supabase: " . $e->getMessage());
}

return $pdo;