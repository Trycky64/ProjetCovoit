<?php
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];
    $date = $_POST['date'];

    $trips = Trip::searchTrips($pdo, $departure, $arrival, $date);
}

require_once __DIR__ . '/../View/search_trips.php';
