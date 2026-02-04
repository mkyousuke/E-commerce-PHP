<?php
// --- GESTION DE SESSION & PANIER ---
// On vérifie si la session est déjà ouverte pour éviter les erreurs
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Calcul du nombre total d'articles pour le badge rouge du panier
$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $cartCount += $qty;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameShop - Vente de jeux vidéo</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Ajustements visuels */
        .navbar { backdrop-filter: blur(10px); }
        .nav-link { transition: color 0.3s; font-weight: 500; }
        .nav-link:hover { color: #ffc107 !important; } /* Or au survol */
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
  <div class="container">
    
    <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="uploads/logo.jpg" alt="Logo" width="40" height="40" class="rounded-circle me-2 d-none d-sm-block">
        <span class="fw-bold text-uppercase letter-spacing-1">GameShop</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        
        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home me-1"></i> Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="catalog.php"><i class="fas fa-gamepad me-1"></i> Catalogue</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php"><i class="fas fa-users me-1"></i> L'équipe</a></li>

        <li class="nav-item me-3 position-relative">
            <a class="nav-link" href="cart.php">
                <i class="fas fa-shopping-cart fa-lg"></i>
                <?php if($cartCount > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        <?= $cartCount; ?>
                    </span>
                <?php endif; ?>
            </a>
        </li>

        <div class="vr bg-secondary mx-2 d-none d-lg-block" style="height: 30px;"></div>

        <?php if (isset($_SESSION['user_id'])): ?>
            
            <li class="nav-item dropdown ms-2">
                <a class="nav-link dropdown-toggle btn btn-outline-light border-0 py-1 px-3 rounded-pill" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-user-circle me-1"></i> 
                    <?= htmlspecialchars($_SESSION['user_name']); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li><a class="dropdown-item text-primary fw-bold" href="admin/index.php"><i class="fas fa-tools me-2"></i>Administration</a></li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endif; ?>

                    <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Déconnexion</a></li>
                </ul>
            </li>

        <?php else: ?>

            <li class="nav-item ms-2"><a class="nav-link" href="login.php">Connexion</a></li>
            <li class="nav-item ms-2">
                <a class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" href="register.php">Inscription</a>
            </li>

        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4 flex-grow-1">