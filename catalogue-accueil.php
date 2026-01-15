<main class="main-content catalogue-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <div class="navigation-back">
        <a href="accueil.php" class="btn-back">← Retour à l'accueil</a>
    </div>

    <section class="hero-search">
        <div class="hero-content">
            <h1>Catalogue Documentaire</h1>
            <p class="subtitle">Plus de 50 000 références physiques et numériques à votre disposition.</p>
            
            <form action="connexion.php" method="post" class="search-form-large">
                <div class="input-group">
                    <input type="text" name="q" placeholder="Rechercher un titre, un auteur, un mot-clé..." class="search-input">
                    <button type="submit" class="search-btn">Chercher</button>
                </div>
            </form>
            
            <p class="advanced-search-link">
                <a href="connexion.php">Recherche avancée</a>
            </p>
        </div>
    </section>

    <section class="categories-section">
        <h2 class="section-title">Explorer par domaine</h2>
        
        <div class="categories-grid">
            <a href="connexion.php" class="category-card">
                <div class="img-wrapper">
                    <img src="medias/sciences.jpg" alt="Sciences et Ingénierie">
                </div>
                <h3>Sciences & Ingénierie</h3>
            </a>

            <a href="connexion.php" class="category-card">
                <div class="img-wrapper">
                    <img src="medias/droit.jpg" alt="Économie et Droit">
                </div>
                <h3>Économie & Droit</h3>
            </a>

            <a href="connexion.php" class="category-card">
                <div class="img-wrapper">
                    <img src="medias/lettre.jpg" alt="Lettres et Sciences Humaines">
                </div>
                <h3>Lettres & Sciences Humaines</h3>
            </a>
        </div>
    </section>

    <hr class="section-divider">

    <section class="acquisitions-section">
        <h2 class="section-title">📚 Les dernières acquisitions</h2>
        
        <div class="acquisitions-grid">
            
            <article class="card-highlight theme-tech">
                <h3>Sélection Informatique</h3>
                <ul class="book-list">
                    <li><strong>Le code propre (Clean Code)</strong> - R. Martin</li>
                    <li><strong>L'IA expliquée aux humains</strong> - J. Poik</li>
                    <li><strong>Sécurité des réseaux</strong> (3ème éd.)</li>
                </ul>
                <a href="connexion.php" class="btn-text">Voir tout →</a>
            </article>

            <article class="card-highlight theme-culture">
                <h3>Sélection Culture</h3>
                <ul class="book-list">
                    <li><strong>Revue "Le Monde Diplomatique"</strong> - Janvier 2026</li>
                    <li><strong>L'anomalie</strong> - H. Le Tellier</li>
                    <li><strong>Cinéma : Le guide ultime</strong></li>
                </ul>
                <a href="connexion.php" class="btn-text">Voir tout →</a>
            </article>

        </div>
    </section>

</main>