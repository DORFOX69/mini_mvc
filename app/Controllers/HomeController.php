<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\Product;
use Mini\Models\Category;

/**
 * Contrôleur HomeController - Gère la page d'accueil
 */
final class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec les produits vedettes
     */
    public function index(): void
    {
        $productModel = new Product();
        $categoryModel = new Category();
        // Récupère les catégories avec le compte de produits
        $categories = $categoryModel->getAllWithCount();

        // Si une catégorie est sélectionnée via ?category=ID, filtre les produits
        $selectedCategory = null;
        $products = [];

        $catId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        if ($catId && $catId > 0) {
            $selectedCategory = $categoryModel->findById($catId);
            if ($selectedCategory) {
                $products = $productModel->getByCategory((int)$catId);
            }
        } else {
            // Aucun filtre : récupérer tous les produits
            $products = $productModel->getAllWithCategory();
        }

        $this->render('home/index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'pageTitle' => 'Accueil'
        ]);
    }

    /**
     * Page des utilisateurs (page de test)
     */
    public function users(): void
    {
        $this->render('home/users', [
            'users' => ['Alice', 'Bob', 'Charlie'],
        ]);
    }

    /**
     * Page "À propos"
     */
    public function about(): void
    {
        $this->render('home/about', ['pageTitle' => 'À propos']);
    }

    /**
     * Page de contact
     */
    public function contact(): void
    {
        $this->render('home/contact', ['pageTitle' => 'Contact']);
    }
}

