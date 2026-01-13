<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) { header("Location: index.php"); exit; }

$id = $_GET['id'];
// On récupère aussi le stock pour l'afficher
$stmt = $pdo->prepare("SELECT i.*, s.quantite FROM items i JOIN stock s ON i.id = s.id_item WHERE i.id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) { echo "<div class='container mt-5'>Jeu introuvable.</div>"; require_once 'includes/footer.php'; exit; }
?>

<div style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
    /* On met l'image du jeu, ou une couleur par défaut si pas d'image */
    background: url('<?= $game['image'] ? "uploads/" . htmlspecialchars($game['image']) : "https://via.placeholder.com/1920x1080"; ?>') no-repeat center center/cover;
    /* Le filtre magique : flou + assombrissement */
    filter: blur(20px) brightness(0.7);
    /* On zoom un peu pour cacher les bords flous moches */
    transform: scale(1.1);
"></div>

<div class="container mt-5 mb-5">
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3 rounded shadow-sm bg-light">
            <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
            <li class="breadcrumb-item"><a href="catalog.php">Catalogue</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($game['nom']); ?></li>
        </ol>
    </nav>

    <div class="card shadow-lg border-0 rounded-4 p-4" style="background-color: rgba(255, 255, 255, 0.95);">
        <div class="row">
            <div class="col-md-5 mb-4 mb-md-0">
                <div class="card border-0 shadow overflow-hidden rounded-3">
                    <?php if ($game['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($game['image']); ?>" class="img-fluid w-100" alt="<?= htmlspecialchars($game['nom']); ?>" style="object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/600x600?text=No+Image" class="img-fluid w-100">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-3"><?= htmlspecialchars($game['nom']); ?></h1>
                
                <div class="mb-4">
                    <?php 
                    $plateformeList = explode(',', $game['plateforme'] ?? 'PC');
                    foreach($plateformeList as $p):
                        $p = trim($p);
                        $color = 'bg-secondary';
                        if ($p === 'Playstation') $color = 'bg-primary';
                        if ($p === 'Xbox') $color = 'bg-success';
                        if ($p === 'Nintendo') $color = 'bg-danger';
                        if ($p === 'PC') $color = 'bg-dark';
                    ?>
                        <span class="badge <?= $color; ?> fs-6 me-1 px-3 py-2 rounded-pill shadow-sm"><?= htmlspecialchars($p); ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3 border">
                    <span class="display-5 text-primary fw-bold me-4"><?= number_format($game['prix'], 2); ?> €</span>
                    
                    <?php if($game['quantite'] > 0): ?>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2">
                            ✅ En stock (<?= $game['quantite']; ?> ex.)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2">
                            ❌ Rupture de stock
                        </span>
                    <?php endif; ?>
                </div>

                <h5 class="text-muted mb-2">À propos du jeu</h5>
                <p class="lead mb-5" style="font-size: 1.1rem;">
                    <?= nl2br(htmlspecialchars($game['description'])); ?>
                </p>

                <div class="card bg-light border-0 p-4 rounded-3 shadow-sm">
                    <form action="cart.php" method="GET" class="row g-3 align-items-center">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?= $game['id']; ?>">
                        
                        <div class="col-auto">
                            <label class="visually-hidden">Quantité</label>
                            <select name="quantity" class="form-select form-select-lg">
                                <?php 
                                $max = min(5, $game['quantite']);
                                for($i=1; $i<=$max; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="col">
                            <?php if($game['quantite'] > 0): ?>
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow fw-bold transition-button">
                                    Ajouter au panier 🛒
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                                    Indisponible
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-button:hover {
        transform: translateY(-2px);
    }
</style>

<?php require_once 'includes/footer.php'; ?>