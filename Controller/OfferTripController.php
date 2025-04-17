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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $seats = $_POST['seats'];
    $price = $_POST['price'];

    $trip = new Trip($departure, $arrival, $date, $time, $seats, $price, $userId);
    Trip::create($pdo, $trip);

    header('Location: index.php?page=dashboard');
    exit();
}

require_once __DIR__ . '/../View/offer_trip.php';
