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

/**
 * Récupère tous les utilisateurs
 * @return array
 */
public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT * FROM user ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM user WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouvel utilisateur
     * @return bool
     */
    public function save()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO user (nom, email) VALUES (?, ?)");
        return $stmt->execute([$this->nom, $this->email]);
    }

    /**
     * Met à jour les informations d’un utilisateur existant
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE user SET nom = ?, email = ? WHERE id = ?");
        return $stmt->execute([$this->nom, $this->email, $this->id]);
    }

    /**
     * Supprime un utilisateur
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM user WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
