<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard.php"); exit();
}

$type = $_POST['type']; 
$id_ligne = intval($_POST['id']);

if ($type === 'livre') {
    // Finir emprunt
    $stmt = $pdo->prepare("UPDATE emprunts SET statut = 'termine', date_retour = NOW() WHERE id = ?");
    $stmt->execute([$id_ligne]);

} elseif ($type === 'espace') {
    // Finir réservation
    $stmt = $pdo->prepare("UPDATE reservations SET statut = 'terminee', date_fin = NOW() WHERE id = ?");
    $stmt->execute([$id_ligne]);

    // RENDRE DISPONIBLE POUR TOUT LE MONDE
    if (isset($_POST['espace_id'])) {
        $espace_id = intval($_POST['espace_id']);
        $stmtFree = $pdo->prepare("UPDATE espaces SET est_disponible = 1 WHERE id = ?");
        $stmtFree->execute([$espace_id]);
    }
}

header("Location: dashboard.php?msg=retour_ok");
exit();
?>