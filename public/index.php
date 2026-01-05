<?php

declare(strict_types=1);

// Démarrage de la session
session_start();

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;

// Initialisation du routeur
$router = new Router();

// ============================================
// ROUTES PUBLIQUES
// ============================================

// Home
$router->get('/', 'Mini\Controllers\HomeController@index');
$router->get('/about', 'Mini\Controllers\HomeController@about');
$router->get('/contact', 'Mini\Controllers\HomeController@contact');

// Produits
$router->get('/product/show', 'Mini\Controllers\ProductController@show');
$router->get('/products', 'Mini\Controllers\ProductController@index');
$router->get('/search', 'Mini\Controllers\ProductController@search');

// Authentification
$router->get('/login', 'Mini\Controllers\AuthController@loginForm');
$router->post('/login', 'Mini\Controllers\AuthController@login');
$router->get('/register', 'Mini\Controllers\AuthController@registerForm');
$router->post('/register', 'Mini\Controllers\AuthController@register');
$router->get('/logout', 'Mini\Controllers\AuthController@logout');

// Panier
$router->get('/cart', 'Mini\Controllers\CartController@index');
$router->post('/cart/add', 'Mini\Controllers\CartController@add');
$router->post('/cart/update-quantity', 'Mini\Controllers\CartController@updateQuantity');
$router->post('/cart/remove', 'Mini\Controllers\CartController@remove');
$router->post('/cart/clear', 'Mini\Controllers\CartController@clear');

// Commandes
$router->get('/orders', 'Mini\Controllers\OrderController@index');
$router->get('/order/show', 'Mini\Controllers\OrderController@show');
$router->get('/checkout', 'Mini\Controllers\OrderController@checkout');
$router->post('/order/process', 'Mini\Controllers\OrderController@process');
$router->post('/order/update-shipping', 'Mini\Controllers\OrderController@updateShippingInfo');

// Pages existantes (test)
$router->get('/users', 'Mini\Controllers\HomeController@users');

// Lancement du dispatch
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
