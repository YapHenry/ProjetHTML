<?php
// Fichier : D:\INSTALLED\wamp\www\siteweb\db.php

$host = '127.0.0.1'; // On garde l'IP qui a fonctionné
$port = '3308';      // Le port validé par ton test
$dbname = 'bibliotheque';
$username = 'root';
$password = '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur db.php : " . $e->getMessage());
}
?>