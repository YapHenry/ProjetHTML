<?php
session_start();
require 'db.php';

// 1. Vérification ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: livres.php");
    exit();
}
$id_livre = $_GET['id'];

// 2. Infos Livre
try {
    $stmt = $pdo->prepare("SELECT * FROM livres WHERE id = ?");
    $stmt->execute([$id_livre]);
    $livre = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$livre) { header("Location: livres.php"); exit(); }
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }

// 3. Vérif : Est-ce que JE l'ai déjà ?
$monEmprunt = false;
if (isset($_SESSION['user_id'])) {
    $stmtVerif = $pdo->prepare("SELECT id FROM emprunts WHERE user_id = ? AND livre_id = ? AND statut = 'en_cours'");
    $stmtVerif->execute([$_SESSION['user_id'], $id_livre]);
    if ($stmtVerif->fetch()) { $monEmprunt = true; }
}

$page_title = $livre['titre'];
include 'header.php';
?>

<main class="main-content book-detail-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .book-hero { display: flex; align-items: flex-start; gap: 40px; margin-bottom: 40px; }
        .book-cover-container { flex: 0 0 350px; }
        .book-cover-img { width: 100%; max-width: 350px; border-radius: 12px; box-shadow: 0 15px 35px rgba(0,0,0,0.25); }
        @media (max-width: 768px) { .book-hero { flex-direction: column; align-items: center; } }
    </style>

    <div class="navigation-back">
        <a href="livres.php" class="btn-back">← Retour au catalogue</a>
    </div>

    <section class="book-hero">
        <div class="book-cover-container">
            <img src="<?php echo htmlspecialchars($livre['image']); ?>" alt="Couverture" class="book-cover-img">
        </div>
        <div class="book-info">
            <h1 class="book-title" style="font-size: 2.5rem; margin-bottom: 15px;"><?php echo htmlspecialchars($livre['titre']); ?></h1>
            <div class="book-meta" style="font-size: 1.1rem; color: #555; margin-bottom: 20px;">
                <p><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
                <p><strong>Année :</strong> <?php echo htmlspecialchars($livre['annee_edition']); ?></p>
                <p><strong>Catégorie :</strong> <span style="background: #eef2f7; padding: 4px 10px; border-radius: 15px;"><?php echo htmlspecialchars($livre['categorie']); ?></span></p>
            </div>
            <div class="book-availability">
                <p class="status-text text-success" style="font-size: 1.1rem; font-weight: bold; color: #27ae60;">
                    <span class="icon">✅</span> Disponible en rayon
                </p>
            </div>
        </div>
    </section>

    <hr class="section-divider">

    <section class="content-block">
        <h2>Résumé de l'œuvre</h2>
        <div class="text-content" style="font-size: 1.1rem; line-height: 1.8;">
            <p><?php echo nl2br(htmlspecialchars($livre['resume'])); ?></p>
        </div>
    </section>

    <section class="action-section">
        <div class="action-card">
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($monEmprunt): ?>
                    <div style="text-align: center; color: #e67e22;">
                        <h3 class="action-title">Vous lisez cet ouvrage 📖</h3>
                        <p>Vous avez déjà un emprunt en cours pour ce livre.</p>
                        <button disabled class="btn btn-outline" style="opacity: 0.6; cursor: not-allowed; width: 100%;">Déjà emprunté</button>
                        <p class="form-help"><a href="dashboard.php">Aller le rendre sur mon tableau de bord</a></p>
                    </div>
                <?php else: ?>
                    <form action="traitement-emprunt.php" method="post" class="borrow-form">
                        <input type="hidden" name="livre_id" value="<?php echo $livre['id']; ?>">
                        <p class="action-title">Vous souhaitez emprunter cet ouvrage ?</p>
                        <button type="submit" class="btn btn-primary btn-large">Valider l'emprunt</button>
                        <p class="form-help">Réservation maintenue 48h.</p>
                    </form>
                <?php endif; ?>
            <?php else: ?>
                <div class="login-prompt" style="text-align: center;">
                    <p class="action-title">Connectez-vous pour emprunter ce livre</p>
                    <a href="connexion.php" class="btn btn-outline">Se connecter</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>