<?php
session_start();
require_once '../config/db.php';
require_once '../includes/functions.php';
checkAdmin();

$error = null;

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];

    // TRAITEMENT DES PLATEFORMES MULTIPLES
    // On reçoit un tableau de cases cochées, on le transforme en texte séparé par des virgules
    if (isset($_POST['plateforme']) && is_array($_POST['plateforme'])) {
        $plateforme = implode(', ', $_POST['plateforme']); // Deviendra "PC, Xbox" par exemple
    } else {
        $plateforme = "PC"; // Valeur par défaut si rien n'est coché
    }

    // GESTION DE L'IMAGE
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $imageName = 'game_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
        } else {
            $error = "Format d'image invalide.";
        }
    }

    if (!$error) {
        $stmt = $pdo->prepare("INSERT INTO items (nom, description, prix, image, plateforme) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $prix, $imageName, $plateforme]);
        
        $id_item = $pdo->lastInsertId();
        $stmtStock = $pdo->prepare("INSERT INTO stock (id_item, quantite) VALUES (?, ?)");
        $stmtStock->execute([$id_item, $stock]);

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
                    <h3>Ajouter un jeu multi-plateforme</h3>
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
                            <label class="form-label d-block">Plateformes disponibles</label>
                            
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="plateforme[]" value="PC" id="pc">
                                <label class="form-check-label" for="pc">PC</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="plateforme[]" value="Playstation" id="ps">
                                <label class="form-check-label" for="ps">Playstation</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="plateforme[]" value="Xbox" id="xbox">
                                <label class="form-check-label" for="xbox">Xbox</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="plateforme[]" value="Nintendo" id="nintendo">
                                <label class="form-check-label" for="nintendo">Nintendo</label>
                            </div>
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
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Enregistrer</button>
                        <a href="index.php" class="btn btn-secondary">Annuler</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>