<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;
use Mini\Models\Category;
use Mini\Models\Cart;

/**
 * Contrôleur HomeController - Gère la page d'accueil
 */
class ProductController extends Controller
{
    /**
     * Affiche la liste de tous les produits
     */
    public function index(): void
    {
        $productModel = new Product();
        $categoryModel = new Category();
        
        $products = $productModel->getAllWithCategory();
        $categories = $categoryModel->findAll();
        
        $this->render('product/index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    /**
     * Affiche les détails d'un produit
     */
    public function show(): void
    {
        // Récupère l'ID du produit depuis l'URL (à adapter selon le routeur)
        $productId = $_GET['id'] ?? null;
        
        if (!$productId || !is_numeric($productId)) {
            http_response_code(404);
            echo '404 Product Not Found';
            return;
        }
        
        $productModel = new Product();
        $product = $productModel->getWithCategory((int)$productId);
        
        if (!$product) {
            http_response_code(404);
            echo '404 Product Not Found';
            return;
        }
        
        $this->render('product/show', ['product' => $product]);
    }

    /**
     * Filtre les produits par catégorie
     */
    public function byCategory(): void
    {
        $categoryId = $_GET['id'] ?? null;
        
        if (!$categoryId || !is_numeric($categoryId)) {
            header('Location: /');
            exit;
        }
        
        $productModel = new Product();
        $categoryModel = new Category();
        
        $category = $categoryModel->findById((int)$categoryId);
        if (!$category) {
            header('Location: /');
            exit;
        }
        
        $products = $productModel->getByCategory((int)$categoryId);
        $categories = $categoryModel->findAll();
        
        $this->render('product/index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $category
        ]);
    }

    /**
     * Recherche des produits
     */
    public function search(): void
    {
        $term = $_GET['q'] ?? '';
        $products = [];
        
        if (strlen($term) >= 2) {
            $productModel = new Product();
            $products = $productModel->search($term);
        }
        
        $categoryModel = new Category();
        $categories = $categoryModel->findAll();
        
        $this->render('product/index', [
            'products' => $products,
            'categories' => $categories,
            'searchTerm' => $term
        ]);
    }
}
