<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../Model/Trip.php';

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
    if (isset($_POST['trip_id'])) {
        $tripId = $_POST['trip_id'];
        $result = Trip::deleteTrip($pdo, $tripId, $userId);

        $_SESSION[$result ? 'success' : 'error'] = $result
            ? "Trajet annulé avec succès."
            : "Erreur lors de la suppression du trajet.";
    }

    if (isset($_POST['reservation_id'])) {
        $reservationId = $_POST['reservation_id'];
        $result = Trip::cancelReservation($pdo, $reservationId, $userId);

        $_SESSION[$result ? 'success' : 'error'] = $result
            ? "Réservation annulée avec succès."
            : "Erreur lors de l'annulation de la réservation.";
    }

    header('Location: index.php?page=dashboard');
    exit();
}
