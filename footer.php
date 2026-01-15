<footer class="main-footer">
        <div class="footer-content">
            <link rel="stylesheet" href="styles/header-footer.css">
            <div class="footer-column">
                <h3>📚 Ma Bibliothèque</h3>
                <p>
                    Un espace dédié à la réussite étudiante, ouvert à tous et connecté au monde.
                    Rejoignez une communauté de savoir.
                </p>
            </div>

            <div class="footer-column center-align">
                <h3>Accès Rapide</h3>
                <ul class="footer-links">
                    <li><a href="livres.php">Catalogue en ligne</a></li>
                    <li><a href="plan-acces.php">Horaires & Plan</a></li>
                    <li><a href="contact.php">Assistance</a></li>
                </ul>
            </div>

            <div class="footer-column right-align">
                <h3>Nous trouver</h3>
                <p class="contact-info">
                    📍 Campus des Sciences, Bât. B<br>
                    📞 01 23 45 67 89<br>
                    ✉️ contact@bibliotheque.univ.fr
                </p>
                <div class="social-icons">
                    <span>🐦</span> <span>📘</span> <span>📷</span>
                </div>
            </div>

        </div>

        <div class="footer-bottom">
            <p>
                &copy; <?php echo date("Y"); ?> Bibliothèque Universitaire - Tous droits réservés. | 
                <a href="#">Mentions Légales</a> | 
                <a href="#">Politique de confidentialité</a>
            </p>
        </div>
    </footer>

    <div id="cookie-banner" class="cookie-banner-wrapper">
    <div class="cookie-content">
        <div class="cookie-text">
            <h3>🍪 Gestion des cookies</h3>
            <p>
                Ce site utilise des cookies pour sauvegarder vos préférences. 
                Acceptez-vous le dépôt de cookies sur votre appareil ?
            </p>
        </div>
        <div class="cookie-actions">
            <button id="btn-refuse" class="btn-cookie btn-refuse">
                Continuer sans accepter
            </button>
            <button id="btn-accept" class="btn-cookie btn-accept">
                Accepter
            </button>
        </div>
    </div>
</div>

<style>
    /* CSS DU BANDEAU (Identique au précédent pour garder le style) */
    .cookie-banner-wrapper {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #fff;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        z-index: 9999;
        padding: 20px;
        display: none; /* Caché par défaut, JS décide de l'afficher */
        border-top: 4px solid #3498db;
    }

    .cookie-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .cookie-text h3 { margin: 0 0 5px 0; font-size: 1.1rem; color: #2c3e50; }
    .cookie-text p { margin: 0; font-size: 0.9rem; color: #666; }

    .cookie-actions { display: flex; gap: 10px; }

    .btn-cookie {
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        border: none;
        font-size: 0.9rem;
        transition: all 0.2s;
    }

    .btn-accept { background-color: #3498db; color: white; }
    .btn-accept:hover { background-color: #2980b9; }

    .btn-refuse { background-color: #f1f2f6; color: #7f8c8d; }
    .btn-refuse:hover { background-color: #e2e6ea; color: #2c3e50; }

    @media (max-width: 768px) {
        .cookie-content { flex-direction: column; text-align: center; }
        .cookie-actions { width: 100%; flex-direction: column; }
    }
</style>

<script>
    // FONCTIONS POUR GÉRER LES VRAIS COOKIES
    
    // Fonction pour créer un cookie
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000)); // Calcul de la date de fin
        let expires = "expires="+d.toUTCString();
        // Création officielle du cookie
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/;SameSite=Lax";
    }

    //  Fonction pour lire un cookie
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    //  Logique Principale
    document.addEventListener("DOMContentLoaded", function() {
        const banner = document.getElementById("cookie-banner");
        const btnAccept = document.getElementById("btn-accept");
        const btnRefuse = document.getElementById("btn-refuse");

        // On vérifie si le cookie "accept_cookies" existe déjà
        let cookieConsent = getCookie("accept_cookies");

        if (cookieConsent === "") {
            // Le cookie n'existe pas, on affiche le bandeau
            banner.style.display = "block";
        }

        // Clic sur ACCEPTER
        btnAccept.addEventListener("click", function() {
            // On crée le cookie "accept_cookies" avec la valeur "true" pour 30 jours
            setCookie("accept_cookies", "true", 30);
            banner.style.display = "none";
            console.log("Cookie créé : accept_cookies=true (30 jours)");
        });

        // Clic sur REFUSER
        btnRefuse.addEventListener("click", function() {
            // On cache juste le bandeau sans créer le cookie (ou on pourrait créer un cookie de refus)
            banner.style.display = "none";
            console.log("Refusé : Aucun cookie persistant créé.");
        });
    });
</script>
</body>
</html>
