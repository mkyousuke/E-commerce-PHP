<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
checkAdmin();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sécurité : Empêcher l'admin de se supprimer lui-même
    if ($id == $_SESSION['user_id']) {
        die("Vous ne pouvez pas supprimer votre propre compte.");
    }

    // Suppression (La base de données gère les commandes liées si configurée, sinon l'user est juste supprimé)
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: users.php");
exit;
?>