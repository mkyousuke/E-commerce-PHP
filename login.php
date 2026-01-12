<?php
// login.php
require_once 'config/db.php';
require_once 'includes/header.php'; // Session_start est dedans

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $pass = $_POST['password'];

    // Recherche de l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe haché
    if ($user && password_verify($pass, $user['password'])) {
        // Connexion réussie : on stocke les infos en session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_role'] = $user['role'];

        // Redirection vers l'accueil ou l'admin selon le rôle
        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error = "Email ou mot de passe incorrect.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-5">
        <h2 class="mb-4">Connexion</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Se connecter</button>
        </form>
        <p class="mt-3">Pas encore de compte ? <a href="register.php">Inscrivez-vous ici</a>.</p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>