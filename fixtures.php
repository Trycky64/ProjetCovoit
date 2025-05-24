<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/Model/Trip.php';
require_once __DIR__ . '/Model/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = getPDO();

// Réinitialisation
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("DROP TABLE IF EXISTS trip_stops, reviews, notifications, reservations, trips, users");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

// Recréation des tables
$pdo->exec("CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    banned BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    departure VARCHAR(255) NOT NULL,
    arrival VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    estimated_arrival_time TIME NOT NULL,
    seats INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    driver_id INT NOT NULL,
    FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    user_id INT NOT NULL,
    seats_reserved INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reviewer_id INT NOT NULL,
    reviewed_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (reviewer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE trip_stops (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    location VARCHAR(255) NOT NULL,
    stop_time TIME NOT NULL,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
)");

// Création d'utilisateurs
for ($i = 1; $i <= 5; $i++) {
    $email = "testuser{$i}@example.com";
    $password = password_hash("password{$i}", PASSWORD_BCRYPT);
    $role = $i === 1 ? 'admin' : 'user';
    $pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)")
        ->execute([$email, $password, $role]);
}

// Génération de 20 trajets avec étapes variées
$cities = ["Paris", "Lyon", "Bordeaux", "Nantes", "Toulouse", "Strasbourg", "Nice", "Rennes", "Lille", "Grenoble"];
$drivers = ["testuser1@example.com", "testuser2@example.com", "testuser3@example.com", "testuser4@example.com", "testuser5@example.com"];

for ($i = 0; $i < 20; $i++) {
    $departure = $cities[array_rand($cities)];
    do {
        $arrival = $cities[array_rand($cities)];
    } while ($arrival === $departure);

    $date = date('Y-m-d', strtotime('+' . rand(1, 30) . ' days'));
    $hour = rand(6, 15);
    $minute = ['00', '15', '30', '45'][rand(0, 3)];
    $time = sprintf('%02d:%s:00', $hour, $minute);
    $estimated_arrival_time = date('H:i:s', strtotime($time) + rand(3600, 14400));
    $seats = rand(2, 6);
    $price = rand(10, 80);
    $driver_email = $drivers[array_rand($drivers)];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$driver_email]);
    $user = $stmt->fetch();

    $pdo->prepare("INSERT INTO trips (departure, arrival, date, time, estimated_arrival_time, seats, price, driver_id)
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
        ->execute([$departure, $arrival, $date, $time, $estimated_arrival_time, $seats, $price, $user['id']]);

    $tripId = $pdo->lastInsertId();

    // Ajouter entre 0 et 3 étapes
    $numStops = rand(0, 3);
    for ($j = 1; $j <= $numStops; $j++) {
        do {
            $location = $cities[array_rand($cities)];
        } while (in_array($location, [$departure, $arrival]));
        $stop_time = date('H:i:s', strtotime($time) + ($j * 1800)); // toutes les 30 min
        $pdo->prepare("INSERT INTO trip_stops (trip_id, location, stop_time) VALUES (?, ?, ?)")
            ->execute([$tripId, $location, $stop_time]);
    }
}

// Réservations aléatoires
for ($i = 1; $i <= 5; $i++) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(["testuser{$i}@example.com"]);
    $user = $stmt->fetch();

    $trip = $pdo->query("SELECT id FROM trips ORDER BY RAND() LIMIT 1")->fetch();
    $pdo->prepare("INSERT INTO reservations (trip_id, user_id, seats_reserved) VALUES (?, ?, ?)")
        ->execute([$trip['id'], $user['id'], rand(1, 2)]);
}

// Notifications
for ($i = 1; $i <= 5; $i++) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute(["testuser{$i}@example.com"]);
    $user = $stmt->fetch();
    $msg = "Notification test pour {$user['email']}";
    $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)")
        ->execute([$user['id'], $msg]);
}

// Avis
$reviews = [
    ['testuser3@example.com', 'testuser2@example.com', 2, 'Retard et conduite brusque'],
    ['testuser4@example.com', 'testuser2@example.com', 1, 'Peu aimable'],
    ['testuser5@example.com', 'testuser2@example.com', 2, 'Conduite un peu dangereuse'],
    ['testuser2@example.com', 'testuser3@example.com', 5, 'Top !']
];

foreach ($reviews as [$rev, $target, $note, $com]) {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$rev]);
    $reviewer = $stmt->fetch();
    $stmt->execute([$target]);
    $reviewed = $stmt->fetch();
    $pdo->prepare("INSERT INTO reviews (reviewer_id, reviewed_id, rating, comment) VALUES (?, ?, ?, ?)")
        ->execute([$reviewer['id'], $reviewed['id'], $note, $com]);
}

$_SESSION['success'] = "Base de données réinitialisée avec succès.";
header("Location: index.php?page=home");
exit;
