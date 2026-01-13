<?php
session_start();
require_once 'database.php';

// Vérifier si admin est connecté
if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

// Récupérer les livres depuis la table `books`
$query = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$livres = $query->fetchAll(PDO::FETCH_ASSOC);

// Statistiques
$stats_sql = "SELECT 
    COUNT(*) as total,
    SUM(quantity) as exemplaires_totaux,
    COUNT(DISTINCT category) as categories
    FROM books";
$stats = $pdo->query($stats_sql)->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Gestion des livres</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-blue-700">📊 Tableau de bord - Bibliothèque</h1>
                    <p class="text-gray-600 mt-2">Gestion de la table `books`</p>
                </div>
                <nav class="flex flex-wrap gap-2">
                    <a href="dashboard.php" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Dashboard
                    </a>
                    <a href="ajouter.php" 
                       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        ➕ Ajouter un livre
                    </a>
                    <a href="supprimer.php" 
                       class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        🗑️ Supprimer
                    </a>
                    <a href="logout.php" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                        🚪 Déconnexion
                    </a>
                </nav>
            </div>
        </header>
        
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg mr-4">
                        <span class="text-2xl">📚</span>
                    </div>
                    <div>
                        <p class="text-gray-500">Livres différents</p>
                        <p class="text-3xl font-bold"><?= $stats['total'] ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg mr-4">
                        <span class="text-2xl">📖</span>
                    </div>
                    <div>
                        <p class="text-gray-500">Exemplaires totaux</p>
                        <p class="text-3xl font-bold"><?= $stats['exemplaires_totaux'] ?: 0 ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg mr-4">
                        <span class="text-2xl">🏷️</span>
                    </div>
                    <div>
                        <p class="text-gray-500">Catégories</p>
                        <p class="text-3xl font-bold"><?= $stats['categories'] ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Table des livres -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Liste des livres (<?= count($livres) ?>)</h2>
                <p class="text-gray-600 text-sm mt-1">Table: books</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre (title)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur (author)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date ajout</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach($livres as $livre): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #<?= $livre['id'] ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php if($livre['cover_image']): ?>
                                        <img src="<?= htmlspecialchars($livre['cover_image']) ?>" 
                                             alt="Couverture" 
                                             class="w-10 h-14 object-cover rounded mr-3 border">
                                    <?php endif; ?>
                                    <div>
                                        <p class="font-medium text-gray-900"><?= htmlspecialchars($livre['title']) ?></p>
                                        <?php if($livre['description']): ?>
                                            <p class="text-xs text-gray-500 truncate max-w-xs">
                                                <?= htmlspecialchars(substr($livre['description'], 0, 50)) ?>...
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?= htmlspecialchars($livre['author']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($livre['category']): ?>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                        <?= htmlspecialchars($livre['category']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-sm font-medium 
                                    <?= $livre['quantity'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $livre['quantity'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $livre['isbn'] ? htmlspecialchars($livre['isbn']) : '<span class="text-gray-400">-</span>' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y', strtotime($livre['created_at'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex gap-2">
                                    <a href="modifier.php?id=<?= $livre['id'] ?>" 
                                       class="text-blue-600 hover:text-blue-900 px-3 py-1 hover:bg-blue-50 rounded">
                                        ✏️ Modifier
                                    </a>
                                    <a href="supprimer.php?delete=<?= $livre['id'] ?>" 
                                       onclick="return confirm('Supprimer ce livre ?')"
                                       class="text-red-600 hover:text-red-900 px-3 py-1 hover:bg-red-50 rounded">
                                        🗑️ Supprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if(empty($livres)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <span class="text-4xl mb-2">📚</span>
                                    <p class="text-lg">Aucun livre dans la table `books`</p>
                                    <p class="text-sm mt-2">Commencez par ajouter votre premier livre</p>
                                    <a href="ajouter.php" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                        ➕ Ajouter un livre
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Information sur la structure -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <h3 class="font-semibold text-blue-800 mb-2">📋 Structure de la table `books` :</h3>
            <div class="text-sm text-blue-700 grid grid-cols-2 md:grid-cols-4 gap-2">
                <div><span class="font-mono">id</span> (INT, PK)</div>
                <div><span class="font-mono">title</span> (VARCHAR)</div>
                <div><span class="font-mono">author</span> (VARCHAR)</div>
                <div><span class="font-mono">isbn</span> (VARCHAR, UNIQUE)</div>
                <div><span class="font-mono">category</span> (VARCHAR)</div>
                <div><span class="font-mono">quantity</span> (INT)</div>
                <div><span class="font-mono">cover_image</span> (VARCHAR)</div>
                <div><span class="font-mono">description</span> (TEXT)</div>
            </div>
        </div>
    </div>
</body>
</html>