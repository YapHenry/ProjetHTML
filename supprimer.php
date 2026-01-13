<?php
session_start();
require_once 'database.php';

if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

// Récupérer tous les livres depuis la table `books`
$query = $pdo->query("SELECT * FROM books ORDER BY title");
$livres = $query->fetchAll(PDO::FETCH_ASSOC);

// Supprimer un livre
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    header('Location: supprimer.php?success=1');
    exit();
}

// Supprimer plusieurs livres
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['livres_suppr'])) {
    $ids = $_POST['livres_suppr'];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "DELETE FROM books WHERE id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    header('Location: supprimer.php?success=' . count($ids));
    exit();
}

$success = isset($_GET['success']) ? $_GET['success'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer des livres - Table books</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-red-700">🗑️ Supprimer des livres</h1>
                    <p class="text-gray-600 mt-1">Table: books - Sélectionnez les livres à supprimer</p>
                </div>
                <div>
                    <a href="dashboard.php" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        ← Retour au tableau de bord
                    </a>
                </div>
            </div>
        </header>
        
        <!-- Message de succès -->
        <?php if($success): ?>
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                ✅ <?= $success == 1 ? '1 livre supprimé avec succès!' : $success . ' livres supprimés avec succès!' ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulaire de suppression -->
        <main class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-xl font-semibold">Sélectionner les livres à supprimer</h2>
                <p class="text-gray-600 text-sm"><?= count($livres) ?> livres trouvés</p>
            </div>
            
            <form method="POST" action="">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" id="select-all" class="rounded">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action rapide</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach($livres as $livre): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="livres_suppr[]" value="<?= $livre['id'] ?>" 
                                           class="livre-checkbox rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= $livre['id'] ?>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium"><?= htmlspecialchars($livre['title']) ?></p>
                                    <?php if($livre['cover_image']): ?>
                                        <p class="text-xs text-gray-500">Avec image</p>
                                    <?php endif; ?>
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
                                    <span class="px-2 py-1 text-xs rounded <?= $livre['quantity'] > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $livre['quantity'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $livre['isbn'] ? htmlspecialchars($livre['isbn']) : '-' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="?delete=<?= $livre['id'] ?>" 
                                       onclick="return confirm('Supprimer «<?= addslashes($livre['title']) ?>» ?')"
                                       class="text-red-600 hover:text-red-900 text-sm font-medium">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if(empty($livres)): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                    <p>Aucun livre à supprimer</p>
                                    <a href="ajouter.php" class="mt-2 text-blue-600 hover:underline">
                                        Ajouter des livres d'abord
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if(!empty($livres)): ?>
                <div class="px-6 py-4 border-t bg-gray-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <span id="selected-count" class="text-sm text-gray-600">0 livre(s) sélectionné(s)</span>
                        </div>
                        <div class="flex gap-4">
                            <button type="button" id="deselect-all" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Tout désélectionner
                            </button>
                            <button type="submit" 
                                    onclick="return confirm('Supprimer les livres sélectionnés ? Cette action est irréversible.')"
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold">
                                🗑️ Supprimer la sélection
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </form>
        </main>
        
        <!-- Avertissement -->
        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <h3 class="font-semibold text-red-800 mb-2">⚠️ Attention !</h3>
            <ul class="text-red-700 text-sm list-disc pl-5 space-y-1">
                <li>La suppression est définitive et irréversible</li>
                <li>Les livres supprimés seront effacés de la table `books`</li>
                <li>Vérifiez bien votre sélection avant de confirmer</li>
            </ul>
        </div>
    </div>
    
    <script>
        // Gestion de la sélection multiple
        const selectAll = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('.livre-checkbox');
        const selectedCount = document.getElementById('selected-count');
        const deselectBtn = document.getElementById('deselect-all');
        
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
        
        deselectBtn.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            selectAll.checked = false;
            updateSelectedCount();
        });
        
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.livre-checkbox:checked').length;
            selectedCount.textContent = selected + ' livre(s) sélectionné(s)';
            selectAll.checked = selected === checkboxes.length && checkboxes.length > 0;
        }
        
        // Initialiser le compteur
        updateSelectedCount();
    </script>
</body>
</html>