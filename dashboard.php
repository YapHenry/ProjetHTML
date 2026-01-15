<?php 
session_start();
require 'db.php'; 

// 1. SÉCURITÉ : Redirection si non connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// 2. RÉCUPÉRATION DES LIVRES (Statut 'en_cours')
$sqlEmprunts = "SELECT e.id as emprunt_id, e.date_emprunt, l.titre, l.auteur, l.image 
                FROM emprunts e 
                JOIN livres l ON e.livre_id = l.id 
                WHERE e.user_id = ? AND e.statut = 'en_cours' 
                ORDER BY e.date_emprunt DESC";
$stmt = $pdo->prepare($sqlEmprunts);
$stmt->execute([$user_id]);
$mesEmprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. RÉCUPÉRATION DES ESPACES (Statut 'active')
$sqlReservations = "SELECT r.id as resa_id, r.date_reservation, s.id as espace_id, s.nom, s.image 
                    FROM reservations r 
                    JOIN espaces s ON r.espace_id = s.id 
                    WHERE r.user_id = ? AND r.statut = 'active'
                    ORDER BY r.date_reservation DESC";
$stmt = $pdo->prepare($sqlReservations);
$stmt->execute([$user_id]);
$mesReservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = "Mon Tableau de Bord"; 
include 'header.php'; 
?>

<main class="main-content dashboard-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    
    <header class="page-header">
        <h1>Mon Tableau de Bord</h1>
        <p>Bienvenue, <strong><?php echo htmlspecialchars($_SESSION['user_nom']); ?></strong>. Voici vos activités en cours.</p>
    </header>

    <section class="dashboard-section">
        <h2 class="section-title">📚 Mes livres empruntés</h2>
        
        <div class="dashboard-list">
            
            <?php if (count($mesEmprunts) > 0): ?>
                <?php foreach ($mesEmprunts as $livre): ?>
                    <article class="card-horizontal">
                        <div class="card-visual book-cover">
                            <img src="<?php echo htmlspecialchars($livre['image']); ?>" alt="Couverture">
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($livre['titre']); ?></h3>
                            <p class="author"><strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?></p>
                            
                            <p class="meta-date">
                                <strong>📅 Emprunté le :</strong> <?php echo date('d/m/Y', strtotime($livre['date_emprunt'])); ?>
                            </p>

                            <form action="traitement-retour.php" method="post" style="margin-top: 15px;">
                                <input type="hidden" name="type" value="livre">
                                <input type="hidden" name="id" value="<?php echo $livre['emprunt_id']; ?>">
                                <button type="submit" class="btn btn-outline btn-small">
                                    Restituer le livre ↩️
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-message">Vous n'avez aucun livre en cours d'emprunt.</p>
            <?php endif; ?>

        </div>
    </section>

    <hr class="section-divider">

    <section class="dashboard-section">
        <h2 class="section-title">🏢 Mes réservations d'espaces</h2>

        <div class="dashboard-list">
            
            <?php if (count($mesReservations) > 0): ?>
                <?php foreach ($mesReservations as $resa): ?>
                    <article class="card-horizontal">
                        <div class="card-visual space-thumb">
                            <img src="<?php echo htmlspecialchars($resa['image']); ?>" alt="Espace">
                        </div>
                        <div class="card-content">
                            <h3><?php echo htmlspecialchars($resa['nom']); ?></h3>
                            <p class="context-date">
                                Réservé le <?php echo date('d/m/Y à H:i', strtotime($resa['date_reservation'])); ?>
                            </p>
                            
                            <small class="notice-text">Veuillez libérer l'espace 5 min avant la fin.</small>

                            <form action="traitement-retour.php" method="post" style="margin-top: 15px;">
                                <input type="hidden" name="type" value="espace">
                                <input type="hidden" name="id" value="<?php echo $resa['resa_id']; ?>">
                                <input type="hidden" name="espace_id" value="<?php echo $resa['espace_id']; ?>">
                                <button type="submit" class="btn btn-outline btn-small" style="color: #e74c3c; border-color: #e74c3c;">
                                    Libérer l'espace 🚪
                                </button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="empty-message">Aucune réservation active.</p>
            <?php endif; ?>

        </div>
    </section>

</main>



<?php include 'footer.php'; ?>