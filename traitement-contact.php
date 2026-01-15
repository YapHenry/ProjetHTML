<?php
session_start();
require 'db.php';

// 1. SÉCURITÉ : Il faut être connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. RÉCUPÉRATION DES INFOS UTILISATEUR (Depuis la BDD pour être sûr)
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT nom, prenom, email FROM utilisateurs WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // 3. RÉCUPÉRATION DU FORMULAIRE
    $sujet_demande = htmlspecialchars($_POST['sujet']);
    $message_user = htmlspecialchars($_POST['message']);

    // 4. PRÉPARATION DU MAIL
    $destinataire = "Nickson.Tchinda_Fotsa.Etu@univ-lemans.fr";
    $sujet_mail = "[SUPPORT BIBLIO] " . $sujet_demande . " - " . $user['nom'];
    
    // Construction du corps du message
    $contenu = "Nouveau message de support reçu :\n\n";
    $contenu .= "👤 DE : " . $user['prenom'] . " " . $user['nom'] . "\n";
    $contenu .= "📧 EMAIL : " . $user['email'] . "\n";
    $contenu .= "🏷️ SUJET : " . $sujet_demande . "\n";
    $contenu .= "--------------------------------------------------\n\n";
    $contenu .= $message_user . "\n\n";
    $contenu .= "--------------------------------------------------\n";
    
    // Gestion simple de la pièce jointe (Info seulement)
    if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] == 0) {
        $contenu .= "\n📎 UNE PIÈCE JOINTE A ÉTÉ TÉLÉCHARGÉE : " . $_FILES['fichier']['name'];
        // Note : Pour envoyer réellement la pièce jointe par mail en PHP natif, 
        // c'est très complexe (MIME types). Pour l'instant, on signale juste sa présence.
    }

    // En-têtes du mail
    $headers = "From: no-reply@bibliotheque-univ.fr" . "\r\n" .
               "Reply-To: " . $user['email'] . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // 5. ENVOI DU MAIL
    // Note : Sur Localhost (WAMP), la fonction mail() peut ne pas fonctionner sans config SMTP.
    // Le @ devant mail() cache les erreurs techniques pour ne pas effrayer l'utilisateur.
    @mail($destinataire, $sujet_mail, $contenu, $headers);

    // 6. REDIRECTION SUCCÈS
    header("Location: contact.php?msg=envoye");
    exit();

} else {
    header("Location: contact.php");
    exit();
}
?>