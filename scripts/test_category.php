<?php
require __DIR__ . '/../vendor/autoload.php';

// Simulate GET param
$_GET['category'] = '1';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use Mini\Controllers\HomeController;

$controller = new HomeController();
$controller->index();
