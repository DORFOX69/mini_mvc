<?php

declare(strict_types=1);

namespace Mini\Models;

use Mini\Core\Model;

/**
 * Modèle Cart - Gestion du panier
 */
class Cart extends Model
{
    protected string $table = 'carts';

    /**
     * Récupère les articles du panier d'un utilisateur
     * @param int $userId
     * @return array
     */
    public function getByUser(int $userId): array
    {
        $sql = "SELECT c.*, p.name, p.price, p.stock, p.image_url,
                (p.price * c.quantity) as total
                FROM {$this->table} c
                JOIN products p ON c.product_id = p.id
                WHERE c.user_id = ?
                ORDER BY c.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Ajoute un article au panier (ou augmente la quantité)
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function addProduct(int $userId, int $productId, int $quantity = 1): bool
    {
        // Vérifie si le produit existe déjà dans le panier
        $existing = $this->findOneWhere('user_id = ? AND product_id = ?', [$userId, $productId]);
        
        if ($existing) {
            // Augmente la quantité
            $newQuantity = $existing['quantity'] + $quantity;
            return $this->update($existing['id'], ['quantity' => $newQuantity]);
        }
        
        // Sinon, crée un nouvel article
        return (bool)$this->create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }

    /**
     * Met à jour la quantité d'un article
     * @param int $cartId
     * @param int $quantity
     * @return bool
     */
    public function updateQuantity(int $cartId, int $quantity): bool
    {
        if ($quantity <= 0) {
            return $this->delete($cartId);
        }
        
        return $this->update($cartId, ['quantity' => $quantity]);
    }

    /**
     * Calcule le total du panier
     * @param int $userId
     * @return float
     */
    public function getTotal(int $userId): float
    {
        $items = $this->getByUser($userId);
        $total = 0;
        
        foreach ($items as $item) {
            $total += (float)$item['total'];
        }
        
        return round($total, 2);
    }

    /**
     * Récupère le nombre d'articles du panier
     * @param int $userId
     * @return int
     */
    public function countItems(int $userId): int
    {
        return $this->count('user_id = ?', [$userId]);
    }

    /**
     * Vide le panier d'un utilisateur
     * @param int $userId
     * @return bool
     */
    public function clear(int $userId): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId]);
    }

    /**
     * Supprime un article du panier
     * @param int $cartId
     * @return bool
     */
    public function removeItem(int $cartId): bool
    {
        return $this->delete($cartId);
    }
}
