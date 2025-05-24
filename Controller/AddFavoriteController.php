<?php
require_once __DIR__ . '/../config/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_GET['driver_id'])) {
    header('Location: index.php?page=trip_history');
    exit;
}

$pdo = getPDO();
$userId = $_SESSION['user_id'];
$driverId = (int) $_GET['driver_id'];

if ($userId === $driverId) {
    $_SESSION['error'] = "Vous ne pouvez pas vous ajouter vous-même.";
    header('Location: index.php?page=trip_history');
    exit;
}

$stmt = $pdo->prepare("INSERT IGNORE INTO preferred_drivers (user_id, driver_id) VALUES (?, ?)");
$stmt->execute([$userId, $driverId]);

$_SESSION['success'] = "Chauffeur ajouté à vos favoris.";
header('Location: index.php?page=trip_history&refreshed=' . time());
exit;
