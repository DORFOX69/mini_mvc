<?php

declare(strict_types=1);

namespace Mini\Models;

use Mini\Core\Model;

/**
 * Modèle OrderItem - Articles d'une commande
 */
class OrderItem extends Model
{
    protected string $table = 'order_items';
}
