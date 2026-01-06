<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'E-Commerce' ?> - E-Shop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        header {
            background-color: #2c3e50;
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            color: white;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #3498db;
        }
        
        .user-menu {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .cart-badge {
            background-color: #e74c3c;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 12px;
        }
        
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-info {
            padding: 15px;
        }
        
        .product-name {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .product-price {
            color: #e74c3c;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .product-stock {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        
        .product-stock.low {
            color: #e74c3c;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
            font-size: 14px;
        }
        
        .btn-primary {
            background-color: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
        }
        
        .btn-success {
            background-color: #27ae60;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #229954;
        }
        
        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin: 20px 0;
        }
        
        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #2c3e50;
            color: white;
        }
        
        table tr:hover {
            background-color: #f5f5f5;
        }
        
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        
        .breadcrumb {
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }
        
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        
        .sidebar {
            width: 250px;
        }
        
        .sidebar-section {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .sidebar-section h3 {
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .sidebar-section ul {
            list-style: none;
        }
        
        .sidebar-section li {
            margin-bottom: 8px;
        }
        
        .sidebar-section a {
            color: #3498db;
            text-decoration: none;
        }
        
        .sidebar-section a:hover {
            text-decoration: underline;
        }
        
        .content {
            flex: 1;
        }
        
        .main-content {
            display: flex;
            gap: 20px;
        }
        
        @media (max-width: 768px) {
            .nav-links {
                flex-direction: column;
                gap: 10px;
            }
            
            .container {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            
            .main-content {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- En-tête de navigation -->
    <header>
        <nav>
            <a href="/" class="logo">E-Shop</a>
            <div class="nav-links">
                <a href="/">Accueil</a>
                <div class="user-menu">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <span>Bienvenue, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        <a href="/orders">Mes commandes</a>
                        <a href="/cart">🛒 Panier</a>
                        <a href="/logout" class="btn btn-secondary" style="padding: 5px 10px;">Déconnexion</a>
                    <?php else: ?>
                        <a href="/login" class="btn btn-primary" style="padding: 5px 10px;">Connexion</a>
                        <a href="/register" class="btn btn-success" style="padding: 5px 10px;">Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    
    <!-- Contenu principal -->
    <main>
        <!-- Messages d'alerte -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>
        
        <!-- Contenu rendu de la vue -->
        <?= $content ?>
    </main>
    
    <!-- Pied de page -->
    <footer>
        <p>&copy; 2026 E-Shop. Tous droits réservés. | <a href="/about" style="color: white;">À propos</a> | <a href="/contact" style="color: white;">Contact</a></p>
    </footer>
</body>
</html>

