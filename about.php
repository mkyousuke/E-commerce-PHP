<?php
require_once 'includes/header.php';
?>

<div class="bg-light py-5 mb-5 border-bottom">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">À propos de GameShop</h1>
        <p class="lead text-muted col-md-8 mx-auto">
            Plus qu'une boutique, une communauté de passionnés au service des joueurs.
        </p>
    </div>
</div>

<div class="container mb-5">
    
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-4 mb-md-0 text-center">
            <div class="position-relative d-inline-block">
                <img src="uploads/logo.jpg" 
                     class="img-fluid rounded-4 shadow-lg mb-4" 
                     alt="Logo GameShop"
                     style="max-height: 400px; width: auto;">
            </div>
        </div>
        
        <div class="col-md-6 ps-md-5">
            <h2 class="fw-bold mb-3">Notre Mission</h2>
            <p class="lead text-dark">
                Fondé en 2026 par un passionné de code et de gaming, GameShop est né d'une volonté simple : rendre le jeu vidéo accessible à tous, sans compromis sur la qualité.
            </p>
            <p class="text-muted">
                Nous savons à quel point il est frustrant de chercher un jeu partout ou de payer trop cher. C'est pourquoi nous avons créé une plateforme fluide, rapide et sécurisée.
            </p>
            <p class="text-muted">
                Que vous soyez un joueur compétitif sur PC, un fan de la première heure sur Nintendo ou un collectionneur PlayStation, nous sélectionnons pour vous les meilleurs titres du moment.
            </p>
            
            <a href="catalog.php" class="btn btn-primary mt-3 px-4 rounded-pill">
                Découvrir notre catalogue
            </a>
        </div>
    </div>

    <div class="row text-center mt-5 pt-5 border-top">
        <div class="col-12 mb-5">
            <h2 class="fw-bold">Pourquoi nous choisir ?</h2>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 rounded-4 bg-light h-100 border-0 shadow-sm hover-card">
                <div class="display-4 mb-3">🚀</div>
                <h4 class="fw-bold">Livraison Instantanée</h4>
                <p class="text-muted small">
                    Vos jeux sont expédiés ou disponibles immédiatement après validation de la commande. On ne vous fait pas attendre.
                </p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 rounded-4 bg-light h-100 border-0 shadow-sm hover-card">
                <div class="display-4 mb-3">💎</div>
                <h4 class="fw-bold">Prix Justes</h4>
                <p class="text-muted small">
                    Nous négocions les meilleurs tarifs pour vous proposer des prix compétitifs toute l'année, pas seulement pendant les soldes.
                </p>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 rounded-4 bg-light h-100 border-0 shadow-sm hover-card">
                <div class="display-4 mb-3">🎧</div>
                <h4 class="fw-bold">Service Passionné</h4>
                <p class="text-muted small">
                    Une question ? Un problème ? Notre support client est composé de vrais joueurs qui comprennent vos besoins.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>

<?php require_once 'includes/footer.php'; ?>