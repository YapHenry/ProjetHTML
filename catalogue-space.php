<?php 
require 'db.php'; 
try {
    $sql = "SELECT * FROM espaces ORDER BY id ASC";
    $stmt = $pdo->query($sql);
    $espaces = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { die("Erreur : " . $e->getMessage()); }

$page_title = "Nos Espaces de Travail";
include 'header.php'; 
?>

<main class="main-content spaces-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    <header class="page-header">
        <h1>Nos Espaces de Travail</h1>
        <p>Sélectionnez un espace pour voir les créneaux et réserver.</p>
    </header>

    <section class="spaces-list">
        <?php if (count($espaces) > 0): ?>
            <?php foreach ($espaces as $espace): ?>
                <?php 
                    $statusClass = ($espace['est_disponible'] == 1) ? 'status-free' : 'status-busy';
                    $statusLabel = ($espace['est_disponible'] == 1) ? 'LIBRE' : 'OCCUPÉ';
                ?>
                <article class="space-card <?php echo $statusClass; ?>">
                    <div class="space-visual">
                        <a href="detail_space.php?id=<?php echo $espace['id']; ?>">
                            <img src="<?php echo htmlspecialchars($espace['image']); ?>" alt="<?php echo htmlspecialchars($espace['nom']); ?>">
                        </a>
                    </div>
                    <div class="space-info">
                        <h3><a href="detail_space.php?id=<?php echo $espace['id']; ?>"><?php echo htmlspecialchars($espace['nom']); ?></a></h3>
                        <p class="description"><?php echo htmlspecialchars($espace['description']); ?></p>
                        <p class="meta"><span class="icon">👤</span> Capacité : <?php echo $espace['capacite']; ?> pers.</p>
                    </div>
                    <div class="space-action">
                        <div class="status-badge">
                            <span class="dot">●</span>
                            <span class="label"><?php echo $statusLabel; ?></span>
                        </div>
                        <?php if($espace['est_disponible'] == 0): ?>
                            <p class="availability-info" style="font-size: 0.85em; margin-top: 5px;">Indisponible</p>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; padding: 50px;">Aucun espace configuré.</p>
        <?php endif; ?>
    </section>
</main>
<?php include 'footer.php'; ?>