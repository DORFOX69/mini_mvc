<?php
// scripts/test_search.php
require __DIR__ . '/../vendor/autoload.php';

// Simulate GET param
$_GET['q'] = 'Laptop';

// Start session if needed by views
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Mini\Controllers\ProductController;

$controller = new ProductController();
$controller->search();
