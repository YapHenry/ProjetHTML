<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Bibliothèque Universitaire</title>
    <link rel="stylesheet" href="styles/accueil.css">
</head>
<body>

    <header class="main-header">
        <div class="logo-area">
            <h1>📚Ma Bibliothèque</h1>
        </div>
        <div class="user-actions">
            <a href="connexion.php" class="btn-connexion">Se connecter</a>
        </div>
    </header>

    <main class="container">
        
        <section class="hero-section">
            <h1 class="main-title">Bienvenue au Cœur du Savoir Universitaire</h1>
            
            <figure class="hero-figure">
                <img src="medias/bibliotheque.jpg" alt="Vue panoramique de la bibliothèque" class="img-hero">
                <figcaption>Explorez un monde de connaissances sans limites.</figcaption>
            </figure>

            <div class="intro-text">
                <p>
                    Bien plus qu'un simple lieu de stockage de livres, votre Bibliothèque Universitaire est un <strong>carrefour d'innovation et de découverte</strong>. 
                    Nous mettons à votre disposition un écosystème complet dédié à l'excellence académique : des millions de ressources numériques accessibles en un clic, 
                    des espaces de co-working connectés et un patrimoine littéraire inestimable. Que vous prépariez une thèse révolutionnaire ou que vous cherchiez 
                    l'inspiration pour votre prochain projet, nous sommes le catalyseur de votre réussite.
                </p>
            </div>
        </section>

        <section class="gallery-section">
            <h2>Nos Espaces et Collections</h2>
            <div class="image-grid">
                <div class="grid-item">
                    <img src="medias/accueil_livre.jpg" alt="Focus sur un ouvrage rare">
                    <span>Collections & Savoirs</span>
                </div>
                <div class="grid-item">
                    <img src="medias/armoire_livre.jpg" alt="Allées de rayonnages">
                    <span>Libre accès</span>
                </div>
                <div class="grid-item">
                    <img src="medias/salle_lecture.jpg" alt="Étudiants en salle de lecture">
                    <span>Zones de calme</span>
                </div>
            </div>
        </section>

        <hr class="separator">

        <section class="media-section">
            <div class="media-block">
                <h3>🎙️ Visite Audio Guidée</h3>
                <p>Laissez-vous guider par la voix de nos conservateurs.</p>
                <audio controls>
                    <source src="medias/audio.mp3" type="audio/mpeg">
                    Votre navigateur ne supporte pas l'élément audio.
                </audio>
            </div>

            <div class="media-block">
                <h3>🎥 La Bibliothèque en Images</h3>
                <p>Découvrez l'ambiance unique de nos locaux.</p>
                <video controls>
                    <source src="medias/navigation.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture vidéo.
                </video>
            </div>
        </section>

        <hr class="separator">

        <div class="info-grid">
            <section class="services">
                <h2>Services Premium</h2>
                <ul>
                    <li><strong>Automates RFID :</strong> Empruntez et retournez vos documents en autonomie totale 24/7.</li>
                    <li><strong>Box Collaboratifs :</strong> Des espaces insonorisés équipés d'écrans pour vos travaux de groupe.</li>
                    <li><strong>Hub Numérique :</strong> Accès illimité aux bases de données internationales et Wi-Fi très haut débit.</li>
                    <li><strong>Expertise :</strong> Une équipe de bibliothécaires dédiée pour vous orienter dans vos recherches complexes.</li>
                </ul>
            </section>

            <section class="horaires">
                <h2>Horaires & Accès</h2>
                <div class="hours-card">
                    <p><strong>Lun - Ven :</strong> 08h30 - 19h00</p>
                    <p><strong>Samedi :</strong> 09h00 - 13h00</p>
                    <p class="closed">Fermé les dimanches et jours fériés</p>
                </div>
                <div class="links">
                    <a href="plan-acces.php" class="btn-secondary">Plan d'accès</a>
                    <a href="catalogue-accueil.php" class="btn-secondary">Catalogue en ligne</a>
                </div>
            </section>
        </div>

    </main>

    <footer>
        <p>&copy; 2024 Bibliothèque Universitaire. Tous droits réservés.</p>
    </footer>

</body>
</html>