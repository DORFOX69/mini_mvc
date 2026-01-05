# E-Shop - E-Commerce en PHP Vanilla

Une application web d'e-commerce complète développée en **PHP pur** (sans framework) avec une base de données **MySQL**.

## 📋 Fonctionnalités implémentées

### ✅ Fonctionnalités minimales
- ✓ **Page d'accueil** affichant une liste de produits
- ✓ **Page détail produit** avec informations complètes
- ✓ **Système de panier** (ajout, suppression, mise à jour quantité, affichage du total)
- ✓ **Authentification utilisateur** (inscription + connexion avec hashage sécurisé)
- ✓ **Passage de commande** (validation du panier, gestion du stock)
- ✓ **Espace client** (historique des commandes avec détails)

### ✅ Fonctionnalités bonus
- ✓ **Interface responsive** et moderne avec CSS intégré
- ✓ **Gestion du stock** (vérification disponibilité, décrémentation à la commande)
- ✓ **Filtre par catégories** et recherche de produits
- ✓ **Navigation sécurisée** avec sessions PHP
- ✓ **Messages d'alerte** (succès et erreurs)

## 🏗️ Structure du projet

```
mini_mvc/
├── app/
│   ├── config.ini              # Configuration de la base de données
│   ├── Controllers/            # Contrôleurs MVC
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── AuthController.php
│   │   ├── CartController.php
│   │   └── OrderController.php
│   ├── Core/                   # Classes de base
│   │   ├── Controller.php      # Contrôleur de base
│   │   ├── Database.php        # Connexion MySQL (Pattern Singleton)
│   │   ├── Model.php           # Modèle de base avec méthodes CRUD
│   │   └── Router.php          # Routeur HTTP
│   ├── Models/                 # Modèles de données
│   │   ├── UserModel.php
│   │   ├── ProductModel.php
│   │   ├── CategoryModel.php
│   │   ├── CartModel.php
│   │   ├── OrderModel.php
│   │   └── OrderItemModel.php
│   └── Views/                  # Vues / Templates
│       ├── layout.php          # Layout principal
│       ├── home/
│       ├── product/
│       ├── auth/
│       ├── cart/
│       └── order/
├── public/
│   └── index.php               # Point d'entrée de l'application
├── database.sql                # Script de création de la base
├── README.md                   # Ce fichier
└── composer.json               # Configuration Composer
```

## 📦 Base de données

### Tables créées
1. **categories** - Catégories de produits
2. **products** - Catalogue de produits
3. **users** - Utilisateurs du site
4. **carts** - Articles dans les paniers
5. **orders** - Commandes des clients
6. **order_items** - Articles d'une commande

## 🚀 Installation et configuration

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Un serveur web (Apache, Nginx, etc.)

### Étapes d'installation

#### 1. **Importer la base de données**

```bash
# Via MySQL client
mysql -u root -p < database.sql

# Ou via phpMyAdmin :
# - Créer une base de données "ecommerce"
# - Importer le fichier database.sql
```

#### 2. **Configurer la connexion à la base**

Modifier `app/config.ini` :

```ini
DB_NAME = "ecommerce"
DB_HOST = "127.0.0.1"
DB_USERNAME = "root"        # Votre utilisateur MySQL
DB_PASSWORD = ""             # Votre mot de passe MySQL
DB_PORT = "3306"
```

#### 3. **Lancer l'application**

```bash
# Avec le serveur intégré de PHP (développement)
php -S localhost:8000 -t public/

# Puis accéder à : http://localhost:8000
```

## 🔐 Compte de test

Une fois la base importée, vous pouvez vous connecter avec :

**Email :** `test@example.com`  
**Mot de passe :** `password`

Ou créer un nouveau compte via la page d'inscription.

## 🎯 Flux utilisateur

### Client non authentifié
1. Accès à la liste des produits (accueil)
2. Recherche et filtrage par catégorie
3. Visualisation des détails d'un produit
4. Ajout au panier → Redirection vers login
5. Inscription ou connexion

### Client authentifié
1. Ajout de produits au panier
2. Consultation du panier
3. Modification des quantités
4. Passage à la commande
5. Validation de l'adresse de livraison
6. Création de la commande
7. Accès à l'historique des commandes

## 🔍 Détails techniques

### Architecture MVC
- **Models** : Gestion des données (héritage de `Mini\Core\Model`)
- **Views** : Affichage HTML/CSS
- **Controllers** : Logique métier (héritage de `Mini\Core\Controller`)

### Pattern Singleton
La classe `Database` utilise le pattern Singleton pour assurer une seule instance PDO.

### Sécurité
- ✓ Hashage des mots de passe avec `password_hash()` et `password_verify()`
- ✓ Préparation des requêtes SQL (PDO prepared statements)
- ✓ Échappement HTML avec `htmlspecialchars()`
- ✓ Sessions PHP pour l'authentification

### Gestion des stocks
- Vérification du stock avant ajout au panier
- Décrémentation automatique à la création d'une commande
- Gestion des erreurs en cas de stock insuffisant

## 🎨 Interface utilisateur

- **Responsive Design** : Adaptée aux mobiles et desktops
- **Navigation intuitive** : Menu principal avec recherche
- **Breadcrumb** : Navigation par fil d'Ariane
- **Messages d'alerte** : Feedback utilisateur clair
- **Palettes de couleurs** : Design moderne et épuré

## 📝 Fonctionnalités détaillées

### 1. Authentification
- Inscription avec validation
- Connexion sécurisée
- Déconnexion
- Profil utilisateur

### 2. Catalogue produits
- Liste complète avec pagination
- Filtrage par catégorie
- Recherche par terme
- Détails produit complets
- Indicateur de stock

### 3. Panier
- Ajout/suppression d'articles
- Modification des quantités
- Calcul automatique du total
- Persistance (BDD)

### 4. Commandes
- Crétion avec articles du panier
- Historique complet
- Détails de chaque commande
- Statuts : Pending, Confirmed, Shipped, Delivered, Cancelled

### 5. Espace client
- Historique des commandes
- Consultation détails
- Adresse de livraison

## 🛠️ Maintenance et évolutions

### Améliorations possibles
- [ ] Système de paiement (Stripe, PayPal)
- [ ] Notation et avis de produits
- [ ] Wishlist/Favoris
- [ ] Codes promotionnels
- [ ] Gestion administrateur
- [ ] Notifications email
- [ ] Pagination des listes
- [ ] Filtres avancés (prix, taille, couleur, etc.)

## 📧 Support

Pour des questions ou signaler des bugs : contact@eshop.com

## 📄 Licence

MIT - Libre d'utilisation

---

**Développé avec ❤️ en PHP Vanilla**
