<?php
// On démarre la session avant tout HTML pour pouvoir faire des redirections (header location)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

// --- LOGIQUE DU PANIER (Ajout / Suppression / Vider) ---

// 1. Initialiser le panier s'il n'existe pas encore
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// 2. ACTION : Ajouter un produit
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $qty = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

    // Si le produit est déjà dans le panier, on augmente la quantité
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty; // Sinon on l'ajoute
    }
    
    // On redirige vers la page panier pour éviter de renvoyer le formulaire en actualisant
    header("Location: cart.php");
    exit;
}

// 3. ACTION : Supprimer un produit
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    unset($_SESSION['cart'][$id]); // On retire l'ID du tableau de session
    header("Location: cart.php");
    exit;
}

// 4. ACTION : Vider le panier
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

// --- AFFICHAGE DE LA PAGE ---
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Votre Panier</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info py-5 text-center">
            <h3>Votre panier est vide 🛒</h3>
            <p class="mt-3">Découvrez nos nouveautés et remplissez-le !</p>
            <a href="index.php" class="btn btn-primary mt-2">Retourner à la boutique</a>
        </div>
    <?php else: ?>
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50%;">Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPanier = 0;
                        
                        // Récupération des IDs des produits présents dans le panier
                        $ids = array_keys($_SESSION['cart']);
                        
                        // S'il y a des IDs, on fait la requête SQL
                        if(!empty($ids)) {
                            // On transforme le tableau [1, 5, 8] en chaine "1,5,8" pour le SQL
                            $idList = implode(',', $ids);
                            $stmt = $pdo->query("SELECT * FROM items WHERE id IN ($idList)");
                            $items = $stmt->fetchAll();
                        } else {
                            $items = [];
                        }

                        foreach ($items as $item):
                            // On récupère la quantité stockée en session pour cet item
                            $qty = $_SESSION['cart'][$item['id']];
                            $totalLigne = $item['prix'] * $qty;
                            $totalPanier += $totalLigne;
                        ?>
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <?php if($item['image']): ?>
                                        <img src="uploads/<?= htmlspecialchars($item['image']); ?>" alt="img" width="50" height="50" class="rounded me-3" style="object-fit: cover;">
                                    <?php endif; ?>
                                    <strong><?= htmlspecialchars($item['nom']); ?></strong>
                                </div>
                            </td>
                            <td class="align-middle"><?= number_format($item['prix'], 2); ?> €</td>
                            <td class="align-middle"><?= $qty; ?></td>
                            <td class="align-middle fw-bold"><?= number_format($totalLigne, 2); ?> €</td>
                            <td class="align-middle">
                                <a href="cart.php?action=delete&id=<?= $item['id']; ?>" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                    Retirer du panier
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <a href="index.php" class="btn btn-outline-secondary">← Continuer mes achats</a>
                <a href="cart.php?action=clear" class="btn btn-outline-danger ms-2" onclick="return confirm('Voulez-vous vraiment vider le panier ?');">Vider le panier</a>
            </div>
            
            <div class="col-md-6">
                <div class="card bg-light border-0 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="h4 mb-0">Total à payer :</span>
                        <span class="h3 mb-0 text-primary fw-bold"><?= number_format($totalPanier, 2); ?> €</span>
                    </div>

                    <hr>

                    <?php if(isset($_SESSION['user_id'])): ?>
                        <form action="checkout.php" method="POST">
                            <button type="submit" class="btn btn-success btn-lg w-100 py-3 shadow-sm">
                                Payer et Commander ✅
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning mb-0 text-center">
                            Vous devez être connecté pour valider la commande.
                            <br>
                            <a href="login.php" class="btn btn-warning mt-2 fw-bold">Se connecter</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>