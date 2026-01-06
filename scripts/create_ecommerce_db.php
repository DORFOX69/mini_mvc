<?php
// create_ecommerce_db.php
$host = 'localhost';
$port = 5432;
$user = 'postgres';
$pass = '1234';
try {
    $dsn = "pgsql:host={$host};port={$port};dbname=postgres";
    $dbh = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $sql = 'CREATE DATABASE ecommerce';
    $dbh->exec($sql);
    echo "Database 'ecommerce' created successfully.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
