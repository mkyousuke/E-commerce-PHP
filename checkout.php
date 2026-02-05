<?php
session_start();
require_once 'config/db.php';

// 1. Sécurité : Si pas connecté ou panier vide, on redirige
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart = $_SESSION['cart']; // Tableau [id_jeu => quantité]

try {
    // On démarre la transaction SQL
    $pdo->beginTransaction();

    // A. Calculer le montant total et récupérer les vrais produits
    // On récupère les IDs du panier
    $ids = array_keys($cart);
    
    // Protection si le panier contient des IDs bizarres
    if (empty($ids)) {
        header("Location: cart.php");
        exit;
    }

    $idList = implode(',', $ids);
    
    // On récupère les infos fraîches depuis la BDD
    $stmt = $pdo->query("SELECT * FROM items WHERE id IN ($idList)");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalAmount = 0;

    // B. Vérification des stocks et calcul
    foreach ($items as $item) {
        // On récupère la quantité demandée pour ce jeu spécifique
        $qtyDemandee = $cart[$item['id']];
        
        // On vérifie le stock réel en base
        $stmtStock = $pdo->prepare("SELECT quantite FROM stock WHERE id_item = ?");
        $stmtStock->execute([$item['id']]);
        $stockDispo = $stmtStock->fetchColumn();

        if ($stockDispo < $qtyDemandee) {
            // Annulation si pas assez de stock
            throw new Exception("Stock insuffisant pour le jeu : " . $item['nom']);
        }
        
        $totalAmount += $item['prix'] * $qtyDemandee;
    }

    // C. Créer la Facture (Table invoice)
    $stmtInvoice = $pdo->prepare("INSERT INTO invoice (id_user, montant, adresse, ville, code_postal) VALUES (?, ?, 'Adresse par defaut', 'Ville', '00000')");
    $stmtInvoice->execute([$user_id, $totalAmount]);
    
    // D. Enregistrer les commandes et baisser le stock
    foreach ($items as $item) {
        $id_item = $item['id'];
        $qty = $cart[$id_item];

        // 1. Enregistrer l'achat
        $stmtOrder = $pdo->prepare("INSERT INTO orders (id_user, id_item) VALUES (?, ?)");
        $stmtOrder->execute([$user_id, $id_item]);

        // 2. Mettre à jour le stock
        $stmtUpdateStock = $pdo->prepare("UPDATE stock SET quantite = quantite - ? WHERE id_item = ?");
        $stmtUpdateStock->execute([$qty, $id_item]);
    }

    // Si tout est bon, on valide !
    $pdo->commit();

    // On vide le panier
    unset($_SESSION['cart']);

    // Redirection vers le succès
    header("Location: success.php");
    exit;

} catch (Exception $e) {
    // En cas d'erreur, on annule tout
    $pdo->rollBack();
    die("Erreur : " . $e->getMessage() . " <br><a href='cart.php'>Retour au panier</a>");
}