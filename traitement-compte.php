<?php
session_start();
require 'db.php';

// 1. Sécurité
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// 2. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $user_id = $_SESSION['user_id'];
    
    // Nettoyage des données reçues
    $email = htmlspecialchars(trim($_POST['email']));
    $telephone = htmlspecialchars(trim($_POST['phone']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $code_postal = htmlspecialchars(trim($_POST['cp']));
    $ville = htmlspecialchars(trim($_POST['ville']));

    // Vérification basique (l'email ne doit pas être vide)
    if (empty($email)) {
        header("Location: profil.php?error=email_vide");
        exit();
    }

    try {
        // 3. MISE À JOUR (UPDATE)
        // On met à jour uniquement les champs complémentaires
        $sql = "UPDATE utilisateurs SET 
                email = ?, 
                telephone = ?, 
                adresse = ?, 
                code_postal = ?, 
                ville = ? 
                WHERE id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $telephone, $adresse, $code_postal, $ville, $user_id]);

        // Succès -> Retour au profil avec message vert
        header("Location: profil.php?msg=succes");
        exit();

    } catch (PDOException $e) {
        // Erreur (ex: email déjà pris par quelqu'un d'autre)
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }

} else {
    // Si on essaie d'accéder au fichier sans passer par le formulaire
    header("Location: profil.php");
    exit();
}
?>