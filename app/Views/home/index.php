<div style="display: flex; gap: 20px;">
    <!-- Sidebar avec catégories -->
    <div class="sidebar">
        <div class="sidebar-section">
            <h3>Catégories</h3>
            <ul>
                <li><a href="/">Tous les produits</a></li>
                <?php if (isset($categories) && !empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="/?category=<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['name']) ?>
                                (<?= $category['product_count'] ?>)
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        
        <div class="sidebar-section">
            <h3>Recherche</h3>
            <form method="GET" action="/search" style="margin-bottom: 0;">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" name="q" placeholder="Rechercher un produit..." required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Rechercher</button>
            </form>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <div class="content" style="flex: 1;">
        <h1>
            <?php if (isset($selectedCategory)): ?>
                <?= htmlspecialchars($selectedCategory['name']) ?>
            <?php elseif (isset($searchTerm)): ?>
                Résultats de recherche : "<?= htmlspecialchars($searchTerm) ?>"
            <?php else: ?>
                Bienvenue à E-Shop
            <?php endif; ?>
        </h1>
        
        <?php if (empty($products)): ?>
            <p style="text-align: center; padding: 40px; color: #7f8c8d;">
                Aucun produit trouvé. Essayez une autre recherche ou catégorie.
            </p>
        <?php else: ?>
            <div class="container">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?= htmlspecialchars($product['image_url'] ?? 'https://via.placeholder.com/300') ?>" 
                                 alt="<?= htmlspecialchars($product['name']) ?>">
                        </div>
                        
                        <div class="product-info">
                            <div class="product-name">
                                <?= htmlspecialchars($product['name']) ?>
                            </div>
                            
                            <div style="font-size: 12px; color: #7f8c8d; margin-bottom: 8px;">
                                <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>
                            </div>
                            
                            <div class="product-price">
                                <?= number_format((float)$product['price'], 2, ',', ' ') ?> €
                            </div>
                            
                            <div class="product-stock <?= $product['stock'] < 5 ? 'low' : '' ?>">
                                <?php if ($product['stock'] > 0): ?>
                                    Stock: <?= $product['stock'] ?> unités
                                <?php else: ?>
                                    Rupture de stock
                                <?php endif; ?>
                            </div>
                            
                            <a href="/product/show?id=<?= $product['id'] ?>" class="btn btn-primary btn-block">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
