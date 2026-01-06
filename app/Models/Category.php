<?php

declare(strict_types=1);

namespace Mini\Models;

use Mini\Core\Model;

/**
 * Modèle Category - Gestion des catégories
 */
class Category extends Model
{
    protected string $table = 'categories';

    /**
     * Récupère les catégories avec le nombre de produits
     * @return array
     */
    public function getAllWithCount(): array
    {
        $sql = "SELECT c.*, COUNT(p.id) as product_count
                FROM {$this->table} c
                LEFT JOIN products p ON c.id = p.category_id
                GROUP BY c.id
                ORDER BY c.name ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Trouve une catégorie par son ID
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();
        return $res !== false ? $res : null;
    }
}
