<?php
session_start();
if(isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // En production, utiliser password_hash() et vérifier dans la base
    if($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
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
    <title>Connexion Admin</title>
</head>
<body>
    <header>
        <h1>📚 Connexion Administrateur</h1>
    </header>
    
    <main style="max-width: 400px; margin: 50px auto;">
        <?php if($error): ?>
            <div style="color: red; padding: 10px; border: 1px solid red;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div>
                <label>Nom d'utilisateur:</label>
                <input type="text" name="username" required>
            </div>
            
            <div>
                <label>Mot de passe:</label>
                <input type="password" name="password" required>
            </div>
            
            <button type="submit">Se connecter</button>
        </form>
        
        <p>Test: admin / admin123</p>
    </main>
    
    <footer>
        <p>© 2024 Système de gestion</p>
    </footer>
</body>
</html>