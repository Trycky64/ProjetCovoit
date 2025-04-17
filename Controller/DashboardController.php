<?php
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$pdo = getPDO();
$userId = $_SESSION['user_id'];

// Récupérer les trajets créés et réservés par l'utilisateur
$createdTrips = Trip::getTripsByUser($pdo, $userId);
$reservedTrips = Trip::getReservedTripsByUser($pdo, $userId);

// Inclure la vue du tableau de bord
require_once __DIR__ . '/../View/dashboard.php';
