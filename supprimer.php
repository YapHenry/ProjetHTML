<?php
session_start();
require_once 'database.php';

if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

// Récupérer tous les livres
$query = $pdo->query("SELECT * FROM livres");
$livres = $query->fetchAll(PDO::FETCH_ASSOC);

// Supprimer un livre
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM livres WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    header('Location: supprimer.php');
    exit();
}

// Supprimer plusieurs livres
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['livres_suppr'])) {
    $ids = $_POST['livres_suppr'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "DELETE FROM livres WHERE id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    header('Location: supprimer.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer des livres</title>
</head>
<body>
    <header>
        <h1>🗑️ Supprimer des livres</h1>
        <a href="dashboard.php">← Retour</a>
    </header>
    
    <main>
        <form method="POST">
            <table border="1">
                <thead>
                    <tr>
                        <th>Sélection</th>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($livres as $livre): ?>
                    <tr>
                        <td><input type="checkbox" name="livres_suppr[]" value="<?= $livre['id'] ?>"></td>
                        <td><?= htmlspecialchars($livre['id']) ?></td>
                        <td><?= htmlspecialchars($livre['titre']) ?></td>
                        <td><?= htmlspecialchars($livre['auteur']) ?></td>
                        <td><?= htmlspecialchars($livre['statut']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <button type="submit" onclick="return confirm('Supprimer les livres sélectionnés?')">
                Supprimer la sélection
            </button>
        </form>
    </main>
</body>
</html>