<?php
// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'bibliotheque_db';  // Nom corrigé
$username = 'root';  // Par défaut avec XAMPP
$password = '';      // Par défaut avec XAMPP

try {
    // Création de la connexion PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $e) {
    // Message d'erreur détaillé
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>