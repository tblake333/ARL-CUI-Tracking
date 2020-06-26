<?php

$pdo = null;
try {
    $host = 'localhost';
    $user = 'root';
    $password = 'root';
    $dbname = 'test';

    $dsn = "mysql:host=$host;dbname=$dbname";

    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $err) {
    echo "Connection failed: " . $err->getMessage();
}

?>