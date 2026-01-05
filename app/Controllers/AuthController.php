<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

/**
 * Contrôleur AuthController - Gère l'authentification
 */
class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     */
    public function loginForm(): void
    {
        // Si l'utilisateur est déjà connecté, redirection
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        
        $this->render('auth/login');
    }

    /**
     * Traite la connexion
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Tous les champs sont obligatoires';
            header('Location: /login');
            exit;
        }
        
        $userModel = new User();
        $user = $userModel->authenticate($email, $password);
        
        if ($user) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            
            header('Location: /');
            exit;
        }
        
        $_SESSION['error'] = 'Email ou mot de passe incorrect';
        header('Location: /login');
        exit;
    }

    /**
     * Affiche le formulaire d'inscription
     */
    public function registerForm(): void
    {
        // Si l'utilisateur est déjà connecté, redirection
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        
        $this->render('auth/register');
    }

    /**
     * Traite l'inscription
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        $firstName = $_POST['first_name'] ?? '';
        $lastName = $_POST['last_name'] ?? '';
        
        // Validation
        $errors = [];
        
        if (empty($email)) {
            $errors[] = 'Email est obligatoire';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide';
        }
        
        if (empty($password)) {
            $errors[] = 'Mot de passe est obligatoire';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Le mot de passe doit contenir au moins 6 caractères';
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = 'Les mots de passe ne correspondent pas';
        }
        
        if (empty($firstName)) {
            $errors[] = 'Prénom est obligatoire';
        }
        
        if (empty($lastName)) {
            $errors[] = 'Nom est obligatoire';
        }
        
        // Vérification si l'email existe
        $userModel = new User();
        if ($userModel->emailExists($email)) {
            $errors[] = 'Cet email est déjà utilisé';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header('Location: /register');
            exit;
        }
        
        // Création de l'utilisateur
        $userId = $userModel->register([
            'email' => $email,
            'password' => $password,
            'first_name' => $firstName,
            'last_name' => $lastName
        ]);
        
        // Connexion automatique
        $_SESSION['user_id'] = $userId;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $firstName . ' ' . $lastName;
        
        $_SESSION['success'] = 'Inscription réussie! Bienvenue!';
        
        header('Location: /');
        exit;
    }

    /**
     * Déconnexion
     */
    public function logout(): void
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
