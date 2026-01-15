<?php 
session_start();
require 'db.php'; 

$page_title = "Contact & Assistance";
include 'header.php'; 

// On vérifie s'il y a un message de succès
$msg_envoye = isset($_GET['msg']) && $_GET['msg'] == 'envoye';
?>

<main class="main-content contact-wrapper">
    <link rel="stylesheet" href="styles/style.css">
    
    <header class="page-header">
        <h1>Contact & Assistance</h1>
        <p>Une question ? Une suggestion ? Notre équipe vous répond sous 24h ouvrées.</p>
    </header>

    <div class="contact-grid">

        <section class="contact-form-area">
            
            <?php if ($msg_envoye): ?>
                <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                    <h3>✅ Message envoyé !</h3>
                    <p>Nous avons bien reçu votre demande. Une réponse vous sera apportée sur votre adresse institutionnelle rapidement.</p>
                    <a href="accueil_users.php" class="btn btn-outline">Retour à l'accueil</a>
                </div>

            <?php elseif (isset($_SESSION['user_id'])): ?>
                
                <form action="traitement-contact.php" method="post" enctype="multipart/form-data" class="styled-form">
                    
                    <div style="margin-bottom: 20px; padding: 10px; background: #f8f9fa; border-left: 4px solid #3498db; border-radius: 4px;">
                        <p style="margin: 0; font-size: 0.9rem; color: #555;">
                            Envoi en tant que : <strong><?php echo htmlspecialchars($_SESSION['user_nom']); ?></strong>
                        </p>
                    </div>

                    <fieldset class="form-group">
                        <legend>Votre demande</legend>

                        <div class="form-row">
                            <label for="sujet">Sujet de la demande :</label>
                            <div class="select-wrapper">
                                <select id="sujet" name="sujet" required class="form-select">
                                    <option value="" disabled selected>-- Choisir une catégorie --</option>
                                    <option value="Problème d'emprunt / Retard">Problème d'emprunt / Retard</option>
                                    <option value="Accès au compte / Mot de passe">Accès au compte / Mot de passe</option>
                                    <option value="Suggestion d'achat">Suggestion d'achat de livre</option>
                                    <option value="Réservation de salle">Réservation de salle / Espace</option>
                                    <option value="Autre demande">Autre demande</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <label for="message">Message :</label>
                            <textarea id="message" name="message" rows="6" required placeholder="Décrivez votre demande avec le plus de détails possible..." class="form-textarea"></textarea>
                        </div>

                        <div class="form-row">
                            <label for="fichier">Pièce jointe (facultatif) :</label>
                            <input type="file" id="fichier" name="fichier" class="form-file">
                            <small class="form-help">Capture d'écran, bibliographie PDF, etc.</small>
                        </div>
                    </fieldset>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Envoyer le message ✉️</button>
                    </div>

                </form>

            <?php else: ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <img src="medias/question.jpg" alt="Locked" style="width: 80px; margin-bottom: 20px; border-radius: 50%;">
                    <h3>Authentification requise</h3>
                    <p>Pour contacter le support, nous avons besoin de vous identifier.</p>
                    <a href="connexion.php" class="btn btn-primary">Se connecter</a>
                </div>
            <?php endif; ?>

        </section>

        <aside class="contact-sidebar">
            <div class="sidebar-card">
                <h3 class="sidebar-title">Besoin d'une réponse immédiate ?</h3>
                <div class="info-block">
                    <strong>📞 Par téléphone :</strong>
                    <a href="tel:+33123456789" class="phone-link">01 23 45 67 89</a>
                    <small>De 9h à 17h, du lundi au vendredi.</small>
                </div>
                <hr class="sidebar-divider">
                <div class="info-block">
                    <strong>📍 Sur place :</strong>
                    <p>Bureau d'accueil principal<br>Aile B, Rez-de-chaussée<br><em>Campus des Sciences</em></p>
                </div>
                <hr class="sidebar-divider">
                <div class="map-container">
                    <img src="medias/question.jpg" alt="Plan d'accès" class="sidebar-map">
                </div>
            </div>
        </aside>

    </div>
</main>
<?php include 'footer.php'; ?>