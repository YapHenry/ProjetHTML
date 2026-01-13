<?php
session_start();
require_once 'database.php';

// Vérifier si l'utilisateur est admin
if(!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

$message = '';
$message_type = ''; // success ou error

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et validation des données
    $titre = trim($_POST['titre']);
    $auteur = trim($_POST['auteur']);
    $isbn = trim($_POST['isbn']);
    $category = trim($_POST['category']);
    $quantity = intval($_POST['quantity']);
    $description = trim($_POST['description']);
    
    // Validation basique
    if(empty($titre) || empty($auteur)) {
        $message = "Le titre et l'auteur sont obligatoires";
        $message_type = 'error';
    } elseif($quantity < 1) {
        $message = "La quantité doit être au moins 1";
        $message_type = 'error';
    } else {
        try {
            // Gestion de l'upload d'image
            $cover_image = null;
            if(isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] == UPLOAD_ERR_OK) {
                // Vérifier le type de fichier
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                $file_type = $_FILES['cover_image']['type'];
                
                if(in_array($file_type, $allowed_types)) {
                    // Créer le dossier uploads s'il n'existe pas
                    $upload_dir = 'uploads/books/';
                    if(!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    // Générer un nom de fichier unique
                    $file_extension = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
                    $new_filename = uniqid() . '.' . $file_extension;
                    $destination = $upload_dir . $new_filename;
                    
                    // Déplacer le fichier
                    if(move_uploaded_file($_FILES['cover_image']['tmp_name'], $destination)) {
                        $cover_image = $destination;
                    }
                }
            }
            
            // Préparer la requête SQL
            $sql = "INSERT INTO books (title, author, isbn, category, quantity, cover_image, description) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            
            // Exécuter avec les bonnes valeurs
            $success = $stmt->execute([
                $titre,
                $auteur,
                $isbn ?: null,
                $category ?: null,
                $quantity,
                $cover_image,
                $description ?: null
            ]);
            
            if($success) {
                $message = "✅ Livre ajouté avec succès!";
                $message_type = 'success';
                
                // Réinitialiser le formulaire après succès
                $_POST = array();
            } else {
                $message = "❌ Erreur lors de l'ajout du livre";
                $message_type = 'error';
            }
            
        } catch(PDOException $e) {
            // Vérifier si c'est une erreur d'ISBN unique
            if(strpos($e->getMessage(), 'isbn') !== false) {
                $message = "❌ Cet ISBN existe déjà dans la base de données";
            } else {
                $message = "❌ Erreur: " . $e->getMessage();
            }
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .success { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .error { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-blue-600">➕ Ajouter un livre</h1>
                <nav>
                    <a href="dashboard.php" 
                       class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                        ← Retour au tableau de bord
                    </a>
                </nav>
            </div>
        </header>
        
        <!-- Message de statut -->
        <?php if($message): ?>
            <div class="p-4 rounded mb-6 <?= $message_type ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulaire -->
        <main class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <!-- Titre -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Titre *
                    </label>
                    <input type="text" 
                           name="titre" 
                           required
                           value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Le Petit Prince">
                </div>
                
                <!-- Auteur -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Auteur *
                    </label>
                    <input type="text" 
                           name="auteur" 
                           required
                           value="<?= htmlspecialchars($_POST['auteur'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: Antoine de Saint-Exupéry">
                </div>
                
                <!-- ISBN -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        ISBN (Optionnel)
                    </label>
                    <input type="text" 
                           name="isbn"
                           value="<?= htmlspecialchars($_POST['isbn'] ?? '') ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: 978-2-07-061275-8">
                    <p class="text-sm text-gray-500 mt-1">Code unique du livre</p>
                </div>
                
                <!-- Catégorie et Quantité -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Catégorie
                        </label>
                        <input type="text" 
                               name="category"
                               value="<?= htmlspecialchars($_POST['category'] ?? '') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Ex: Roman, Science-fiction">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">
                            Quantité *
                        </label>
                        <input type="number" 
                               name="quantity" 
                               required
                               min="1"
                               value="<?= htmlspecialchars($_POST['quantity'] ?? '1') ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-sm text-gray-500 mt-1">Nombre d'exemplaires disponibles</p>
                    </div>
                </div>
                
                <!-- Image de couverture -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Image de couverture (Optionnel)
                    </label>
                    <input type="file" 
                           name="cover_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-sm text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF (max 2MB)</p>
                </div>
                
                <!-- Description -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-2">
                        Description (Optionnel)
                    </label>
                    <textarea name="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Description du livre..."><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                </div>
                
                <!-- Boutons -->
                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition flex items-center justify-center">
                        <span>➕ Ajouter le livre</span>
                    </button>
                    
                    <button type="reset" 
                            class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                        Effacer le formulaire
                    </button>
                </div>
            </form>
            
            <!-- Information sur les champs obligatoires -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    <span class="font-semibold">Note :</span> Les champs marqués avec * sont obligatoires.
                    <br>
                    L'ISBN doit être unique pour chaque livre.
                </p>
            </div>
        </main>
    </div>
</body>
</html>