# 🚀 Démarrage rapide E-Shop

Vous avez 2 minutes pour avoir l'appli en ligne !

## ⏱️ 1. Setup base de données (30 secondes)

```bash
# Option 1 : Avec MySQL en ligne de commande
mysql -u root -p < database.sql

# Option 2 : Avec phpMyAdmin
# 1. Accédez à localhost/phpmyadmin
# 2. Créez une BD "ecommerce"
# 3. Importez database.sql
```

## ⚙️ 2. Configuration (10 secondes)

Éditer `app/config.ini` :

```ini
DB_NAME = "ecommerce"
DB_HOST = "127.0.0.1"
DB_USERNAME = "root"
DB_PASSWORD = ""
DB_PORT = "3306"
```

**Customiser si nécessaire !**

## ▶️ 3. Lancer l'app (5 secondes)

```bash
cd mini_mvc
php -S localhost:8000 -t public/
```

## 🌐 4. Accès (2 secondes)

Ouvrir : **http://localhost:8000**

## 🔐 5. Se connecter (5 secondes)

**Compte de test pré-créé :**
- Email: `test@example.com`
- Password: `password`

Ou créer un compte via "Inscription".

## ✅ Vérifier que tout fonctionne

- [x] Page d'accueil visible
- [x] Produits affichés
- [x] Connexion/Inscription fonctionnelle
- [x] Panier fonctionnel
- [x] Commandes possibles

## 🎯 Prochaines étapes

- Explorer les fonctionnalités
- Consulter [README_ECOMMERCE.md](README_ECOMMERCE.md) pour la doc complète
- Lire [INSTALL.md](INSTALL.md) pour une installation en production
- Consulter le code dans `app/` pour comprendre l'architecture

## 📞 En cas de problème

| Problème | Solution |
|----------|----------|
| Error 404 | Assurez-vous que le port 8000 n'est pas utilisé |
| Error BD | Vérifier config.ini et que MySQL est lancé |
| Pas de produits | Vérifier que database.sql a été importé |
| Session perdue | Vérifier que PHP peut écrire dans /tmp |

## 🎉 C'est tout!

Vous avez maintenant une application e-commerce **complète et fonctionnelle** !

---

**Questions ?** Consultez [README_ECOMMERCE.md](README_ECOMMERCE.md) ou [INSTALL.md](INSTALL.md)
