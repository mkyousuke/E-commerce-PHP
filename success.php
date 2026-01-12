<?php
require_once 'includes/header.php';
?>

<div class="container mt-5 text-center">
    <div class="card shadow-sm p-5 border-0 bg-light">
        <div class="card-body">
            <h1 class="display-4 text-success mb-4">Commande validée ! 🎉</h1>
            <p class="lead">Merci pour votre achat chez GameShop.</p>
            <p>Votre commande a bien été enregistrée et les jeux seront bientôt expédiés.</p>
            
            <hr class="my-4">
            
            <a href="index.php" class="btn btn-primary btn-lg">Retour à la boutique</a>
            <a href="cart.php" class="btn btn-outline-secondary btn-lg">Voir mon panier (vide)</a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>