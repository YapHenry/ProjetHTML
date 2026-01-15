<?php 
session_start();
require 'db.php'; 

$search_term = "";
$resultats = [];
$nb_resultats = 0;

// MODIFICATION ICI : On vérifie $_GET au lieu de $_POST
if (isset($_GET['q']) && !empty($_GET['q'])) {
    
    // On récupère le terme depuis l'URL
    $search_term = htmlspecialchars(trim($_GET['q']));
    
    try {
        $sql = "SELECT * FROM livres 
                WHERE titre LIKE :term 
                OR auteur LIKE :term 
                OR categorie LIKE :term
                ORDER BY titre ASC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['term' => '%' . $search_term . '%']);
        
        $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $nb_resultats = count($resultats);

    } catch (PDOException $e) {
        die("Erreur de recherche : " . $e->getMessage());
    }
}

$page_title = "Résultats pour : " . $search_term;
include 'header.php'; 
?>

<main class="main-content search-results-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    
    <header class="page-header">
        <h1>Résultats de la recherche</h1>
    </header>

    <section class="search-panel theme-info">
        <form action="recherches.php" method="get" class="search-form-row">
            <div class="input-group">
                <label for="q_res" class="visually-hidden">Nouvelle recherche</label>
                <div class="searching">
                    <img src="medias/glass.png" alt="Recherche">
                </div>
                <input type="text" id="q_res" name="q" 
                       value="<?php echo $search_term; ?>" 
                       placeholder="Histoire, Science..." class="form-input search-input">
                <button type="submit" class="btn btn-primary">Trouver</button>
            </div>
        </form>

        <div class="search-meta">
            <?php if ($search_term): ?>
                <p class="result-count">
                    <strong><?php echo $nb_resultats; ?></strong> résultats trouvés pour 
                    <em class="highlight-term">"<?php echo $search_term; ?>"</em>
                </p>
            <?php else: ?>
                <p class="result-count">Veuillez saisir un mot-clé ci-dessus.</p>
            <?php endif; ?>
        </div>
    </section>

    <hr class="section-divider">

    <section class="results-list">

        <?php if ($nb_resultats > 0): ?>
            
            <?php foreach ($resultats as $livre): ?>
                <article class="result-card">
                    <div class="result-visual">
                        <a href="detail_book.php?id=<?php echo $livre['id']; ?>">
                            <img src="<?php echo htmlspecialchars($livre['image']); ?>" 
                                 alt="Couverture <?php echo htmlspecialchars($livre['titre']); ?>">
                        </a>
                    </div>
                    
                    <div class="result-content">
                        <h3>
                            <a href="detail_book.php?id=<?php echo $livre['id']; ?>">
                                <?php echo htmlspecialchars($livre['titre']); ?>
                            </a>
                        </h3>
                        <p class="meta-info">
                            <strong>Auteur :</strong> <?php echo htmlspecialchars($livre['auteur']); ?> - 
                            <em><?php echo htmlspecialchars($livre['annee_edition']); ?></em>
                            <br>
                            <span style="font-size: 0.9em; color: #666;">
                                🏷️ <?php echo htmlspecialchars($livre['categorie']); ?>
                            </span>
                        </p>
                        <p class="synopsis">
                            <?php 
                                $resume_court = substr($livre['resume'], 0, 150);
                                echo htmlspecialchars($resume_court) . '...'; 
                            ?>
                        </p>
                    </div>

                    <div class="result-actions">
                        <a href="detail_book.php?id=<?php echo $livre['id']; ?>" class="btn btn-outline btn-small">
                            Voir la fiche
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>

        <?php elseif (isset($_GET['q'])): ?>
            <div style="text-align: center; padding: 40px; color: #666;">
                <h3>Oups ! 🕵️‍♂️</h3>
                <p>Aucun livre ne correspond à votre recherche.</p>
            </div>
        <?php endif; ?>

    </section>

    <div class="navigation-footer">
        <a href="livres.php" class="btn-link">← Revenir au catalogue complet</a>
    </div>

</main>
<?php include 'footer.php'; ?>