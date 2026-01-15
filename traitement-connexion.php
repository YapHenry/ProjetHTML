<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = htmlspecialchars(trim($_POST['login']));
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        header("Location: connexion.php?erreur=vide");
        exit();
    }

    // 1. On cherche l'utilisateur par Login OU Email
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ? OR email = ?");
    $stmt->execute([$login, $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. On vérifie le mot de passe crypté
    if ($user && password_verify($password, $user['password'])) {
        
        // SUCCÈS : On connecte l'utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nom'] = $user['prenom'] . ' ' . $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection vers l'accueil connecté
        header("Location: accueil_users.php");
        exit();

    } else {
        // ÉCHEC
        header("Location: connexion.php?erreur=identifiants");
        exit();
    }

} else {
    header("Location: connexion.php");
    exit();
}
?>