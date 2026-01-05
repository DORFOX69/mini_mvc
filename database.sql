-- ============================================
-- SCRIPT DE CRÉATION DE LA BASE DE DONNÉES
-- E-COMMERCE EN PHP VANILLA
-- ============================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

-- ============================================
-- TABLE: CATEGORIES
-- ============================================
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: PRODUCTS
-- ============================================
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT NOT NULL,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: USERS
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(100),
    postal_code VARCHAR(20),
    country VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: CARTS
-- ============================================
CREATE TABLE IF NOT EXISTS carts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: ORDERS
-- ============================================
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLE: ORDER_ITEMS
-- ============================================
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERTION DE DONNÉES DE TEST
-- ============================================

-- Catégories
INSERT INTO categories (name, description) VALUES 
('Électronique', 'Produits électroniques et informatiques'),
('Vêtements', 'Vêtements et accessoires'),
('Livres', 'Livres et publications'),
('Maison', 'Articles pour la maison'),
('Sports', 'Équipements sportifs');

-- Produits
INSERT INTO products (name, description, price, stock, category_id, image_url) VALUES 
('Laptop HP', 'Laptop haute performance avec processeur Intel i7', 899.99, 15, 1, 'https://via.placeholder.com/300?text=Laptop'),
('Souris sans fil', 'Souris ergonomique sans fil avec batterie longue durée', 25.99, 50, 1, 'https://via.placeholder.com/300?text=Souris'),
('Clavier mécanique', 'Clavier mécanique RGB avec switches Cherry MX', 129.99, 30, 1, 'https://via.placeholder.com/300?text=Clavier'),
('T-Shirt coton', 'T-shirt 100% coton confortable', 19.99, 100, 2, 'https://via.placeholder.com/300?text=Tshirt'),
('Jeans bleu', 'Jeans classique bleu foncé', 49.99, 75, 2, 'https://via.placeholder.com/300?text=Jeans'),
('PHP Design Patterns', 'Livre complet sur les patterns PHP modernes', 39.99, 20, 3, 'https://via.placeholder.com/300?text=Livre'),
('Lampe LED', 'Lampe de bureau LED ajustable', 35.99, 40, 4, 'https://via.placeholder.com/300?text=Lampe'),
('Ballon football', 'Ballon de football officiel de match', 34.99, 25, 5, 'https://via.placeholder.com/300?text=Ballon'),
('Raquette tennis', 'Raquette de tennis professionnelle', 149.99, 12, 5, 'https://via.placeholder.com/300?text=Raquette'),
('Chaussures de sport', 'Baskets de running haute performance', 89.99, 60, 2, 'https://via.placeholder.com/300?text=Chaussures');

-- Utilisateur de test
INSERT INTO users (email, password, first_name, last_name, phone, address, city, postal_code, country) VALUES 
('test@example.com', '$2y$10$wJ8e0/qzpZGJ1d.J5R8kCOz.OaVnkVLzYtOvXxpK1zH7K8m0q7b1G', 'Jean', 'Dupont', '0123456789', '123 Rue de la Paix', 'Paris', '75000', 'France'),
('admin@example.com', '$2y$10$wJ8e0/qzpZGJ1d.J5R8kCOz.OaVnkVLzYtOvXxpK1zH7K8m0q7b1G', 'Admin', 'User', '0987654321', '456 Avenue des Champs', 'Lyon', '69000', 'France');

-- INDEX pour les performances
CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_carts_user ON carts(user_id);
CREATE INDEX idx_carts_product ON carts(product_id);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_order_items_order ON order_items(order_id);
