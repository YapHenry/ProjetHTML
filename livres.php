<?php 
// 1. On se connecte à la base de données
require 'db.php'; 

// 2. On récupère TOUS les livres
try {
    // On peut ajouter 'ORDER BY date_ajout DESC' pour voir les derniers ajoutés en premier
    $sql = "SELECT * FROM livres ORDER BY id ASC"; 
    $stmt = $pdo->query($sql);
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de récupération du catalogue : " . $e->getMessage());
}

$page_title = "Catalogue - Bibliothèque Universitaire";
include 'header.php'; 
?>

<main class="main-content catalogue-full-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    
    <header class="page-header">
        <h1>Tout le Catalogue</h1>
        <p>Découvrez l'ensemble de nos collections. Il y a actuellement <strong><?php echo count($livres); ?></strong> ouvrages disponibles.</p>
    </header>

    <section class="search-filter-section">
        <form action="recherches.php" method="get" class="search-form-inline">
            <div class="input-group">
                <label for="q" class="visually-hidden">Rechercher un ouvrage</label>
                <div class="searching">
                    <img src="medias/glass.png" alt="Icone recherche"> 
                </div>
                <input type="text" id="q" name="q" placeholder="Titre, auteur, catégorie..." class="form-input search-input">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </form>
    </section>

    <hr class="section-divider">

    <section class="catalogue-grid">
        
        <?php if (count($livres) > 0): ?>
            
            <?php foreach ($livres as $livre): ?>
                
                <article class="book-card">
                    <div class="book-visual">
                        <a href="detail_book.php?id=<?php echo $livre['id']; ?>">
                            <img src="<?php echo htmlspecialchars($livre['image']); ?>" 
                                 alt="Couverture de <?php echo htmlspecialchars($livre['titre']); ?>">
                        </a>
                    </div>
                    
                    <div class="book-details">
                        <h3>
                            <a href="detail_book.php?id=<?php echo $livre['id']; ?>">
                                <?php echo htmlspecialchars($livre['titre']); ?>
                            </a>
                        </h3>
                        
                        <p class="book-meta">
                            <strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?> <br>
                            <span class="meta-year">Année : <?php echo htmlspecialchars($livre['annee_edition']); ?></span> <br>
                            <span class="meta-cat" style="color: #666; font-size: 0.9em;">
                                🏷️ <?php echo htmlspecialchars($livre['categorie']); ?>
                            </span>
                        </p>
                        
                        <div class="card-actions">
                            <a href="detail_book.php?id=<?php echo $livre['id']; ?>" class="btn btn-outline btn-small">
                                Voir la fiche
                            </a>
                        </div>
                    </div>
                </article>

            <?php endforeach; ?>
            <?php else: ?>
            <p style="text-align: center; width: 100%;">Aucun livre trouvé dans le catalogue pour le moment.</p>
        <?php endif; ?>

    </section>

</main>

<?php include 'footer.php'; ?>