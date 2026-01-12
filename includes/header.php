<?php
session_start(); // Démarrage de la session ici pour toutes les pages
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>GameShop - Vente de jeux vidéo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">GameShop</a>
    <div class="navbar-nav">
      <a class="nav-link" href="index.php">Accueil</a>
      <a class="nav-link" href="catalog.php">Jeux</a>
      <a class="nav-link" href="about.php">Qui sommes-nous ?</a>
      <a class="nav-link" href="cart.php">Panier</a>
      <a class="nav-link" href="login.php">Connexion</a>
    </div>
  </div>
</nav>
<div class="container mt-4">