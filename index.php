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
        <a href="catalog.php" class="btn btn-primary btn-lg">Voir tout le catalogue</a>
    </div>
</div>

<div class="container" id="jeux">
    <h2 class="mb-4">Nos dernières nouveautés</h2>
    
    <?php if(empty($games)): ?>
        <div class="alert alert-warning">Aucun jeu n'est disponible pour le moment.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($games as $game): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 hover-effect">
                    
                    <div style="height: 250px; overflow: hidden; background: #eee; position: relative;">
                        <a href="product.php?id=<?= $game['id']; ?>">
                            <?php if($game['image']): ?>
                                <img src="uploads/<?= htmlspecialchars($game['image']); ?>" alt="<?= htmlspecialchars($game['nom']); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">Pas d'image</div>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <?php 
                            $rawPlateforme = isset($game['plateforme']) ? $game['plateforme'] : 'PC';
                            $plateformeList = explode(',', $rawPlateforme);
                            
                            foreach($plateformeList as $p):
                                $p = trim($p);
                                $badgeColor = 'bg-secondary';
                                
                                if ($p === 'Playstation') $badgeColor = 'bg-primary';
                                if ($p === 'Xbox') $badgeColor = 'bg-success';
                                if ($p === 'Nintendo') $badgeColor = 'bg-danger';
                                if ($p === 'PC') $badgeColor = 'bg-dark';
                            ?>
                                <span class="badge <?= $badgeColor; ?> me-1" style="font-size: 0.75rem;"><?= htmlspecialchars($p); ?></span>
                            <?php endforeach; ?>
                        </div>

                        <h5 class="card-title text-truncate">
                            <a href="product.php?id=<?= $game['id']; ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($game['nom']); ?>
                            </a>
                        </h5>
                        <p class="card-text text-truncate text-muted small"><?= htmlspecialchars($game['description']); ?></p>
                        
                        <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="h5 mb-0 text-primary fw-bold"><?= number_format($game['prix'], 2); ?> €</span>
                            
                            <div>
                                <a href="product.php?id=<?= $game['id']; ?>" class="btn btn-outline-secondary btn-sm me-1">
                                    Détails
                                </a>
                                
                                <a href="cart.php?action=add&id=<?= $game['id']; ?>" class="btn btn-primary btn-sm shadow-sm">
                                    Ajouter au panier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>