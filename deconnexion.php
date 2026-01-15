<?php
session_start();

// =========================================================
// PHASE 1 : L'ACTION (Si l'utilisateur a cliqué sur "Oui")
// =========================================================
if (isset($_GET['action']) && $_GET['action'] === 'confirmer') {
    
    // 1. Vider les variables de session
    $_SESSION = array();

    // 2. Tuer le cookie de session (Empêche le retour arrière via le navigateur)
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 3. Détruire la session côté serveur
    session_destroy();

    // 4. Redirection vers l'accueil public
    header("Location: accueil.php");
    exit();
}

// =========================================================
// PHASE 2 : L'AFFICHAGE (Demande de confirmation)
// =========================================================

// Sécurité : Si on n'est pas connecté, on n'a rien à faire ici
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$page_title = "Confirmation de déconnexion";
include 'header.php'; 
?>

<main class="main-content">
    
    <div class="auth-card-centered" style="max-width: 550px; text-align: center; margin-top: 60px;">
        <link rel="stylesheet" href="styles/style.css"> 
        <div style="font-size: 4rem; margin-bottom: 15px;">👋</div>
        
        <h2 style="color: #2c3e50; margin-bottom: 20px;">Déjà en train de partir ?</h2>
        
        <p style="font-size: 1.2rem; color: #555; margin-bottom: 40px; line-height: 1.6;">
            Voulez-vous vraiment vous déconnecter, <br>
            <strong style="color: #3498db; font-size: 1.4rem;">
                <?php echo htmlspecialchars($_SESSION['user_nom']); ?>
            </strong> ?
        </p>

        <div class="logout-actions">
            
            <a href="accueil_users.php" class="btn btn-cancel">
                Non, je reste 😇
            </a>

            <a href="deconnexion.php?action=confirmer" class="btn btn-danger">
                Oui, quitter 🚪
            </a>
            
        </div>

    </div>

</main>

<?php include 'footer.php'; ?>