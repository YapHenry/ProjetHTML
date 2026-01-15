<?php
session_start();
require 'db.php';

// 1. SÉCURITÉ : Si pas connecté, on redirige
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// 2. RÉCUPÉRATION DES INFOS ACTUELLES
// On va chercher l'utilisateur pour pré-remplir les champs
try {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}

// Gestion des messages de retour (Succès ou Erreur)
if (isset($_GET['msg']) && $_GET['msg'] == 'succes') {
    $message = "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;'>✅ Vos informations ont été mises à jour avec succès !</div>";
}

$page_title = "Mon Profil";
include 'header.php';
?>

<main class="main-content profile-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    
    <header class="page-header">
        <div class="navigation-back">
            <a href="dashboard.php" class="btn-back">← Retour au tableau de bord</a>
        </div>
        <h1>Mon Compte</h1>
    </header>

    <?php echo $message; ?>

    <section class="status-section">
        <div class="status-card info-theme">
            <h2>Statut du compte</h2>
            <p>
                Vous êtes connecté en tant que : 
                <strong><?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></strong>
                <span class="status-badge badge-student" style="margin-left: 10px;">
                    <?php echo strtoupper(htmlspecialchars($user['role'])); ?>
                </span>
            </p>
        </div>
    </section>

    <hr class="section-divider">

    <section class="form-section">
        <div class="section-intro">
            <h2>Mettre à jour mes coordonnées</h2>
            <p>Modifiez les champs ci-dessous puis validez pour sauvegarder.</p>
        </div>

        <form action="traitement-compte.php" method="post" class="styled-form">
            
            <fieldset class="form-group">
                <legend>Contact Électronique</legend>
                
                <div class="form-row">
                    <label for="email">Adresse Email :</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo htmlspecialchars($user['email']); ?>" 
                           class="form-input" required>
                    <small class="form-help">Ceci est votre adresse de contact principale.</small>
                </div>

                <div class="form-row">
                    <label for="phone">Numéro de téléphone :</label>
                    <input type="tel" id="phone" name="phone" 
                           value="<?php echo htmlspecialchars($user['telephone'] ?? ''); ?>" 
                           placeholder="Ex: 06 12 34 56 78" class="form-input">
                </div>
            </fieldset>

            <fieldset class="form-group">
                <legend>Adresse Postale</legend>
                <p class="fieldset-intro"><em>Permet l'envoi de documents en cas de besoin.</em></p>

                <div class="form-row">
                    <label for="adresse">Numéro et Rue :</label>
                    <input type="text" id="adresse" name="adresse" 
                           value="<?php echo htmlspecialchars($user['adresse'] ?? ''); ?>" 
                           placeholder="10 rue de la République" class="form-input">
                </div>

                <div class="form-grid-2">
                    <div class="form-col-small">
                        <label for="cp">Code Postal :</label>
                        <input type="text" id="cp" name="cp" 
                               value="<?php echo htmlspecialchars($user['code_postal'] ?? ''); ?>" 
                               placeholder="75000" class="form-input">
                    </div>
                    
                    <div class="form-col-large">
                        <label for="ville">Ville :</label>
                        <input type="text" id="ville" name="ville" 
                               value="<?php echo htmlspecialchars($user['ville'] ?? ''); ?>" 
                               placeholder="Paris" class="form-input">
                    </div>
                </div>
            </fieldset>

            <div class="form-actions right-align">
                <button type="reset" class="btn btn-secondary">Annuler les changements</button>
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
            </div>

        </form>
    </section>

</main>
<?php include 'footer.php'; ?>