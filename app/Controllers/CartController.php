<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Cart;
use Mini\Models\Product;

/**
 * Contrôleur CartController - Gère le panier
 */
class CartController extends Controller
{
    /**
     * Affiche le panier
     */
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $cartModel = new Cart();
        $items = $cartModel->getByUser((int)$_SESSION['user_id']);
        $total = $cartModel->getTotal((int)$_SESSION['user_id']);
        
        $this->render('cart/index', [
            'items' => $items,
            'total' => $total
        ]);
    }

    /**
     * Ajoute un produit au panier
     */
    public function add(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $productId = $_POST['product_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 1);
        
        if (!$productId || !is_numeric($productId) || $quantity <= 0) {
            $_SESSION['error'] = 'Produit invalide';
            header('Location: /');
            exit;
        }
        
        // Vérification du stock
        $productModel = new Product();
        $product = $productModel->findById((int)$productId);
        
        if (!$product || $product['stock'] < $quantity) {
            $_SESSION['error'] = 'Stock insuffisant';
            header('Location: /product/show?id=' . $productId);
            exit;
        }
        
        $cartModel = new Cart();
        $cartModel->addProduct((int)$_SESSION['user_id'], (int)$productId, $quantity);
        
        $_SESSION['success'] = 'Produit ajouté au panier';
        
        // Redirection selon la source
        $referer = $_SERVER['HTTP_REFERER'] ?? '/cart';
        header('Location: ' . $referer);
        exit;
    }

    /**
     * Met à jour la quantité d'un article
     */
    public function updateQuantity(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $cartId = $_POST['cart_id'] ?? null;
        $quantity = (int)($_POST['quantity'] ?? 0);
        
        if (!$cartId || !is_numeric($cartId)) {
            $_SESSION['error'] = 'Article invalide';
            header('Location: /cart');
            exit;
        }
        
        $cartModel = new Cart();
        $cartModel->updateQuantity((int)$cartId, $quantity);
        
        if ($quantity <= 0) {
            $_SESSION['success'] = 'Article supprimé du panier';
        } else {
            $_SESSION['success'] = 'Quantité mise à jour';
        }
        
        header('Location: /cart');
        exit;
    }

    /**
     * Supprime un article du panier
     */
    public function remove(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $cartId = $_POST['cart_id'] ?? null;
        
        if (!$cartId || !is_numeric($cartId)) {
            $_SESSION['error'] = 'Article invalide';
            header('Location: /cart');
            exit;
        }
        
        $cartModel = new Cart();
        $cartModel->removeItem((int)$cartId);
        
        $_SESSION['success'] = 'Article supprimé';
        header('Location: /cart');
        exit;
    }

    /**
     * Vide complètement le panier
     */
    public function clear(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $cartModel = new Cart();
        $cartModel->clear((int)$_SESSION['user_id']);
        
        $_SESSION['success'] = 'Panier vidé';
        header('Location: /cart');
        exit;
    }
}
