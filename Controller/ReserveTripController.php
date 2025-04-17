<?php
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$pdo = getPDO();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tripId = $_POST['trip_id'];
    $seats = $_POST['seats'];

    try {
        Trip::reserveTrip($pdo, $tripId, $userId, $seats);
        $_SESSION['success'] = "Réservation effectuée avec succès.";
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

require_once __DIR__ . '/../View/reserve_trip.php';
