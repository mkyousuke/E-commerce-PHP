<?php
// catalog.php
require_once 'config/db.php';
require_once 'includes/header.php';

// --- LOGIQUE DE FILTRAGE ---
$sql = "SELECT * FROM items WHERE 1=1"; // Astuce SQL : permet d'ajouter des "AND" facilement
$params = [];

// 1. Recherche par nom
$search = $_GET['search'] ?? '';
if ($search) {
    $sql .= " AND nom LIKE ?";
    $params[] = "%$search%";
}

// 2. Filtre par Plateforme
$platform = $_GET['platform'] ?? '';
if ($platform) {
    $sql .= " AND plateforme LIKE ?";
    $params[] = "%$platform%";
}

// 3. Filtre par Prix Max
$priceMax = $_GET['price_max'] ?? '';
if ($priceMax) {
    $sql .= " AND prix <= ?";
    $params[] = $priceMax;
}

$sql .= " ORDER BY id DESC"; // Les plus récents en premier

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$games = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h5 class="card-title mb-3">🔍 Filtrer les jeux</h5>
                    <form action="catalog.php" method="GET">
                        
                        <div class="mb-3">
                            <label class="form-label">Recherche</label>
                            <input type="text" name="search" class="form-control" placeholder="Mario, Zelda..." value="<?= htmlspecialchars($search) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Plateforme</label>
                            <select name="platform" class="form-select">
                                <option value="">Toutes</option>
                                <option value="PC" <?= $platform === 'PC' ? 'selected' : '' ?>>PC</option>
                                <option value="Playstation" <?= $platform === 'Playstation' ? 'selected' : '' ?>>Playstation</option>
                                <option value="Xbox" <?= $platform === 'Xbox' ? 'selected' : '' ?>>Xbox</option>
                                <option value="Nintendo" <?= $platform === 'Nintendo' ? 'selected' : '' ?>>Nintendo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix maximum : <span id="priceVal"><?= $priceMax ? $priceMax : '100'; ?></span>€</label>
                            <input type="range" name="price_max" class="form-range" min="0" max="100" step="5" 
                                   value="<?= $priceMax ? $priceMax : '100'; ?>" 
                                   oninput="document.getElementById('priceVal').innerText = this.value">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Appliquer les filtres</button>
                        <a href="catalog.php" class="btn btn-link w-100 mt-2">Réinitialiser</a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <h2 class="mb-4">Catalogue (<?= count($games); ?> résultats)</h2>

            <?php if (empty($games)): ?>
                <div class="alert alert-info">Aucun jeu ne correspond à vos critères.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($games as $game): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 hover-effect">
                            <div style="height: 200px; overflow: hidden; position: relative;">
                                <a href="product.php?id=<?= $game['id']; ?>">
                                    <?php if($game['image']): ?>
                                        <img src="uploads/<?= htmlspecialchars($game['image']); ?>" class="card-img-top" alt="img" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/300" class="card-img-top" style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php endif; ?>
                                </a>
                                <span class="badge bg-dark position-absolute top-0 end-0 m-2 fs-6">
                                    <?= number_format($game['prix'], 2); ?> €
                                </span>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <?php 
                                    $plateformeList = explode(',', $game['plateforme'] ?? '');
                                    foreach($plateformeList as $p):
                                        $p = trim($p);
                                        $color = 'bg-secondary';
                                        if ($p === 'Playstation') $color = 'bg-primary';
                                        if ($p === 'Xbox') $color = 'bg-success';
                                        if ($p === 'Nintendo') $color = 'bg-danger';
                                        if ($p === 'PC') $color = 'bg-dark';
                                    ?>
                                        <span class="badge <?= $color; ?> me-1" style="font-size: 0.7rem;"><?= htmlspecialchars($p); ?></span>
                                    <?php endforeach; ?>
                                </div>

                                <h5 class="card-title text-truncate">
                                    <a href="product.php?id=<?= $game['id']; ?>" class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($game['nom']); ?>
                                    </a>
                                </h5>
                                
                                <div class="mt-auto d-grid gap-2">
                                    <a href="cart.php?action=add&id=<?= $game['id']; ?>" class="btn btn-outline-success btn-sm">
                                        Ajouter au panier
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>