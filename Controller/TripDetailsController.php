<?php
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../Model/TripStop.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['trip_id'])) {
    header('Location: index.php?page=search_trips');
    exit();
}

$pdo = getPDO();
$tripId = (int) $_GET['trip_id'];

// Récupérer les détails du trajet
$trip = Trip::getTripById($pdo, $tripId);

// Récupérer les étapes du trajet
$tripStops = TripStop::getByTripId($pdo, $tripId);

// Inclure la vue des détails du trajet
require_once __DIR__ . '/../View/trip_details.php';
