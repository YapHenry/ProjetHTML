<?php include 'header.php'; ?>
<main class="main-content projection-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <div class="navigation-back">
        <a href="accueil_users.php" class="btn-back">← Retour à l'accueil</a>
    </div>

    <header class="page-header">
        <h1>Ciné-Club de la Bibliothèque</h1>
        <p>Chaque vendredi, découvrez une œuvre majeure du cinéma.</p>
    </header>

    <hr class="section-divider">

    <section class="movie-hero">
        
        <div class="poster-frame">
            <img src="medias/projection.jpg" alt="Affiche du film Metropolis" class="poster-img">
        </div>

        <div class="movie-details">
            <div class="event-badge">
                📅 Projection : Vendredi 17 Octobre à 18h30
            </div>

            <h2 class="movie-title">METROPOLIS</h2>
            
            <ul class="movie-meta-list">
                <li><strong>Réalisateur :</strong> Fritz Lang (1927)</li>
                <li><strong>Durée :</strong> 2h 33min</li>
                <li><strong>Genre :</strong> Science-Fiction / Drame</li>
                <li><strong>Lieu :</strong> Amphithéâtre Principal</li>
            </ul>
        </div>

    </section>

    <section class="content-block movie-synopsis">
        <h3>Synopsis</h3>
        
        <div class="text-content">
            <p>
                En 2026, Metropolis est une mégalopole divisée en deux : en haut, le quartier des riches, oisifs et intellectuels ; 
                en bas, la ville souterraine où les ouvriers triment sans relâche pour faire fonctionner la cité.
            </p>
            <p>
                Freder, le fils du dirigeant de Metropolis, découvre par hasard la misère du monde d'en bas en tombant amoureux de Maria, 
                une jeune femme qui prêche la paix aux ouvriers. Alors que la révolte gronde, un savant fou crée un robot à l'image de Maria pour semer le chaos.
            </p>
            <p class="highlight-text">
                <em>Ce chef-d'œuvre du cinéma expressionniste allemand est une vision prémonitoire de la société industrielle et reste, 
                près d'un siècle plus tard, une référence visuelle incontournable.</em>
            </p>
        </div>
    </section>

</main>
<?php include 'footer.php'; ?>