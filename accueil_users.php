<?php 
    // 1. Démarrage de la session (Indispensable pour récupérer le nom)
    session_start();

    // 2. Sécurité : Si l'utilisateur n'est pas connecté, on le redirige vers le login
    if (!isset($_SESSION['user_id'])) {
        header("Location: connexion.php");
        exit();
    }

    $page_title = "Accueil - Bibliothèque Universitaire"; 
    include 'header.php'; 
?>

<main class="main-content user-home-wrapper">
    <link rel="stylesheet" href="styles/style.css"> 

    <header class="page-header">
        <h1>Bienvenue, <span style="color: #3498db;"><?php echo htmlspecialchars($_SESSION['user_nom']); ?></span> !</h1>
        <p>Sélectionnez une thématique pour accéder à vos ressources :</p>
    </header>

    <section class="tiles-grid">
        
        <article class="tile-card">
            <img src="medias/lire.jpg" alt="Espace Lecture" class="card-bg">
            <div class="card-overlay">
                <h2>LIRE</h2>
                <p>Accéder au catalogue &<br>emprunter des ouvrages</p>
                <a href="dashboard.php" class="btn-tile">Parcourir</a>
            </div>
        </article>

        <article class="tile-card">
            <img src="medias/programme.jpg" alt="Programme et Agenda" class="card-bg">
            <div class="card-overlay">
                <h2>PROGRAMME</h2>
                <p>Agenda des événements<br>& horaires</p>
                <a href="projection.php" class="btn-tile">Voir l'événement</a>
            </div>
        </article>

        <article class="tile-card">
            <img src="medias/education.jpg" alt="Soutien scolaire" class="card-bg">
            <div class="card-overlay">
                <h2>ÉDUCATION</h2>
                <p>Aide à la thèse &<br>Soutien scolaire</p>
                <a href="livres.php" class="btn-tile">Consulter</a>
            </div>
        </article>

        <article class="tile-card">
            <img src="medias/formation.jpg" alt="Formation continue" class="card-bg">
            <div class="card-overlay">
                <h2>SE FORMER</h2>
                <p>Découvrir &<br>Nos catalogues</p>
                <a href="livres.php" class="btn-tile">Voir les formations</a> </div>
        </article>

        <article class="tile-card tile-wide">
            <img src="medias/space.jpg" alt="Culture et Arts" class="card-bg">
            <div class="card-overlay">
                <h2>CULTURE</h2>
                <p>Expositions, Détente & Rencontres</p>
                <a href="catalogue-space.php" class="btn-tile">Espace</a>
            </div>
        </article>

    </section>
</main>

<?php include 'footer.php'; ?>