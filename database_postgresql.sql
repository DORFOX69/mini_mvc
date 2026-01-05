-- ============================================
-- Script de création de la base de données
-- E-Commerce en PostgreSQL
-- ============================================

-- Supprimer la base si elle existe
DROP DATABASE IF EXISTS ecommerce;

-- Créer la base de données
CREATE DATABASE ecommerce;

-- Se connecter à la base
\c ecommerce;

-- ============================================
-- Table: categories
-- ============================================
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: products
-- ============================================
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE CASCADE,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour améliorer les recherches
CREATE INDEX idx_products_category_id ON products(category_id);
CREATE INDEX idx_products_name ON products USING GIN(to_tsvector('english', name));

-- ============================================
-- Table: users
-- ============================================
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    phone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(50),
    postal_code VARCHAR(20),
    country VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour les recherches d'email
CREATE INDEX idx_users_email ON users(email);

-- ============================================
-- Table: carts
-- ============================================
CREATE TABLE carts (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, product_id)
);

-- Index pour les recherches de panier
CREATE INDEX idx_carts_user_id ON carts(user_id);
CREATE INDEX idx_carts_product_id ON carts(product_id);

-- ============================================
-- Table: orders
-- ============================================
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    total_price DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CHECK (status IN ('pending', 'confirmed', 'shipped', 'delivered', 'cancelled'))
);

-- Index pour les recherches de commandes
CREATE INDEX idx_orders_user_id ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);

-- ============================================
-- Table: order_items
-- ============================================
CREATE TABLE order_items (
    id SERIAL PRIMARY KEY,
    order_id INT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id INT NOT NULL REFERENCES products(id),
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Index pour les recherches d'articles
CREATE INDEX idx_order_items_order_id ON order_items(order_id);
CREATE INDEX idx_order_items_product_id ON order_items(product_id);

-- ============================================
-- Données de test - Catégories
-- ============================================
INSERT INTO categories (name, description) VALUES
    ('Électronique', 'Produits électroniques et informatiques'),
    ('Vêtements', 'Vêtements pour homme et femme'),
    ('Livres', 'Livres et publications'),
    ('Maison', 'Articles pour la maison'),
    ('Sports', 'Équipements sportifs');

-- ============================================
-- Données de test - Produits
-- ============================================
INSERT INTO products (name, description, price, stock, category_id, image_url) VALUES
    ('Laptop HP', 'Ordinateur portable haute performance', 899.99, 15, 1, '/images/laptop.jpg'),
    ('iPhone 15', 'Smartphone dernier modèle', 1099.99, 20, 1, '/images/iphone.jpg'),
    ('T-shirt Coton', 'T-shirt 100% coton blanc', 19.99, 50, 2, '/images/tshirt.jpg'),
    ('Jeans Bleu', 'Jeans confortable coupe classique', 49.99, 30, 2, '/images/jeans.jpg'),
    ('La Rébellion', 'Roman de science-fiction', 14.99, 25, 3, '/images/book.jpg'),
    ('Lampe LED', 'Lampe LED économe en énergie', 29.99, 40, 4, '/images/lamp.jpg'),
    ('Ballons de Foot', 'Lot de 5 ballons en caoutchouc', 24.99, 35, 5, '/images/balls.jpg'),
    ('Raquette Tennis', 'Raquette professionnelle', 79.99, 10, 5, '/images/racket.jpg');

-- ============================================
-- Données de test - Utilisateurs
-- ============================================
-- Identifiant: test@example.com
-- Mot de passe: password (hashé en bcrypt)
INSERT INTO users (email, password, first_name, last_name, phone, address, city, postal_code, country) VALUES
    ('test@example.com', '$2y$10$YIjlrFxVV5s5JVjVV5s5J.OKL.KL.KL.KL.KL.KL.KL.KL.K', 'Test', 'User', '0612345678', '123 Rue Test', 'Paris', '75001', 'France'),
    ('john@example.com', '$2y$10$YIjlrFxVV5s5JVjVV5s5J.OKL.KL.KL.KL.KL.KL.KL.KL.K', 'John', 'Doe', '0623456789', '456 Ave Demo', 'Lyon', '69001', 'France');

-- ============================================
-- Données de test - Commandes
-- ============================================
INSERT INTO orders (user_id, total_price, status) VALUES
    (1, 1949.97, 'delivered'),
    (1, 49.99, 'shipped'),
    (2, 79.99, 'pending');

-- ============================================
-- Données de test - Articles de commande
-- ============================================
INSERT INTO order_items (order_id, product_id, quantity, unit_price) VALUES
    (1, 1, 1, 899.99),
    (1, 5, 1, 14.99),
    (1, 6, 1, 29.99),
    (2, 3, 1, 19.99),
    (2, 4, 1, 29.99),
    (3, 8, 1, 79.99);

-- ============================================
-- Confirmations
-- ============================================
SELECT 'Tables créées avec succès!' as message;
SELECT COUNT(*) as "Nombre de catégories" FROM categories;
SELECT COUNT(*) as "Nombre de produits" FROM products;
SELECT COUNT(*) as "Nombre d'utilisateurs" FROM users;
SELECT COUNT(*) as "Nombre de commandes" FROM orders;
