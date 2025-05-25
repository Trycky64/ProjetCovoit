<?php
require_once __DIR__ . '/../Model/Trip.php';
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$pdo = getPDO();

$trips = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];
    $date = $_POST['date'];
    $driverName = $_POST['driver_name'];
    $onlyPreferred = isset($_POST['only_preferred']) && $_POST['only_preferred'] == 1;

    $query = "SELECT t.*, u.email AS driver_name 
              FROM trips t 
              JOIN users u ON t.driver_id = u.id 
              WHERE 1";
    $params = [];

    if (!empty($departure)) {
        $query .= " AND t.departure LIKE ?";
        $params[] = "%$departure%";
    }

    if (!empty($arrival)) {
        $query .= " AND t.arrival LIKE ?";
        $params[] = "%$arrival%";
    }

    if (!empty($date)) {
        $query .= " AND t.date = ?";
        $params[] = $date;
    }

    if (!empty($driverName)) {
        $query .= " AND u.email LIKE ?";
        $params[] = "%$driverName%";
    }

    if ($onlyPreferred && isset($_SESSION['user'])) {
        $preferredDrivers = User::getPreferredDrivers($pdo, $_SESSION['user']['id']);
        $driverIds = array_column($preferredDrivers, 'id');

        if (!empty($driverIds)) {
            $inClause = implode(',', array_fill(0, count($driverIds), '?'));
            $query .= " AND t.driver_id IN ($inClause)";
            $params = array_merge($params, $driverIds);
        } else {
            $query .= " AND 0";
        }
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require_once __DIR__ . '/../View/search_trips.php';
