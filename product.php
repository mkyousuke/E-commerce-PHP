<?php
require_once 'config/db.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) { header("Location: index.php"); exit; }

$id = $_GET['id'];
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
    background: url('<?= $game['image'] ? "uploads/" . htmlspecialchars($game['image']) : "https://via.placeholder.com/1920x1080"; ?>') no-repeat center center/cover;
    filter: blur(15px) brightness(0.5); /* Plus sombre pour faire ressortir le verre */
    transform: scale(1.1);
"></div>

<div class="container mt-5 mb-5">
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb p-3 rounded-3" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.1);">
            <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Accueil</a></li>
            <li class="breadcrumb-item"><a href="catalog.php" class="text-white text-decoration-none">Catalogue</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page"><?= htmlspecialchars($game['nom']); ?></li>
        </ol>
    </nav>

    <div class="card border-0 rounded-4 p-4 shadow-lg" style="
        background: rgba(255, 255, 255, 0.15); /* Transparence */
        backdrop-filter: blur(15px);          /* L'effet verre dépoli */
        -webkit-backdrop-filter: blur(15px);  /* Pour Safari */
        border: 1px solid rgba(255, 255, 255, 0.2); /* Bordure subtile */
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); /* Ombre profonde */
        color: white; /* Texte en blanc force */
    ">
        <div class="row">
            <div class="col-md-5 mb-4 mb-md-0">
                <div class="card border-0 shadow-lg overflow-hidden rounded-3">
                    <?php if ($game['image']): ?>
                        <img src="uploads/<?= htmlspecialchars($game['image']); ?>" class="img-fluid w-100" alt="<?= htmlspecialchars($game['nom']); ?>" style="object-fit: cover;">
                    <?php else: ?>
                        <img src="https://via.placeholder.com/600x600?text=No+Image" class="img-fluid w-100">
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-7">
                <h1 class="display-4 fw-bold mb-3 text-white"><?= htmlspecialchars($game['nom']); ?></h1>
                
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
                        <span class="badge <?= $color; ?> fs-6 me-1 px-3 py-2 rounded-pill shadow-sm border border-light border-opacity-25"><?= htmlspecialchars($p); ?></span>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex align-items-center mb-4 p-3 rounded-3 border border-white border-opacity-25" style="background: rgba(0,0,0,0.2);">
                    <span class="display-5 fw-bold me-4 text-white"><?= number_format($game['prix'], 2); ?> €</span>
                    
                    <?php if($game['quantite'] > 0): ?>
                        <span class="badge bg-success text-white border border-light border-opacity-50 px-3 py-2">
                            En stock (<?= $game['quantite']; ?>)
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger text-white border border-light border-opacity-50 px-3 py-2">
                            Rupture
                        </span>
                    <?php endif; ?>
                </div>

                <h5 class="text-white-50 mb-2">À propos du jeu</h5>
                <p class="lead mb-5 text-light" style="font-size: 1.1rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    <?= nl2br(htmlspecialchars($game['description'])); ?>
                </p>

                <div class="p-4 rounded-3 shadow-sm" style="background: rgba(0, 0, 0, 0.3); border: 1px solid rgba(255,255,255,0.1);">
                    <form action="cart.php" method="GET" class="row g-3 align-items-center">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?= $game['id']; ?>">
                        
                        <div class="col-auto">
                            <label class="visually-hidden">Quantité</label>
                            <select name="quantity" class="form-select form-select-lg bg-dark text-white border-secondary">
                                <?php 
                                $max = min(5, $game['quantite']);
                                for($i=1; $i<=$max; $i++): ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <div class="col">
                            <?php if($game['quantite'] > 0): ?>
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow fw-bold transition-button" style="background-color: #6f42c1; border-color: #6f42c1;">
                                    Ajouter au panier 
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
    /* Animation au survol du bouton */
    .transition-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(111, 66, 193, 0.4); /* Lueur violette */
    }
    
    /* Pour que le select soit joli même ouvert */
    select option {
        background-color: #333;
        color: white;
    }
</style>

<?php require_once 'includes/footer.php'; ?>