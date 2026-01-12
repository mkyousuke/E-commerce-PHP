<?php
// On doit démarrer la session avant tout HTML pour gérer les redirections
// (header.php le fait aussi, mais on a besoin de traiter la logique avant l'affichage)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config/db.php';

// --- LOGIQUE DU PANIER (Ajout / Suppression / Vider) ---

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ACTION : Ajouter un produit
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $qty = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

    // Si le produit est déjà dans le panier, on augmente la quantité
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] += $qty;
    } else {
        $_SESSION['cart'][$id] = $qty;
    }
    
    // On redirige pour éviter de renvoyer le formulaire en actualisant
    header("Location: cart.php");
    exit;
}

// ACTION : Supprimer un produit
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}

// ACTION : Vider le panier
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

// --- AFFICHAGE DU PANIER ---
require_once 'includes/header.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Votre Panier</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">
            Votre panier est vide. <a href="index.php">Retourner à la boutique</a>.
        </div>
    <?php else: ?>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-light">
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPanier = 0;
                // On parcourt le panier pour récupérer les infos de chaque jeu en BDD
                $ids = array_keys($_SESSION['cart']);
                // Convertir le tableau d'IDs en chaîne pour la requête SQL (ex: 1,3,5)
                if(!empty($ids)) {
                    $idList = implode(',', $ids);
                    $stmt = $pdo->query("SELECT * FROM items WHERE id IN ($idList)");
                    $items = $stmt->fetchAll();
                } else {
                    $items = [];
                }

                foreach ($items as $item):
                    $qty = $_SESSION['cart'][$item['id']];
                    $totalLigne = $item['prix'] * $qty;
                    $totalPanier += $totalLigne;
                ?>
                <tr>
                    <td>
                        <strong><?= htmlspecialchars($item['nom']); ?></strong>
                    </td>
                    <td><?= number_format($item['prix'], 2); ?> €</td>
                    <td><?= $qty; ?></td>
                    <td><?= number_format($totalLigne, 2); ?> €</td>
                    <td>
                        <a href="cart.php?action=delete&id=<?= $item['id']; ?>" class="btn btn-sm btn-danger">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total Général :</td>
                    <td colspan="2" class="fw-bold fs-5"><?= number_format($totalPanier, 2); ?> €</td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-between">
            <a href="cart.php?action=clear" class="btn btn-outline-danger" onclick="return confirm('Voulez-vous vraiment vider le panier ?');">Vider le panier</a>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <button class="btn btn-primary btn-lg">Valider la commande</button>
            <?php else: ?>
                <a href="login.php" class="btn btn-warning btn-lg">Connectez-vous pour commander</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>