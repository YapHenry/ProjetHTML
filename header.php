<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Bibliothèque Universitaire'; ?></title>
    <link rel="stylesheet" href="styles/header-footer.css">
</head>
<body>

    <header class="main-header">
        <div class="header-content">
            <div class="logo-area">
                <span class="logo-icon">📚</span>
                <a href="accueil.php" class="logo-text">Ma Bibliothèque</a>
            </div>

            <nav class="navbar">
                <ul class="nav-list">
                    <li><a href="accueil_users.php" class="nav-link">Accueil</a></li>
                    <li><a href="dashboard.php" class="nav-link">Mes Emprunts</a></li>
                    <li><a href="contact.php" class="nav-link">Contact</a></li>
                    
                    <li class="dropdown-item">
                        <a href="#" class="nav-link account-btn">👤 Mon Compte <span class="arrow">▼</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="profil.php">Mes informations</a></li>
                            <li><a href="deconnexion.php" class="logout">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>