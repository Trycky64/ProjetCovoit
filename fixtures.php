// === fixtures.php ===
<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/Model/Trip.php';
require_once __DIR__ . '/Model/User.php';

$pdo = getPDO();

$pdo->exec("DROP TABLE IF EXISTS notifications;");
$pdo->exec("DROP TABLE IF EXISTS reservations;");
$pdo->exec("DROP TABLE IF EXISTS trips;");
$pdo->exec("DROP TABLE IF EXISTS users;");

$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS trips (
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

$pdo->exec("CREATE TABLE IF NOT EXISTS reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    user_id INT NOT NULL,
    seats_reserved INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

for ($i = 1; $i <= 5; $i++) {
    $email = "testuser{$i}@example.com";
    $password = password_hash("password{$i}", PASSWORD_BCRYPT);
    $role = ($i === 1) ? 'admin' : 'user';
    $stmt = $pdo->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$email, $password, $role]);
}

for ($i = 1; $i <= 5; $i++) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute(["testuser{$i}@example.com"]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $driver_id = $user['id'];
        $departure = "City{$i}";
        $arrival = "Destination{$i}";
        $date = date('Y-m-d', strtotime("+{$i} days"));
        $time = '08:00:00';
        $estimated_arrival_time = date('H:i:s', strtotime($time) + 2 * 3600);
        $seats = rand(1, 5);
        $price = rand(10, 50);

        $stmt = $pdo->prepare('INSERT INTO trips (departure, arrival, date, time, estimated_arrival_time, seats, price, driver_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$departure, $arrival, $date, $time, $estimated_arrival_time, $seats, $price, $driver_id]);
    }
}

for ($i = 1; $i <= 5; $i++) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute(["testuser{$i}@example.com"]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->query('SELECT id FROM trips ORDER BY RAND() LIMIT 1');
    $trip = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $trip) {
        $seats_reserved = rand(1, 3);
        $stmt = $pdo->prepare('INSERT INTO reservations (trip_id, user_id, seats_reserved) VALUES (?, ?, ?)');
        $stmt->execute([$trip['id'], $user['id'], $seats_reserved]);
    }
}

for ($i = 1; $i <= 5; $i++) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $stmt->execute(["testuser{$i}@example.com"]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user_id = $user['id'];
        $message = "Notification de test pour l'utilisateur {$user_id}.";
        $stmt = $pdo->prepare('INSERT INTO notifications (user_id, message) VALUES (?, ?)');
        $stmt->execute([$user_id, $message]);
    }
}

$_SESSION['success'] = "Fixtures terminées avec succès.";
header('Location: index.php');
exit();