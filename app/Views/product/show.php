<?php if (!isset($product)): ?>
    <h1>Produit non trouvé</h1>
    <p>Le produit que vous cherchez n'existe pas.</p>
    <a href="/" class="btn btn-primary">Retour à l'accueil</a>
<?php else: ?>
    <div class="breadcrumb">
        <a href="/">Accueil</a> > 
        <a href="/?category=<?= $product['category_id'] ?>">
            <?= htmlspecialchars($product['category_name']) ?>
        </a> > 
        <span><?= htmlspecialchars($product['name']) ?></span>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin: 30px 0; background: white; padding: 30px; border-radius: 8px;">
        <!-- Image du produit -->
        <div>
            <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/500') ?>" 
                 alt="<?= htmlspecialchars($product['name']) ?>" 
                 style="width: 100%; border-radius: 8px;">
        </div>
        
        <!-- Informations du produit -->
        <div>
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            
            <div style="color: #7f8c8d; margin-bottom: 20px;">
                Catégorie: <strong><?= htmlspecialchars($product['category_name']) ?></strong>
            </div>
            
            <div style="font-size: 28px; color: #e74c3c; font-weight: bold; margin-bottom: 20px;">
                <?= number_format((float)$product['price'], 2, ',', ' ') ?> €
            </div>
            
            <div style="margin-bottom: 20px;">
                <h3>Description</h3>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>
            
            <div style="margin-bottom: 20px;">
                <h3>Disponibilité</h3>
                <?php if ($product['stock'] > 0): ?>
                    <span style="color: #27ae60; font-weight: bold;">✓ En stock (<?= $product['stock'] ?> unités)</span>
                <?php else: ?>
                    <span style="color: #e74c3c; font-weight: bold;">✗ Rupture de stock</span>
                <?php endif; ?>
            </div>
            
            <?php if ($product['stock'] > 0): ?>
                <form method="POST" action="/cart/add">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    
                    <div class="form-group">
                        <label for="quantity">Quantité :</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" required>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-block" style="padding: 15px;">
                        🛒 Ajouter au panier
                    </button>
                </form>
            <?php else: ?>
                <button class="btn btn-secondary btn-block" disabled style="padding: 15px; cursor: not-allowed;">
                    Rupture de stock
                </button>
            <?php endif; ?>
            
            <a href="/" class="btn btn-secondary btn-block" style="margin-top: 10px; padding: 10px;">
                ← Retour à la liste
            </a>
        </div>
    </div>
<?php endif; ?>
