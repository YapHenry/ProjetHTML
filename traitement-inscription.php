<?php
session_start();
require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Récupération
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $login = htmlspecialchars(trim($_POST['login']));
    $password = $_POST['password'];

    // 2. Vérif simple
    if (empty($nom) || empty($prenom) || empty($email) || empty($login) || empty($password)) {
        die("Erreur : Tous les champs sont obligatoires.");
    }

    // 3. Hashage et Insertion
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, login, password, role) VALUES (?, ?, ?, ?, ?, 'utilisateur')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $prenom, $email, $login, $passwordHash]);

        // SUCCÈS : On redirige vers la connexion avec un message
        header("Location: connexion.php?erreur=succes");
        exit();

    } catch (PDOException $e) {
        die("Erreur d'inscription : " . $e->getMessage());
    }
}
?>