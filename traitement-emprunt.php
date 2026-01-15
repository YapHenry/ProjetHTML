<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: connexion.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livre_id'])) {
    $user_id = $_SESSION['user_id'];
    $livre_id = intval($_POST['livre_id']);

    try {
        // Vérif : L'ai-je déjà ?
        $stmtCheck = $pdo->prepare("SELECT id FROM emprunts WHERE user_id = ? AND livre_id = ? AND statut = 'en_cours'");
        $stmtCheck->execute([$user_id, $livre_id]);
        
        if (!$stmtCheck->fetch()) {
            // Insertion
            $stmtInsert = $pdo->prepare("INSERT INTO emprunts (user_id, livre_id, date_emprunt) VALUES (?, ?, NOW())");
            $stmtInsert->execute([$user_id, $livre_id]);
            // Succès
            header("Location: dashboard.php?msg=emprunt_ok");
        } else {
            // Déjà pris
            header("Location: detail_book.php?id=$livre_id&erreur=deja_pris");
        }
        exit();
    } catch (Exception $e) { die("Erreur : " . $e->getMessage()); }
} else {
    header("Location: livres.php"); exit();
}
?>