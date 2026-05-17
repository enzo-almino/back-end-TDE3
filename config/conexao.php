<?php

$host = 'aws-1-sa-east-1.pooler.supabase.com';
$port = '6543';
$db   = 'postgres';
$user = 'postgres.ffcjaterxosxlqvcgmiw'; 
$pass = 'EPpoaDY3MGUik3hZ';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db";
    
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false, 
    ]);

} catch (PDOException $e) {
    die("Falha ao conectar ao Supabase: " . $e->getMessage());
}

return $pdo;