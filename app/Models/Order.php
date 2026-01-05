<?php

declare(strict_types=1);

namespace Mini\Models;

use Mini\Core\Model;

/**
 * Modèle Order - Gestion des commandes
 */
class Order extends Model
{
    protected string $table = 'orders';

    /**
     * Récupère les commandes d'un utilisateur
     * @param int $userId
     * @return array
     */
    public function getByUser(int $userId): array
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE user_id = ? 
                ORDER BY created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Crée une commande avec ses articles
     * @param int $userId
     * @param array $cartItems Articles du panier
     * @param float $totalPrice Prix total
     * @return int|null ID de la commande créée
     */
    public function createWithItems(int $userId, array $cartItems, float $totalPrice): ?int
    {
        try {
            // Commence une transaction
            $this->db->beginTransaction();
            
            // Crée la commande
            $orderId = $this->create([
                'user_id' => $userId,
                'total_price' => $totalPrice,
                'status' => 'pending'
            ]);
            
            // Crée les articles de la commande
            $orderItemModel = new OrderItem();
            foreach ($cartItems as $item) {
                $orderItemModel->create([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price']
                ]);
            }
            
            // Valide la transaction
            $this->db->commit();
            
            return $orderId;
        } catch (\Exception $e) {
            // Annule la transaction en cas d'erreur
            $this->db->rollBack();
            return null;
        }
    }

    /**
     * Récupère une commande avec ses articles
     * @param int $orderId
     * @return array|null
     */
    public function getWithItems(int $orderId): ?array
    {
        $order = $this->findById($orderId);
        
        if (!$order) {
            return null;
        }
        
        // Récupère les articles de la commande
        $sql = "SELECT oi.*, p.name, p.image_url
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                WHERE oi.order_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        $order['items'] = $stmt->fetchAll();
        
        return $order;
    }

    /**
     * Met à jour le statut d'une commande
     * @param int $orderId
     * @param string $status
     * @return bool
     */
    public function updateStatus(int $orderId, string $status): bool
    {
        return $this->update($orderId, ['status' => $status]);
    }
}
