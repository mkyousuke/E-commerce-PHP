<?php

$host = 'localhost';
$dbname = 'gameshop_db';
$username = 'root';
$password = '';

try {
    // Connexion via PDO 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configuration pour afficher les erreurs SQL pendant le développement
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Si la connexion échoue, l'erreur s'affiche et le script s'arrête
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>