<?php
require_once 'config/db.php';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // Validation basique
    if ($pass !== $confirm_pass) {
        $error = "Les mots de passe ne correspondent pas.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format d'email invalide.";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // HACHAGE DU MOT DE PASSE 
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Insertion en base de données
            $insert = $pdo->prepare("INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, 'user')");
            if ($insert->execute([$nom, $email, $hashed_password])) {
                $success = "Compte créé avec succès ! Vous pouvez vous connecter.";
            } else {
                $error = "Une erreur est survenue lors de l'inscription.";
            }
        }
    }
}

require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="mb-4">Inscription</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
        </form>
        <p class="mt-3">Déjà un compte ? <a href="login.php">Connectez-vous ici</a>.</p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>