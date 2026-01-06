<?php
require __DIR__ . '/../vendor/autoload.php';

use Mini\Core\Database;

try {
    $pdo = Database::getPDO();
    echo "App DB connection OK\n";
    $stmt = $pdo->query("SELECT COUNT(*) FROM categories");
    $count = $stmt->fetchColumn();
    echo "categories count: " . $count . "\n";
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage() . "\n";
    exit(1);
}
