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

$stmt = $pdo->prepare("DELETE FROM preferred_drivers WHERE user_id = ? AND driver_id = ?");
$stmt->execute([$userId, $driverId]);

$_SESSION['success'] = "Chauffeur retiré de vos favoris.";
header('Location: index.php?page=trip_history&refreshed=' . time());
exit;
