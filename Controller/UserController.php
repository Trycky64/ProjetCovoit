<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../Model/User.php';

class UserController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function showEditAccountForm()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            require_once __DIR__ . '/../View/edit_account.php';
        } else {
            $_SESSION['error'] = "Utilisateur non trouvé.";
            header('Location: index.php?page=dashboard');
            exit();
        }
    }

    public function showNotifications()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $stmt = $this->pdo->prepare('SELECT message FROM notifications WHERE user_id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $notifications = $stmt->fetchAll(PDO::FETCH_COLUMN);

        require_once __DIR__ . '/../View/notifications.php';
    }

    public function showTripHistory()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login');
            exit();
        }

        $userId = $_SESSION['user_id'];

        // Vérifier si l'utilisateur est banni
        $stmt = $this->pdo->prepare("SELECT banned FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();

        if ($user && $user['banned']) {
            session_destroy();
            header("Location: index.php?page=login");
            exit;
        }

        // Récupérer les trajets + emails de chauffeurs
        $stmt = $this->pdo->prepare('
        SELECT t.departure, t.arrival, r.seats_reserved, t.date, t.time,
               t.driver_id, u.email AS driver_email
        FROM reservations r
        JOIN trips t ON r.trip_id = t.id
        JOIN users u ON t.driver_id = u.id
        WHERE r.user_id = ?
    ');
        $stmt->execute([$userId]);
        $trips = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Récupérer les favoris
        $favoriteDrivers = User::getPreferredDrivers($this->pdo, $userId);
        $favoriteDriverIds = array_column($favoriteDrivers, 'id');

        // Récupérer les chauffeurs déjà notés
        $stmt = $this->pdo->prepare("SELECT reviewed_id FROM reviews WHERE reviewer_id = ?");
        $stmt->execute([$userId]);
        $alreadyReviewedDriverIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'reviewed_id');

        $_SESSION['trip_history'] = [
            'trips' => $trips,
            'favoriteDriverIds' => $favoriteDriverIds,
            'alreadyReviewedDriverIds' => $alreadyReviewedDriverIds
        ];

        require __DIR__ . '/../View/trip_history.php';
    }
    public function adminPanel()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit();
        }

        require_once __DIR__ . '/../View/admin_panel.php';
    }
}
