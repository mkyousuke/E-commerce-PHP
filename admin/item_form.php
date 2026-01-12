<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
checkAdmin();

$error = null;
$success = null;

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock']; // On gère le stock ici directement pour simplifier

    // GESTION DE L'IMAGE
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            // On renomme l'image pour éviter les doublons (ex: jeu_65a4b...jpg)
            $imageName = 'game_' . uniqid() . '.' . $ext;
            // On déplace le fichier dans le dossier uploads
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
        } else {
            $error = "Format d'image invalide (JPG, PNG, WEBP uniquement).";
        }
    }

    if (!$error) {
        // Insertion du Jeu
        $stmt = $pdo->prepare("INSERT INTO items (nom, description, prix, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $prix, $imageName]);
        
        // Récupération de l'ID du jeu qu'on vient de créer
        $id_item = $pdo->lastInsertId();

        // Insertion du Stock initial
        $stmtStock = $pdo->prepare("INSERT INTO stock (id_item, quantite) VALUES (?, ?)");
        $stmtStock->execute([$id_item, $stock]);

        // Redirection vers le dashboard
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3>Ajouter un nouveau jeu</h3>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Titre du jeu</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prix (€)</label>
                                <input type="number" step="0.01" name="prix" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock initial</label>
                                <input type="number" name="stock" class="form-control" value="10" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image (Jaquette)</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Enregistrer le jeu</button>
                        <a href="index.php" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>