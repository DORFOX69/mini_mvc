<div style="max-width: 1000px; margin: 0 auto;">
    <h1>Mon panier</h1>
    
    <?php if (empty($items)): ?>
        <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
            <p style="font-size: 18px; color: #7f8c8d; margin-bottom: 20px;">
                Votre panier est vide
            </p>
            <a href="/" class="btn btn-primary">Continuer vos achats</a>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 20px;">
            <!-- Liste des articles -->
            <div>
                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th style="text-align: right;">Prix</th>
                            <th style="text-align: center;">Quantité</th>
                            <th style="text-align: right;">Total</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td>
                                    <a href="/product/show?id=<?= $item['product_id'] ?>" style="color: #3498db; text-decoration: none;">
                                        <?= htmlspecialchars($item['name']) ?>
                                    </a>
                                </td>
                                <td style="text-align: right;">
                                    <?= number_format((float)$item['price'], 2, ',', ' ') ?> €
                                </td>
                                <td style="text-align: center;">
                                    <form method="POST" action="/cart/update-quantity" style="display: inline;">
                                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" style="width: 50px;">
                                        <button type="submit" style="padding: 3px 8px; font-size: 12px;" class="btn btn-secondary">OK</button>
                                    </form>
                                </td>
                                <td style="text-align: right; font-weight: bold;">
                                    <?= number_format((float)$item['total'], 2, ',', ' ') ?> €
                                </td>
                                <td style="text-align: center;">
                                    <form method="POST" action="/cart/remove" style="display: inline;">
                                        <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                        <button type="submit" class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">✕</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Résumé du panier -->
            <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); height: fit-content;">
                <h2 style="margin-bottom: 20px;">Résumé</h2>
                
                <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                    <span>Sous-total :</span>
                    <strong><?= number_format($total, 2, ',', ' ') ?> €</strong>
                </div>
                
                <div style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                    <span>Livraison :</span>
                    <strong>Gratuite</strong>
                </div>
                
                <div style="border-top: 2px solid #ddd; padding-top: 10px; margin-bottom: 20px; display: flex; justify-content: space-between;">
                    <span style="font-size: 16px; font-weight: bold;">Total :</span>
                    <span style="font-size: 18px; font-weight: bold; color: #e74c3c;">
                        <?= number_format($total, 2, ',', ' ') ?> €
                    </span>
                </div>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/checkout" class="btn btn-success btn-block" style="padding: 12px; margin-bottom: 10px;">
                        Passer la commande
                    </a>
                <?php else: ?>
                    <a href="/login" class="btn btn-primary btn-block" style="padding: 12px; margin-bottom: 10px;">
                        Se connecter pour commander
                    </a>
                <?php endif; ?>
                
                <form method="POST" action="/cart/clear">
                    <button type="submit" class="btn btn-secondary btn-block" style="padding: 10px;">
                        Vider le panier
                    </button>
                </form>
            </div>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="/" class="btn btn-secondary">← Continuer vos achats</a>
        </div>
    <?php endif; ?>
</div>
