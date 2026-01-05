<?php

declare(strict_types=1);

namespace Mini\Models;

use Mini\Core\Model;

/**
 * Modèle User - Gestion des utilisateurs
 */
class User extends Model
{
    protected string $table = 'users';

    /**
     * Crée un nouvel utilisateur avec mot de passe hashé
     * @param array $data Données de l'utilisateur
     * @return int ID du nouvel utilisateur
     */
    public function register(array $data): int
    {
        // Hash du mot de passe
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        
        return $this->create($data);
    }

    /**
     * Vérifie les identifiants de connexion
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe en clair
     * @return array|null Données de l'utilisateur si valides
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findOneWhere('email = ?', [$email]);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return null;
    }

    /**
     * Récupère un utilisateur par email
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        return $this->findOneWhere('email = ?', [$email]);
    }

    /**
     * Vérifie si un email existe
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return $this->findByEmail($email) !== null;
    }
}
