<?php
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../Model/TripStop.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirection si non connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$pdo = getPDO();
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure = $_POST['departure'] ?? '';
    $arrival = $_POST['arrival'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $seats = $_POST['seats'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $estimated_arrival_time = $_POST['estimated_arrival_time'] ?? null;

    if (empty($estimated_arrival_time)) {
        $_SESSION['error'] = "L'heure d'arrivée estimée est obligatoire.";
        header('Location: index.php?page=create_trip');
        exit();
    }

    try {
        // Création du trajet
        $trip = new Trip($departure, $arrival, $date, $time, $seats, $price, $userId, $estimated_arrival_time);
        $tripId = Trip::create($pdo, $trip);

        // Lieux intermédiaires
        $stops = $_POST['stops'] ?? [];
        $times = $_POST['stop_times'] ?? [];

        for ($i = 0; $i < count($stops); $i++) {
            $location = trim($stops[$i]);
            $stopTime = $times[$i] ?? null;

            if (!empty($location) && !empty($stopTime)) {
                TripStop::create($pdo, $tripId, $location, $stopTime);
            }
        }

        $_SESSION['success'] = "Trajet créé avec succès.";
        header('Location: index.php?page=dashboard');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de la création du trajet : " . $e->getMessage();
        header('Location: index.php?page=create_trip');
        exit();
    }
}

require_once __DIR__ . '/../View/create_trip.php';
