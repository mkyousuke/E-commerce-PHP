<?php

function checkAdmin() {
    // Si la session n'est pas démarrée ou si le rôle n'est pas admin
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        // On redirige vers la connexion
        header("Location: ../login.php");
        exit;
    }
}
?>