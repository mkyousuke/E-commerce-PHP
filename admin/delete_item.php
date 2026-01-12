<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
checkAdmin();

// Vérifier si un ID est bien passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. On récupère le nom de l'image pour supprimer le fichier physique
    $stmt = $pdo->prepare("SELECT image FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    if ($item) {
        // Supprimer le fichier image du dossier s'il existe
        if ($item['image'] && file_exists("../uploads/" . $item['image'])) {
            unlink("../uploads/" . $item['image']);
        }

        // 2. Supprimer l'entrée dans la base de données
        $delete = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $delete->execute([$id]);
    }
}

// Une fois supprimé, on retourne au tableau de bord
header("Location: index.php");
exit;
?>