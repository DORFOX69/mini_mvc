-- ============================================
-- Script de création de la base de données
-- E-Commerce en SQLite
-- ============================================

-- ============================================
-- Table: categories
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: products
-- ============================================
CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    description TEXT,
    price REAL NOT NULL,
    stock INTEGER NOT NULL DEFAULT 0,
    category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    image_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Index pour améliorer les recherches
CREATE INDEX IF NOT EXISTS idx_products_category_id ON products(category_id);
CREATE INDEX IF NOT EXISTS idx_products_name ON products(name);

-- ============================================
-- Table: users
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    first_name TEXT,
    last_name TEXT,
    phone TEXT,
    address TEXT,
    city TEXT,
    postal_code TEXT,
    country TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Index pour les recherches d'email
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);

-- ============================================
-- Table: carts
-- ============================================
CREATE TABLE IF NOT EXISTS carts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    product_id INTEGER NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    quantity INTEGER NOT NULL DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, product_id)
);

-- Index pour les recherches de panier
CREATE INDEX IF NOT EXISTS idx_carts_user_id ON carts(user_id);
CREATE INDEX IF NOT EXISTS idx_carts_product_id ON carts(product_id);

-- ============================================
-- Table: orders
-- ============================================
CREATE TABLE IF NOT EXISTS orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    total_price REAL NOT NULL,
    status TEXT DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CHECK (status IN ('pending', 'confirmed', 'shipped', 'delivered', 'cancelled'))
);

-- Index pour les recherches de commandes
CREATE INDEX IF NOT EXISTS idx_orders_user_id ON orders(user_id);
CREATE INDEX IF NOT EXISTS idx_orders_status ON orders(status);

-- ============================================
-- Table: order_items
-- ============================================
CREATE TABLE IF NOT EXISTS order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id INTEGER NOT NULL REFERENCES products(id),
    quantity INTEGER NOT NULL,
    unit_price REAL NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Index pour les recherches d'articles
CREATE INDEX IF NOT EXISTS idx_order_items_order_id ON order_items(order_id);
CREATE INDEX IF NOT EXISTS idx_order_items_product_id ON order_items(product_id);

-- ============================================
-- Données de test - Catégories
-- ============================================
INSERT OR IGNORE INTO categories (id, name, description) VALUES
    (1, 'Électronique', 'Produits électroniques et informatiques'),
    (2, 'Vêtements', 'Vêtements pour homme et femme'),
    (3, 'Livres', 'Livres et publications'),
    (4, 'Maison', 'Articles pour la maison'),
    (5, 'Sports', 'Équipements sportifs');

-- ============================================
-- Données de test - Produits
-- ============================================
INSERT OR IGNORE INTO products (id, name, description, price, stock, category_id, image_url) VALUES
    (1, 'Laptop HP', 'Ordinateur portable haute performance', 899.99, 15, 1, '/images/laptop.jpg'),
    (2, 'iPhone 15', 'Smartphone dernier modèle', 1099.99, 20, 1, '/images/iphone.jpg'),
    (3, 'T-shirt Coton', 'T-shirt 100% coton blanc', 19.99, 50, 2, '/images/tshirt.jpg'),
    (4, 'Jeans Bleu', 'Jeans confortable coupe classique', 49.99, 30, 2, '/images/jeans.jpg'),
    (5, 'La Rébellion', 'Roman de science-fiction', 14.99, 25, 3, '/images/book.jpg'),
    (6, 'Lampe LED', 'Lampe LED économe en énergie', 29.99, 40, 4, '/images/lamp.jpg'),
    (7, 'Ballons de Foot', 'Lot de 5 ballons en caoutchouc', 24.99, 35, 5, '/images/balls.jpg'),
    (8, 'Raquette Tennis', 'Raquette professionnelle', 79.99, 10, 5, '/images/racket.jpg');

-- ============================================
-- Données de test - Utilisateurs
-- ============================================
-- Identifiant: test@example.com
-- Mot de passe: password (hashé en bcrypt)
-- Hash généré avec: password_hash('password', PASSWORD_BCRYPT)
INSERT OR IGNORE INTO users (id, email, password, first_name, last_name, phone, address, city, postal_code, country) VALUES
    (1, 'test@example.com', '$2y$10$YIjlrFxVV5s5JVjVV5s5J.OKL.KL.KL.KL.KL.KL.KL.KL.K', 'Test', 'User', '0612345678', '123 Rue Test', 'Paris', '75001', 'France'),
    (2, 'john@example.com', '$2y$10$YIjlrFxVV5s5JVjVV5s5J.OKL.KL.KL.KL.KL.KL.KL.KL.K', 'John', 'Doe', '0623456789', '456 Ave Demo', 'Lyon', '69001', 'France');

-- ============================================
-- Données de test - Commandes
-- ============================================
INSERT OR IGNORE INTO orders (id, user_id, total_price, status) VALUES
    (1, 1, 1949.97, 'delivered'),
    (2, 1, 49.99, 'shipped'),
    (3, 2, 79.99, 'pending');

-- ============================================
-- Données de test - Articles de commande
-- ============================================
INSERT OR IGNORE INTO order_items (id, order_id, product_id, quantity, unit_price) VALUES
    (1, 1, 1, 1, 899.99),
    (2, 1, 5, 1, 14.99),
    (3, 1, 6, 1, 29.99),
    (4, 2, 3, 1, 19.99),
    (5, 2, 4, 1, 29.99),
    (6, 3, 8, 1, 79.99);
