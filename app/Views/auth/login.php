<div style="max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h1 style="text-align: center; margin-bottom: 30px;">Connexion</h1>
    
    <form method="POST" action="/login">
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required autofocus>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block" style="padding: 12px;">
            Se connecter
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
        <p>Pas encore de compte ? <a href="/register" style="color: #3498db; font-weight: bold;">S'inscrire</a></p>
        <p><a href="/" style="color: #3498db;">Retour à l'accueil</a></p>
    </div>
    
    <div style="margin-top: 20px; padding: 15px; background-color: #d4edda; border-radius: 4px; font-size: 12px;">
        <strong>Compte de test :</strong><br>
        Email: test@example.com<br>
        Mot de passe: password
    </div>
</div>
