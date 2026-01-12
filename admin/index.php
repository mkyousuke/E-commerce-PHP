<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';

// Vérification de sécurité pour ne laisser passer que l'admin (moi)
checkAdmin();

// Récupération de tous les jeux
$stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
$games = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Jeux</h1>
        <div>
            <a href="item_form.php" class="btn btn-primary">Ajouter un jeu</a>
            <a href="../index.php" class="btn btn-outline-secondary">Retour au site</a>
            <a href="users.php" class="btn btn-info text-white">Gérer les utilisateurs</a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Prix</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($games as $game): ?>
                    <tr>
                        <td><?= htmlspecialchars($game['nom']); ?></td>
                        <td><?= number_format($game['prix'], 2); ?> €</td>
                        <td>
                            <?php if($game['image']): ?>
                                <img src="../uploads/<?= $game['image']; ?>" alt="img" width="50">
                            <?php else: ?>
                                <span class="text-muted">Aucune</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="item_form.php?id=<?= $game['id']; ?>" class="btn btn-sm btn-warning">Modifier</a>
                            <a href="delete_item.php?id=<?= $game['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce jeu ?');">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>