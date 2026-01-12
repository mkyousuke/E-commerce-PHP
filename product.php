<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Vérifier si un ID est passé dans l'URL
if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Aucun produit sélectionné.</div>";
    require_once 'includes/footer.php';
    exit;
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$game = $stmt->fetch();

if (!$game) {
    echo "<div class='alert alert-danger'>Ce jeu n'existe pas.</div>";
    require_once 'includes/footer.php';
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <?php if ($game['image']): ?>
                <img src="uploads/<?= htmlspecialchars($game['image']); ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($game['nom']); ?>">
            <?php else: ?>
                <img src="https://via.placeholder.com/600x400?text=Pas+d'image" class="img-fluid rounded shadow" alt="Pas d'image">
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1 class="display-5"><?= htmlspecialchars($game['nom']); ?></h1>

<span class="badge bg-secondary fs-6 mb-3"><?= htmlspecialchars($game['plateforme']); ?></span>
<h3 class="text-primary my-3"><?= number_format($game['prix'], 2); ?> €</h3>
            
            <p class="lead"><?= nl2br(htmlspecialchars($game['description'])); ?></p>
            
            <hr>

            <form action="cart.php" method="GET" class="d-flex align-items-center">
                <input type="hidden" name="action" value="add">
                <input type="hidden" name="id" value="<?= $game['id']; ?>">
                
                <div class="me-3">
                    <label for="quantity" class="visually-hidden">Quantité</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" style="width: 80px;">
                </div>
                
                <button type="submit" class="btn btn-success btn-lg w-100">
                    Ajouter au panier
                </button>
            </form>

            <div class="mt-4">
                <small class="text-muted">Référence produit : #<?= $game['id']; ?></small><br>
                <a href="index.php" class="btn btn-outline-secondary mt-2">← Retour au catalogue</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>