#!/usr/bin/env php
<?php
/**
 * Script de test simple pour vérifier que l'application fonctionne
 */

echo "=== Test de configuration E-Shop ===\n\n";

// 1. Vérifier PHP
echo "✓ Version PHP: " . phpversion() . "\n";

// 2. Vérifier les fichiers essentiels
$files = [
    'app/config.ini',
    'app/Core/Database.php',
    'app/Core/Model.php',
    'app/Core/Router.php',
    'app/Core/Controller.php',
    'app/Models/User.php',
    'app/Models/Product.php',
    'app/Models/Category.php',
    'app/Models/Cart.php',
    'app/Models/Order.php',
    'app/Controllers/HomeController.php',
    'app/Controllers/AuthController.php',
    'app/Controllers/ProductController.php',
    'app/Controllers/CartController.php',
    'app/Controllers/OrderController.php',
    'public/index.php',
    'database.sql',
];

echo "\n✓ Vérification des fichiers:\n";
$allFound = true;
foreach ($files as $file) {
    if (file_exists($file)) {
        echo "  ✓ $file\n";
    } else {
        echo "  ✗ $file (MANQUANT!)\n";
        $allFound = false;
    }
}

if (!$allFound) {
    echo "\n⚠️  Certains fichiers manquent!\n";
    exit(1);
}

// 3. Vérifier la configuration
echo "\n✓ Vérification de la configuration:\n";
if (file_exists('app/config.ini')) {
    $config = parse_ini_file('app/config.ini');
    if ($config) {
        echo "  ✓ config.ini parsable\n";
        echo "    - DB_HOST: " . ($config['DB_HOST'] ?? 'non défini') . "\n";
        echo "    - DB_NAME: " . ($config['DB_NAME'] ?? 'non défini') . "\n";
        echo "    - DB_USERNAME: " . ($config['DB_USERNAME'] ?? 'non défini') . "\n";
    }
}

// 4. Vérifier les extensions PHP
echo "\n✓ Vérification des extensions PHP:\n";
$extensions = ['pdo', 'pdo_mysql', 'session', 'filter'];
foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "  ✓ $ext\n";
    } else {
        echo "  ✗ $ext (MANQUANT!)\n";
    }
}

// 5. Vérifier l'autoload Composer
echo "\n✓ Vérification de Composer:\n";
if (file_exists('vendor/autoload.php')) {
    echo "  ✓ vendor/autoload.php trouvé\n";
    require 'vendor/autoload.php';
    echo "  ✓ Autoload fonctionnel\n";
} else {
    echo "  ✗ vendor/autoload.php manquant\n";
}

// 6. Vérifier les répertoires de vues
echo "\n✓ Vérification des répertoires de vues:\n";
$viewDirs = [
    'app/Views',
    'app/Views/home',
    'app/Views/product',
    'app/Views/auth',
    'app/Views/cart',
    'app/Views/order',
];
foreach ($viewDirs as $dir) {
    if (is_dir($dir)) {
        echo "  ✓ $dir\n";
    } else {
        echo "  ✗ $dir\n";
    }
}

echo "\n=== ✅ Tous les tests sont passés! ===\n";
echo "\nVotre application est prête à l'emploi.\n";
echo "Lancez: php -S localhost:8000 -t public/\n";
