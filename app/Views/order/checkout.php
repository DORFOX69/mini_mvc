<div style="max-width: 1000px; margin: 0 auto;">
    <h1>Valider votre commande</h1>
    
    <?php if (empty($items)): ?>
        <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
            <p style="font-size: 18px; color: #7f8c8d; margin-bottom: 20px;">
                Votre panier est vide
            </p>
            <a href="/" class="btn btn-primary">Continuer vos achats</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px;">
            <!-- Formulaire -->
            <div>
                <form method="POST" action="/order/update-shipping" style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                    <h2>Adresse de livraison</h2>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Prénom :</label>
                            <input type="text" value="<?= htmlspecialchars($user['first_name']) ?>" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label>Nom :</label>
                            <input type="text" value="<?= htmlspecialchars($user['last_name']) ?>" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Adresse :</label>
                        <input type="text" id="address" name="address" 
                               value="<?= htmlspecialchars($user['address'] ?? '') ?>" required>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="city">Ville :</label>
                            <input type="text" id="city" name="city" 
                                   value="<?= htmlspecialchars($user['city'] ?? '') ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="postal_code">Code postal :</label>
                            <input type="text" id="postal_code" name="postal_code" 
                                   value="<?= htmlspecialchars($user['postal_code'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Pays :</label>
                        <input type="text" id="country" name="country" 
                               value="<?= htmlspecialchars($user['country'] ?? 'France') ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                        Mettre à jour l'adresse
                    </button>
                </form>
                
                <div style="background: white; padding: 20px; border-radius: 8px;">
                    <h2>Détails de la commande</h2>
                    
                    <table style="margin: 20px 0;">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th style="text-align: right;">Prix</th>
                                <th style="text-align: center;">Quantité</th>
                                <th style="text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td style="text-align: right;">
                                        <?= number_format((float)$item['price'], 2, ',', ' ') ?> €
                                    </td>
                                    <td style="text-align: center;"><?= $item['quantity'] ?></td>
                                    <td style="text-align: right;">
                                        <?= number_format((float)$item['total'], 2, ',', ' ') ?> €
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Résumé du panier -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: fit-content;">
                <h2 style="margin-bottom: 20px;">Résumé de commande</h2>
                
                <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                    <span>Sous-total :</span>
                    <strong><?= number_format($total, 2, ',', ' ') ?> €</strong>
                </div>
                
                <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                    <span>Livraison :</span>
                    <strong>Gratuite</strong>
                </div>
                
                <div style="border-top: 2px solid #ddd; padding-top: 10px; margin-bottom: 30px; display: flex; justify-content: space-between;">
                    <span style="font-size: 16px; font-weight: bold;">Total :</span>
                    <span style="font-size: 18px; font-weight: bold; color: #e74c3c;">
                        <?= number_format($total, 2, ',', ' ') ?> €
                    </span>
                </div>
                
                <form method="POST" action="/order/process">
                    <button type="submit" class="btn btn-success btn-block" style="padding: 15px; margin-bottom: 10px; font-weight: bold;">
                        ✓ Confirmer la commande
                    </button>
                </form>
                
                <a href="/cart" class="btn btn-secondary btn-block" style="padding: 10px;">
                    ← Retour au panier
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
