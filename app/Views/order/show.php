<div style="max-width: 1000px; margin: 0 auto;">
    <div class="breadcrumb">
        <a href="/orders">Mes commandes</a> > <span>Commande #<?= $order['id'] ?></span>
    </div>
    
    <div style="background: white; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Informations de la commande -->
            <div>
                <h2>Informations de la commande</h2>
                
                <div style="margin-bottom: 15px;">
                    <strong>Numéro :</strong> #<?= $order['id'] ?>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <strong>Date :</strong> <?= date('d/m/Y à H:i', strtotime($order['created_at'])) ?>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <strong>Statut :</strong>
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
                    <span style="background: <?= $color ?>; color: white; padding: 8px 12px; border-radius: 4px;">
                        <?= $label ?>
                    </span>
                </div>
                
                <div style="margin-bottom: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                    <strong>Total :</strong>
                    <span style="font-size: 18px; color: #e74c3c; font-weight: bold;">
                        <?= number_format((float)$order['total_price'], 2, ',', ' ') ?> €
                    </span>
                </div>
            </div>
            
            <!-- Adresse de livraison -->
            <div>
                <h2>Adresse de livraison</h2>
                
                <!-- Vous pourriez récupérer les données de livraison depuis l'utilisateur -->
                <p style="margin-bottom: 10px; font-weight: bold;">À définir selon votre système</p>
                
                <div style="background: #f5f5f5; padding: 15px; border-radius: 4px; color: #7f8c8d;">
                    <p>Les informations de livraison seront affichées ici.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Articles commandés -->
    <div style="background: white; padding: 30px; border-radius: 8px; margin-bottom: 20px;">
        <h2 style="margin-bottom: 20px;">Produits commandés</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th style="text-align: right;">Prix unitaire</th>
                    <th style="text-align: center;">Quantité</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($item['name']) ?></strong>
                        </td>
                        <td style="text-align: right;">
                            <?= number_format((float)$item['unit_price'], 2, ',', ' ') ?> €
                        </td>
                        <td style="text-align: center;"><?= $item['quantity'] ?></td>
                        <td style="text-align: right; font-weight: bold;">
                            <?= number_format((float)($item['unit_price'] * $item['quantity']), 2, ',', ' ') ?> €
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div style="text-align: right; padding-top: 15px; border-top: 1px solid #ddd; margin-top: 15px;">
            <strong style="font-size: 16px;">Total : <?= number_format((float)$order['total_price'], 2, ',', ' ') ?> €</strong>
        </div>
    </div>
    
    <!-- Actions -->
    <div>
        <a href="/orders" class="btn btn-secondary">← Retour aux commandes</a>
    </div>
</div>
