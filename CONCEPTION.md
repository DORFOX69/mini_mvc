-- Table category
CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table product
CREATE TABLE product (
    id SERIAL PRIMARY KEY,
    category_id INT REFERENCES category(id) ON DELETE SET NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL CHECK (price >= 0),
    stock INT NOT NULL CHECK (stock >= 0),
    image VARCHAR(255),
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table customer
CREATE TABLE customer (
    id SERIAL PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    address VARCHAR(255),
    city VARCHAR(100),
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table admin
CREATE TABLE admin (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL CHECK (role IN ('admin', 'super_admin')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table orders
CREATE TABLE orders (
    id SERIAL PRIMARY KEY,
    customer_id INT REFERENCES customer(id) ON DELETE CASCADE,
    order_number VARCHAR(50) NOT NULL UNIQUE,
    status VARCHAR(20) NOT NULL CHECK (status IN ('pending', 'paid', 'shipped', 'delivered', 'cancelled')),
    total_amount DECIMAL(10,2) NOT NULL CHECK (total_amount >= 0),
    delivery_address VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table order_line
CREATE TABLE order_line (
    id SERIAL PRIMARY KEY,
    order_id INT REFERENCES orders(id) ON DELETE CASCADE,
    product_id INT REFERENCES product(id) ON DELETE RESTRICT,
    quantity INT NOT NULL CHECK (quantity > 0),
    unit_price DECIMAL(10,2) NOT NULL CHECK (unit_price >= 0),
    subtotal DECIMAL(10,2) NOT NULL CHECK (subtotal >= 0)
);

INSERT INTO category (name, description) VALUES
('Informatique', 'Ordinateurs et accessoires'),
('Téléphones', 'Smartphones et accessoires'),
('Maison', 'Meubles et décoration'),
('Vêtements', 'Homme, femme, enfants'),
('Sports', 'Équipements sportifs');

INSERT INTO product (category_id, name, description, price, stock) VALUES
(1, 'Ordinateur Portable', 'PC portable performant', 799.99, 10),
(1, 'Clavier mécanique', 'Clavier pour gamer', 49.99, 25),
(2, 'Smartphone X', 'Smartphone dernière génération', 699.99, 15),
(2, 'Écouteurs Bluetooth', 'Écouteurs sans fil', 59.99, 30),
(3, 'Canapé 3 places', 'Canapé confortable', 299.99, 5),
(3, 'Table à manger', 'Table pour 6 personnes', 199.99, 8),
(4, 'T-shirt Homme', 'T-shirt coton', 19.99, 50),
(4, 'Jean Femme', 'Jean slim', 39.99, 40),
(5, 'Vélo de montagne', 'Vélo robuste', 399.99, 8),
(5, 'Ballon de football', 'Ballon officiel', 29.99, 20);

INSERT INTO customer (first_name, last_name, email, password, address, city, postal_code) VALUES
('Alice', 'Martin', 'alice@example.com', 'password1', '12 rue A', 'Paris', '75001'),
('Bob', 'Dupont', 'bob@example.com', 'password2', '34 rue B', 'Lyon', '69002'),
('Carla', 'Petit', 'carla@example.com', 'password3', '56 rue C', 'Marseille', '13003'),
('David', 'Lemoine', 'david@example.com', 'password4', '78 rue D', 'Lille', '59000'),
('Emma', 'Durand', 'emma@example.com', 'password5', '90 rue E', 'Nice', '06000');

INSERT INTO admin (username, email, password, role) VALUES
('admin1', 'admin1@example.com', 'adminpass1', 'admin'),
('superadmin', 'superadmin@example.com', 'superpass', 'super_admin');


1. Pourquoi stocker le prix dans la ligne de commande ?

On stocke le prix dans la ligne de commande pour conserver le prix exact au moment où la commande a été passée, même si le prix du produit change plus tard.

2. Quelle stratégie de suppression avez-vous choisie et pourquoi ?

Pour les commandes, j’utilise ON DELETE CASCADE, car lorsqu’une commande est supprimée, ses lignes doivent disparaître automatiquement.
Pour les produits dans les lignes de commande, j’utilise ON DELETE RESTRICT, pour empêcher la suppression d’un produit déjà associé à une commande.
Pour les catégories, j’utilise ON DELETE SET NULL, afin qu’un produit reste existant même si sa catégorie est supprimée.

3. Comment gérez-vous les stocks ?

Le stock est vérifié avant la validation de la commande pour éviter la rupture.
Le stock est décrémenté au moment du paiement ou de la validation finale de la commande.

4. Avez-vous prévu des index ? Lesquels et pourquoi ?

Les clés primaires et les champs uniques créent automatiquement des index.
J’ajoute aussi un index sur category_id dans la table product pour accélérer les recherches et filtrages par catégorie.

5. Comment assurez-vous l’unicité du numéro de commande ?

J’utilise un champ order_number avec la contrainte UNIQUE, garantissant qu’aucune commande n’a le même numéro.

6. Quelles sont les extensions possibles du modèle ?

Plusieurs extensions sont possibles : gestion de plusieurs adresses par client, historique des prix, avis clients, ajout de plusieurs images par produit, et autres évolutions du modèle.