<?php
function Database(array $config)
{
    [
        'connection' => $protocol,
        'host' => $host,
        'port' => $port,
        'database' => $database,
        'username' => $username,
        'password' => $password,
    ] = $config;
    $DNS = "$protocol:host=$host;port=$port;dbname=$database";
    $pdo = new PDO($DNS, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
?>