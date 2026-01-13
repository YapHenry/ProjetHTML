<?php
session_start();
require_once 'database.php';

// Si déjà connecté, rediriger vers dashboard
if(isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // En production, utiliser password_hash() et vérifier dans la base
    // Pour la démo, on utilise des identifiants simples
    if($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Identifiants incorrects';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Gestion Bibliothèque</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Carte de connexion -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- En-tête -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8 text-center">
                <div class="text-5xl mb-4">📚</div>
                <h1 class="text-2xl font-bold">Gestion de Bibliothèque</h1>
                <p class="text-blue-100 mt-2">Table: books - Interface d'administration</p>
            </div>
            
            <!-- Formulaire -->
            <div class="p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 text-center">Connexion Administrateur</h2>
                
                <?php if($error): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                        ❌ <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Nom d'utilisateur</label>
                        <input type="text" 
                               name="username" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Entrez votre nom d'utilisateur">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Mot de passe</label>
                        <input type="password" 
                               name="password" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Entrez votre mot de passe">
                    </div>
                    
                    <div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                            🔐 Se connecter
                        </button>
                    </div>
                </form>
                
                <!-- Informations de test -->
                <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="font-semibold text-blue-800 mb-2">🔑 Identifiants de test :</h3>
                    <div class="text-sm text-blue-700">
                        <p>Nom d'utilisateur : <span class="font-mono bg-blue-100 px-2 py-1 rounded">admin</span></p>
                        <p>Mot de passe : <span class="font-mono bg-blue-100 px-2 py-1 rounded">admin123</span></p>
                    </div>
                </div>
                
                <!-- Structure de la base -->
                <div class="mt-6 pt-6 border-t">
                    <h4 class="text-sm font-semibold text-gray-600 mb-2">Base de données utilisée :</h4>
                    <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded">
                        <p class="font-mono">Table: <strong>books</strong></p>
                        <p class="mt-1">Colonnes: id, title, author, isbn, category, quantity, cover_image, description, created_at</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600">
                <p>© 2024 Système de gestion de bibliothèque</p>
                <p class="mt-1">Interface d'administration</p>
            </div>
        </div>
    </div>
</body>
</html>