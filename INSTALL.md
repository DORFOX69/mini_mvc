# Guide d'Installation - E-Shop E-Commerce

## 📋 Prérequis

- **PHP** 7.4 ou supérieur
- **MySQL** 5.7 ou supérieur (ou MariaDB)
- **Un serveur web** (Apache, Nginx) OU utiliser le serveur intégré PHP pour le développement

## 🚀 Étapes d'installation

### 1. Préparer la base de données

**Avec MySQL en ligne de commande :**

```bash
# Ouvrir MySQL
mysql -u root -p

# Exécuter le script SQL
mysql -u root -p < database.sql
```

**Avec phpMyAdmin :**
1. Accéder à `http://localhost/phpmyadmin`
2. Créer une nouvelle base de données nommée `ecommerce`
3. Importer le fichier `database.sql` via l'interface d'importation

### 2. Configurer la base de données

Éditer le fichier `app/config.ini` avec vos paramètres MySQL :

```ini
DB_NAME = "ecommerce"
DB_HOST = "127.0.0.1"
DB_USERNAME = "root"           # Votre utilisateur MySQL
DB_PASSWORD = "your_password"  # Votre mot de passe
DB_PORT = "3306"               # Port MySQL (3306 par défaut)
```

### 3. Lancer l'application

**Option A - Serveur intégré PHP (Développement)**

```bash
# Depuis le répertoire du projet
cd mini_mvc
php -S localhost:8000 -t public/
```

Accéder à : `http://localhost:8000`

**Option B - Apache**

1. Placer le dossier dans `htdocs` (XAMPP) ou `www` (WAMP)
2. Configurer un VirtualHost pointant vers le dossier `public/`
3. Accéder via le navigateur : `http://votre-domain.local`

**Option C - Nginx**

```nginx
server {
    listen 80;
    server_name eshop.local;
    root /var/www/html/mini_mvc/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

## 🔐 Identifiants de test

Une fois l'installation terminée, connectez-vous avec :

| Champ | Valeur |
|-------|--------|
| **Email** | `test@example.com` |
| **Mot de passe** | `password` |

Ou créer un nouveau compte via la page d'inscription.

## 📦 Structure des fichiers

```
mini_mvc/
├── app/
│   ├── config.ini              # Configuration BD ⚙️
│   ├── Controllers/            # Contrôleurs MVC
│   ├── Core/                   # Classes de base
│   ├── Models/                 # Modèles de données
│   └── Views/                  # Templates HTML
├── public/
│   └── index.php               # Point d'entrée
├── vendor/                     # Dépendances Composer
├── database.sql                # Script SQL 🗄️
├── README_ECOMMERCE.md         # Documentation principale
└── composer.json               # Configuration Composer
```

## ✅ Vérification de l'installation

Après le démarrage du serveur, vérifier :

- ✓ La page d'accueil s'affiche
- ✓ Les produits sont visibles
- ✓ La connexion fonctionne
- ✓ L'ajout au panier est possible
- ✓ La création de commande fonctionne

## 🛠️ Dépannage

### Erreur : "Class not found"
- Vérifier que les fichiers modèles sont dans le bon dossier
- Vérifier les namespaces dans les classes

### Erreur de connexion BD
- Vérifier les paramètres dans `app/config.ini`
- S'assurer que MySQL est démarré
- Vérifier les droits d'accès utilisateur MySQL

### Erreur 404
- S'assurer que le serveur pointe vers le dossier `public/`
- Vérifier que les routes sont correctement enregistrées dans `public/index.php`

### Problème de session
- S'assurer que PHP peut écrire dans le répertoire tmp
- Vérifier les permissions des répertoires

## 📝 Notes importantes

- Le script `database.sql` crée des tables avec les données de test
- Les mots de passe sont hashés avec bcrypt (sécurisé)
- Les requêtes SQL utilisent des prepared statements (sécurisé)
- L'application est adaptée aux mobiles (responsive)

## 🔄 Mise à jour

Pour réinitialiser la base de données :

```bash
mysql -u root -p ecommerce < database.sql
```

Cela supprimera toutes les données et rétablira les données de test.

## 📞 Support

Pour toute question ou problème d'installation, consulter la documentation complète dans `README_ECOMMERCE.md`.

---

**Prêt à démarrer ! Bonne utilisation ! 🎉**
