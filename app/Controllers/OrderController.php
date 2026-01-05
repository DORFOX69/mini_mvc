<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Order;
use Mini\Models\Cart;
use Mini\Models\Product;
use Mini\Models\User;

/**
 * Contrôleur OrderController - Gère les commandes
 */
class OrderController extends Controller
{
    /**
     * Affiche les commandes de l'utilisateur
     */
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $orderModel = new Order();
        $orders = $orderModel->getByUser((int)$_SESSION['user_id']);
        
        $this->render('order/index', ['orders' => $orders]);
    }

    /**
     * Affiche les détails d'une commande
     */
    public function show(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $orderId = $_GET['id'] ?? null;
        
        if (!$orderId || !is_numeric($orderId)) {
            http_response_code(404);
            echo '404 Order Not Found';
            return;
        }
        
        $orderModel = new Order();
        $order = $orderModel->getWithItems((int)$orderId);
        
        if (!$order || $order['user_id'] !== (int)$_SESSION['user_id']) {
            http_response_code(404);
            echo '404 Order Not Found';
            return;
        }
        
        $this->render('order/show', ['order' => $order]);
    }

    /**
     * Affiche la page de paiement/validation
     */
    public function checkout(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $cartModel = new Cart();
        $items = $cartModel->getByUser((int)$_SESSION['user_id']);
        $total = $cartModel->getTotal((int)$_SESSION['user_id']);
        
        if (empty($items)) {
            $_SESSION['error'] = 'Votre panier est vide';
            header('Location: /cart');
            exit;
        }
        
        $userModel = new User();
        $user = $userModel->findById((int)$_SESSION['user_id']);
        
        $this->render('order/checkout', [
            'items' => $items,
            'total' => $total,
            'user' => $user
        ]);
    }

    /**
     * Traite la validation de la commande
     */
    public function process(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $userId = (int)$_SESSION['user_id'];
        $cartModel = new Cart();
        $items = $cartModel->getByUser($userId);
        
        if (empty($items)) {
            $_SESSION['error'] = 'Votre panier est vide';
            header('Location: /cart');
            exit;
        }
        
        // Vérifier le stock de chaque produit
        $productModel = new Product();
        foreach ($items as $item) {
            if (!$productModel->decreaseStock($item['product_id'], $item['quantity'])) {
                $_SESSION['error'] = 'Stock insuffisant pour le produit: ' . $item['name'];
                header('Location: /checkout');
                exit;
            }
        }
        
        $total = $cartModel->getTotal($userId);
        
        // Créer la commande
        $orderModel = new Order();
        $orderId = $orderModel->createWithItems($userId, $items, $total);
        
        if ($orderId) {
            // Vider le panier
            $cartModel->clear($userId);
            
            $_SESSION['success'] = 'Commande créée avec succès!';
            header('Location: /order/show?id=' . $orderId);
            exit;
        }
        
        $_SESSION['error'] = 'Erreur lors de la création de la commande';
        header('Location: /checkout');
        exit;
    }

    /**
     * Met à jour l'adresse de livraison avant la commande
     */
    public function updateShippingInfo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /checkout');
            exit;
        }
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
        
        $userId = (int)$_SESSION['user_id'];
        
        $userModel = new UserModel();
        $updated = $userModel->update($userId, [
            'address' => $_POST['address'] ?? '',
            'city' => $_POST['city'] ?? '',
            'postal_code' => $_POST['postal_code'] ?? '',
            'country' => $_POST['country'] ?? ''
        ]);
        
        if ($updated) {
            $_SESSION['success'] = 'Adresse mise à jour';
        }
        
        header('Location: /checkout');
        exit;
    }
}
