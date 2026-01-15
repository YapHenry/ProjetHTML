<main class="main-content auth-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <div class="auth-card-centered">
        
        <header class="auth-header">
            <h1>Inscription à la Bibliothèque</h1>
            <p>Rejoignez notre communauté et accédez à toutes nos ressources.</p>
        </header>

        <form action="traitement-inscription.php" method="post" class="styled-form">
            
            <fieldset class="form-group">
                <legend>Vos informations personnelles</legend>

                <div class="form-grid-2">
                    <div class="form-col">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" autocomplete="family-name" required class="form-input">
                    </div>

                    <div class="form-col">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" autocomplete="given-name" required class="form-input">
                    </div>
                </div>

                <div class="form-row">
                    <label for="email">Adresse Email institutionnelle :</label>
                    <input type="email" id="email" name="email" placeholder="etudiant@univ.fr" autocomplete="email" required class="form-input">
                </div>
            </fieldset>

            <fieldset class="form-group">
                <legend>Paramètres de connexion</legend>

                <div class="form-row">
                    <label for="login">Identifiant (Login) :</label>
                    <input type="text" id="login" name="login" autocomplete="username" required class="form-input">
                </div>

                <div class="form-row">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" required class="form-input">
                    <small class="form-help">Minimum 8 caractères</small>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-full">Valider l'inscription</button>
            </div>

        </form>

        <hr class="card-divider">

        <div class="auth-footer">
            <p>
                Vous avez déjà un compte ? 
                <a href="connexion.php" class="text-link"><strong>Se connecter ici</strong></a>
            </p>
        </div>

    </div>

</main>