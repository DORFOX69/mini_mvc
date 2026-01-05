<div style="max-width: 600px; margin: 50px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h1 style="text-align: center; margin-bottom: 30px;">Créer un compte</h1>
    
    <?php
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['form_data']);
    ?>
    
    <form method="POST" action="/register">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div class="form-group">
                <label for="first_name">Prénom :</label>
                <input type="text" id="first_name" name="first_name" 
                       value="<?= htmlspecialchars($formData['first_name'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Nom :</label>
                <input type="text" id="last_name" name="last_name" 
                       value="<?= htmlspecialchars($formData['last_name'] ?? '') ?>" required>
            </div>
        </div>
        
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" 
                   value="<?= htmlspecialchars($formData['email'] ?? '') ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <small style="color: #7f8c8d;">Minimum 6 caractères</small>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn btn-success btn-block" style="padding: 12px;">
            S'inscrire
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
        <p>Vous avez déjà un compte ? <a href="/login" style="color: #3498db; font-weight: bold;">Se connecter</a></p>
        <p><a href="/" style="color: #3498db;">Retour à l'accueil</a></p>
    </div>
</div>
