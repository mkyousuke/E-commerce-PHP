<?php
// index.php (Racine du site)
require_once 'config/db.php';
require_once 'includes/header.php';

// On récupère les 6 derniers jeux pour les afficher en nouveautés
$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC LIMIT 6");
$games = $stmt->fetchAll();
?>

<div class="p-5 mb-4 bg-light rounded-3 text-center border">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Bienvenue sur GameShop</h1>
        <p class="col-md-8 fs-4 mx-auto">Le meilleur du jeu vidéo au meilleur prix.</p>
        <a href="#jeux" class="btn btn-primary btn-lg">Voir les jeux</a>
    </div>
</div>

<div class="container" id="jeux">
    <h2 class="mb-4">Nos derniers jeux</h2>
    
    <?php if(empty($games)): ?>
        <div class="alert alert-warning">Aucun jeu n'est disponible pour le moment.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($games as $game): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div style="height: 250px; overflow: hidden; background: #eee; display: flex; align-items: center; justify-content: center;">
                        <?php if($game['image']): ?>
                            <img src="uploads/<?= htmlspecialchars($game['image']); ?>" alt="<?= htmlspecialchars($game['nom']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <span class="text-muted">Pas d'image</span>
                        <?php endif; ?>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($game['nom']); ?></h5>
                        <p class="card-text text-truncate"><?= htmlspecialchars($game['description']); ?></p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0 text-primary"><?= number_format($game['prix'], 2); ?> €</span>
                            <a href="product.php?id=<?= $game['id']; ?>" class="btn btn-outline-primary btn-sm">
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>