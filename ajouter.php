<?php
session_start();
require_once 'database.php';

if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

$message = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $annee = $_POST['annee'];
    $statut = $_POST['statut'];
    
    $sql = "INSERT INTO livres (titre, auteur, annee, statut) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$titre, $auteur, $annee, $statut])) {
        $message = "Livre ajouté avec succès!";
    } else {
        $message = "Erreur lors de l'ajout";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un livre</title>
</head>
<body>
    <header>
        <h1>➕ Ajouter un livre</h1>
        <nav>
            <a href="dashboard.php">← Retour</a>
        </nav>
    </header>
    
    <main>
        <?php if($message): ?>
            <div style="padding: 10px; background: #d4edda;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div>
                <label>Titre:</label>
                <input type="text" name="titre" required>
            </div>
            
            <div>
                <label>Auteur:</label>
                <input type="text" name="auteur" required>
            </div>
            
            <div>
                <label>Année:</label>
                <input type="number" name="annee">
            </div>
            
            <div>
                <label>Statut:</label>
                <select name="statut">
                    <option value="disponible">Disponible</option>
                    <option value="emprunte">Emprunté</option>
                    <option value="reserve">Réservé</option>
                </select>
            </div>
            
            <button type="submit">Ajouter le livre</button>
        </form>
    </main>
</body>
</html>