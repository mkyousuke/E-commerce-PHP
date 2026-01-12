<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
checkAdmin();

// Récupérer la liste des utilisateurs
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des Utilisateurs</h1>
        <a href="index.php" class="btn btn-secondary">Retour au Dashboard</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id']; ?></td>
                        <td><?= htmlspecialchars($user['nom']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td>
                            <?php if($user['role'] === 'admin'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark">Client</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($user['id'] != $_SESSION['user_id']): ?>
                                <a href="delete_user.php?id=<?= $user['id']; ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir bannir cet utilisateur ?');">
                                   Supprimer
                                </a>
                            <?php else: ?>
                                <span class="text-muted text-small">Vous</span>
                            <?php endif; ?>
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