<?php
session_start();
require_once 'database.php';

// Vérifier si admin est connecté
if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

// Récupérer les livres depuis la base
$query = $pdo->query("SELECT * FROM livres ORDER BY id DESC");
$livres = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord</title>
</head>
<body>
    <header>
        <h1>📚 Tableau de bord</h1>
        <nav>
            <a href="dashboard.php">Dashboard</a>
            <a href="ajouter.php">Ajouter</a>
            <a href="supprimer.php">Supprimer</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <h2>Liste des livres (<?= count($livres) ?>)</h2>
        
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($livres as $livre): ?>
                <tr>
                    <td><?= htmlspecialchars($livre['id']) ?></td>
                    <td><?= htmlspecialchars($livre['titre']) ?></td>
                    <td><?= htmlspecialchars($livre['auteur']) ?></td>
                    <td><?= htmlspecialchars($livre['statut']) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $livre['id'] ?>">Modifier</a>
                        <a href="supprimer.php?delete=<?= $livre['id'] ?>" onclick="return confirm('Supprimer?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    
    <footer>
        <p>© 2024 Gestion des livres</p>
    </footer>
</body>
</html>