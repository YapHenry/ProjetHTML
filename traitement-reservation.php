<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) { header("Location: connexion.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['espace_id'])) {
    $user_id = $_SESSION['user_id'];
    $espace_id = intval($_POST['espace_id']);

    try {
        $pdo->beginTransaction();

        // Vérif disponibilité
        $stmtCheck = $pdo->prepare("SELECT est_disponible FROM espaces WHERE id = ?");
        $stmtCheck->execute([$espace_id]);
        $espace = $stmtCheck->fetch();

        if ($espace && $espace['est_disponible'] == 1) {
            // Créer résa
            $stmtInsert = $pdo->prepare("INSERT INTO reservations (user_id, espace_id, date_reservation) VALUES (?, ?, NOW())");
            $stmtInsert->execute([$user_id, $espace_id]);

            // BLOQUER L'ESPACE
            $stmtUpdate = $pdo->prepare("UPDATE espaces SET est_disponible = 0 WHERE id = ?");
            $stmtUpdate->execute([$espace_id]);

            $pdo->commit();
            header("Location: dashboard.php?msg=reservation_ok");
        } else {
            $pdo->rollBack();
            header("Location: detail_space.php?id=$espace_id&erreur=indisponible");
        }
        exit();
    } catch (Exception $e) { $pdo->rollBack(); die("Erreur : " . $e->getMessage()); }
} else {
    header("Location: catalogue-space.php"); exit();
}
?>