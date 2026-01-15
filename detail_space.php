<?php
session_start();
require 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) { header("Location: catalogue-space.php"); exit(); }
$id_espace = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM espaces WHERE id = ?");
    $stmt->execute([$id_espace]);
    $espace = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$espace) { header("Location: catalogue-space.php"); exit(); }
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }

$liste_equipements = explode(',', $espace['equipements']);
$page_title = $espace['nom'];
include 'header.php';
?>

<main class="main-content space-detail-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <style>
        .hero-image-container { width: 100%; height: 400px; overflow: hidden; border-radius: 0 0 20px 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .hero-img { width: 100%; height: 100%; object-fit: cover; }
    </style>

    <div class="navigation-back"><a href="catalogue-space.php" class="btn-back">← Retour</a></div>

    <section class="space-hero">
        <div class="hero-image-container">
            <img src="<?php echo htmlspecialchars($espace['image']); ?>" class="hero-img">
        </div>
    </section>

    <section class="content-block">
        <header class="space-header">
            <h1 class="space-title"><?php echo htmlspecialchars($espace['nom']); ?></h1>
            <p class="space-subtitle"><em>Capacité : <?php echo $espace['capacite']; ?> personne(s)</em></p>
        </header>
        <hr class="section-divider">
        <div class="text-content">
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($espace['description'])); ?></p>
            <h3>Équipements :</h3>
            <ul class="feature-list">
                <?php foreach($liste_equipements as $equipement): ?>
                    <li><span class="icon">✨</span> <strong><?php echo trim(htmlspecialchars($equipement)); ?></strong></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <section class="action-section">
        <div class="action-card theme-light">
            <?php if ($espace['est_disponible'] == 1): ?>
                <h3 class="action-title">Cet espace vous convient ?</h3>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <p class="availability-info" style="color: #27ae60;"><strong>✅ Cet espace est libre.</strong></p>
                    <form action="traitement-reservation.php" method="post">
                        <input type="hidden" name="espace_id" value="<?php echo $espace['id']; ?>">
                        <button type="submit" class="btn btn-success btn-large">Demander la réservation</button>
                    </form>
                <?php else: ?>
                    <p>Connectez-vous pour réserver.</p>
                    <a href="connexion.php" class="btn btn-primary">Se connecter</a>
                <?php endif; ?>
            <?php else: ?>
                <h3 class="action-title" style="color: #e74c3c;">Oups ! 🚫</h3>
                <p class="availability-info" style="color: #c0392b;"><strong>Cet espace est actuellement occupé.</strong></p>
                <button disabled class="btn btn-outline" style="opacity: 0.5; cursor: not-allowed;">Réservation impossible</button>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>