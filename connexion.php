<main class="main-content auth-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <div class="auth-container">
        
        <section class="login-section">
    <header class="auth-header">
        <h1>Espace Lecteur</h1>
        <p>Veuillez vous identifier pour accéder aux services.</p>
    </header>

    <?php if (isset($_GET['erreur'])): ?>
        <div class="alert-box alert-warning" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <?php 
                if ($_GET['erreur'] == 'vide') {
                    echo "Merci de remplir tous les champs.";
                } elseif ($_GET['erreur'] == 'identifiants') {
                    echo "Identifiant ou mot de passe incorrect.";
                } elseif ($_GET['erreur'] == 'succes') {
                    // Petit bonus : message vert si on vient de s'inscrire
                    echo "<span style='color:green'>Compte créé ! Connectez-vous.</span>";
                }
            ?>
        </div>
    <?php endif; ?>
            <form action="traitement-connexion.php" method="post" class="auth-form">
                
                <div class="form-group">
                    <label for="auth_login">Identifiant (Login)</label>
                    <input type="text" id="auth_login" name="login" autocomplete="username" required class="form-input" placeholder="Votre identifiant">
                </div>

                <div class="form-group">
                    <label for="auth_pass">Mot de passe</label>
                    <input type="password" id="auth_pass" name="password" autocomplete="current-password" required class="form-input" placeholder="••••••••">
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-full">Se connecter</button>
                </div>
                
            </form>
        </section>

        <section class="signup-section">
            <div class="signup-content">
                <h2>Première visite ?</h2>
                <p>Vous n'avez pas encore de compte lecteur ?</p>
                
                <p class="signup-info">
                    L'inscription est <strong>obligatoire</strong> pour emprunter des ouvrages, 
                    réserver des salles de travail et accéder au Wi-Fi.
                </p>
                
                <a href="inscription.php" class="btn btn-outline">Créer un compte maintenant</a>
            </div>
        </section>
        
    </div>

</main>