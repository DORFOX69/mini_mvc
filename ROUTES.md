# Routes de l'application E-Shop

## Routes publiques (Sans authentification requise)

### Pages principales
| Route | Méthode | Contrôleur | Description |
|-------|---------|-----------|-------------|
| `/` | GET | HomeController@index | Accueil avec liste de produits |
| `/about` | GET | HomeController@about | Page À propos |
| `/contact` | GET | HomeController@contact | Page Contact |

### Authentification
| Route | Méthode | Contrôleur | Description |
|-------|---------|-----------|-------------|
| `/login` | GET | AuthController@loginForm | Formulaire de connexion |
| `/login` | POST | AuthController@login | Traitement connexion |
| `/register` | GET | AuthController@registerForm | Formulaire inscription |
| `/register` | POST | AuthController@register | Traitement inscription |
| `/logout` | GET | AuthController@logout | Déconnexion |

### Produits
| Route | Méthode | Contrôleur | Description |
|-------|---------|-----------|-------------|
| `/products` | GET | ProductController@index | Liste complète des produits |
| `/product/show?id=X` | GET | ProductController@show | Détail d'un produit |
| `/search?q=terme` | GET | ProductController@search | Recherche par terme |

---

## Routes protégées (Authentification requise)

### Panier
| Route | Méthode | Contrôleur | Description |
|-------|---------|-----------|-------------|
| `/cart` | GET | CartController@index | Afficher le panier |
| `/cart/add` | POST | CartController@add | Ajouter un produit |
| `/cart/update-quantity` | POST | CartController@updateQuantity | Modifier la quantité |
| `/cart/remove` | POST | CartController@remove | Supprimer un article |
| `/cart/clear` | POST | CartController@clear | Vider le panier |

### Commandes
| Route | Méthode | Contrôleur | Description |
|-------|---------|-----------|-------------|
| `/orders` | GET | OrderController@index | Historique des commandes |
| `/order/show?id=X` | GET | OrderController@show | Détail d'une commande |
| `/checkout` | GET | OrderController@checkout | Page de validation |
| `/order/process` | POST | OrderController@process | Créer la commande |
| `/order/update-shipping` | POST | OrderController@updateShippingInfo | Mettre à jour adresse |

---

## Types de requête

### GET (Lecture)
- Affichage de pages
- Récupération d'informations
- Navigation

### POST (Création/Modification)
- Soumission de formulaires
- Ajout au panier
- Création de commandes
- Connexion/Inscription

---

## Paramètres URL

### `?id=X`
Utilisé pour : produit, commande, article panier
Exemple : `/product/show?id=5`

### `?q=terme`
Utilisé pour : recherche
Exemple : `/search?q=laptop`

### `?category=X`
Utilisé pour : filtrer par catégorie
Exemple : `/?category=2`

---

## Redirections

### Non authentifié
- `/cart` → `/login` (Redirection)
- `/orders` → `/login` (Redirection)
- `/checkout` → `/login` (Redirection)

### Authentifié
- `/login` → `/` (Si déjà connecté)
- `/register` → `/` (Si déjà connecté)

---

## Codes HTTP

| Code | Situation |
|------|-----------|
| 200 | OK - Requête réussie |
| 302 | Redirection - Utilisateur redirigé |
| 404 | Not Found - Page non trouvée |
| 500 | Erreur serveur |

---

## Exemples d'utilisation

### Accéder à l'accueil
```
GET http://localhost:8000/
```

### Se connecter
```
POST http://localhost:8000/login
Body: email=test@example.com&password=password
```

### Voir un produit
```
GET http://localhost:8000/product/show?id=1
```

### Ajouter au panier
```
POST http://localhost:8000/cart/add
Body: product_id=1&quantity=2
```

### Voir mes commandes
```
GET http://localhost:8000/orders
(Nécessite authentification)
```

### Chercher un produit
```
GET http://localhost:8000/search?q=laptop
```

---

## Notes de sécurité

- Les routes protégées redirigent vers `/login` si non authentifié
- Les identifiants sont vérifiés via sessions PHP
- Les données POST sont validées côté serveur
- Les requêtes SQL utilisent des prepared statements

---

**Dernière mise à jour:** 5 janvier 2026
