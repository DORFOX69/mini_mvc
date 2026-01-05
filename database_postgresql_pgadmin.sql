-- ============================================
-- Script de création des tables et données
-- E-Commerce en PostgreSQL (pour pgAdmin)
-- ============================================

-- ============================================
-- Table: categories
-- ============================================
DROP TABLE IF EXISTS order_items CASCADE;
DROP TABLE IF EXISTS orders CASCADE;
DROP TABLE IF EXISTS carts CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS products CASCADE;
DROP TABLE IF EXISTS categories CASCADE;

CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: products
-- ============================================
CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    category_id INT NOT NULL REFERENCES categories(id) ON DELETE SET NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL CHECK (price >= 0),
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    image VARCHAR(255),
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_products_category_id ON products(category_id);
CREATE INDEX idx_products_name ON products(name);

-- ============================================
-- Table: users (ou customers)
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_users_email ON users(email);

-- ============================================
-- Table: carts
-- ============================================
CREATE TABLE carts (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    product_id INT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    quantity INT NOT NULL DEFAULT 1 CHECK (quantity > 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, product_id)
);

CREATE INDEX idx_carts_user_id ON carts(user_id);
CREATE INDEX idx_carts_product_id ON carts(product_id);

-- ============================================
-- Table: orders
-- ============================================
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    total_price DECIMAL(10, 2) NOT NULL CHECK (total_price >= 0),
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'confirmed', 'shipped', 'delivered', 'cancelled')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_orders_user_id ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(status);

-- ============================================
-- Table: order_items
-- ============================================
CREATE TABLE order_items (
    id SERIAL PRIMARY KEY,
    order_id INT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id INT NOT NULL REFERENCES products(id),
    quantity INT NOT NULL CHECK (quantity > 0),
    unit_price DECIMAL(10, 2) NOT NULL CHECK (unit_price >= 0),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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
INSERT INTO products (category_id, name, description, price, stock, image, active) VALUES
    (1, 'Laptop HP', 'Ordinateur portable haute performance', 899.99, 15, '/images/laptop.jpg', true),
    (1, 'iPhone 15', 'Smartphone dernier modèle', 1099.99, 20, '/images/iphone.jpg', true),
    (2, 'T-shirt Coton', 'T-shirt 100% coton blanc', 19.99, 50, '/images/tshirt.jpg', true),
    (2, 'Jeans Bleu', 'Jeans confortable coupe classique', 49.99, 30, '/images/jeans.jpg', true),
    (3, 'La Rébellion', 'Roman de science-fiction', 14.99, 25, '/images/book.jpg', true),
    (4, 'Lampe LED', 'Lampe LED économe en énergie', 29.99, 40, '/images/lamp.jpg', true),
    (5, 'Ballons de Foot', 'Lot de 5 ballons en caoutchouc', 24.99, 35, '/images/balls.jpg', true),
    (5, 'Raquette Tennis', 'Raquette professionnelle', 79.99, 10, '/images/racket.jpg', true);

-- ============================================
-- Données de test - Utilisateurs
-- ============================================
-- Email: test@example.com
-- Mot de passe: password (hashé bcrypt)
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
SELECT 'Base de données créée avec succès!' as message;
SELECT COUNT(*) as "Catégories" FROM categories;
SELECT COUNT(*) as "Produits" FROM products;
SELECT COUNT(*) as "Utilisateurs" FROM users;
SELECT COUNT(*) as "Commandes" FROM orders;
