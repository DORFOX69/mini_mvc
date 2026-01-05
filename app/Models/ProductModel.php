<?php

declare(strict_types=1);

namespace Mini\Models;

use Mini\Core\Model;

/**
 * Modèle Product - Gestion des produits
 */
class Product extends Model
{
    protected string $table = 'products';

    /**
     * Récupère tous les produits avec leurs catégories
     * @return array
     */
    public function getAllWithCategory(): array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les produits d'une catégorie
     * @param int $categoryId
     * @return array
     */
    public function getByCategory(int $categoryId): array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                JOIN categories c ON p.category_id = c.id
                WHERE p.category_id = ?
                ORDER BY p.name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère un produit avec sa catégorie
     * @param int $id
     * @return array|null
     */
    public function getWithCategory(int $id): ?array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                JOIN categories c ON p.category_id = c.id
                WHERE p.id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result !== false ? $result : null;
    }

    /**
     * Recherche les produits par terme
     * @param string $term
     * @return array
     */
    public function search(string $term): array
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                JOIN categories c ON p.category_id = c.id
                WHERE p.name LIKE ? OR p.description LIKE ?
                ORDER BY p.name ASC";
        
        $param = "%{$term}%";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$param, $param]);
        return $stmt->fetchAll();
    }

    /**
     * Récupère les produits en stock faible
     * @param int $limit
     * @return array
     */
    public function getLowStock(int $limit = 10): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE stock < 5
                ORDER BY stock ASC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Met à jour le stock d'un produit
     * @param int $id
     * @param int $quantity Quantité à soustraire
     * @return bool
     */
    public function decreaseStock(int $id, int $quantity): bool
    {
        $sql = "UPDATE {$this->table} SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$quantity, $id, $quantity]);
    }

    /**
     * Augmente le stock d'un produit
     * @param int $id
     * @param int $quantity
     * @return bool
     */
    public function increaseStock(int $id, int $quantity): bool
    {
        $sql = "UPDATE {$this->table} SET stock = stock + ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$quantity, $id]);
    }
}
