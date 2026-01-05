<div style="max-width: 1000px; margin: 0 auto;">
    <h1>Mes commandes</h1>
    
    <?php if (empty($orders)): ?>
        <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
            <p style="font-size: 18px; color: #7f8c8d; margin-bottom: 20px;">
                Vous n'avez pas de commandes
            </p>
            <a href="/" class="btn btn-primary">Commencer vos achats</a>
        </div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#Commande</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td style="font-weight: bold;">#<?= $order['id'] ?></td>
                        <td>
                            <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                        </td>
                        <td style="font-weight: bold;">
                            <?= number_format((float)$order['total_price'], 2, ',', ' ') ?> €
                        </td>
                        <td>
                            <?php
                            $statusLabels = [
                                'pending' => 'En attente',
                                'confirmed' => 'Confirmée',
                                'shipped' => 'Expédiée',
                                'delivered' => 'Livrée',
                                'cancelled' => 'Annulée'
                            ];
                            $statusColors = [
                                'pending' => '#f39c12',
                                'confirmed' => '#3498db',
                                'shipped' => '#2980b9',
                                'delivered' => '#27ae60',
                                'cancelled' => '#e74c3c'
                            ];
                            $status = $order['status'];
                            $label = $statusLabels[$status] ?? ucfirst($status);
                            $color = $statusColors[$status] ?? '#7f8c8d';
                            ?>
                            <span style="background: <?= $color ?>; color: white; padding: 5px 10px; border-radius: 3px; font-size: 12px;">
                                <?= $label ?>
                            </span>
                        </td>
                        <td>
                            <a href="/order/show?id=<?= $order['id'] ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                Voir détails
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
    <div style="margin-top: 30px;">
        <a href="/" class="btn btn-secondary">← Continuer vos achats</a>
    </div>
</div>
