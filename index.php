<?php
require_once __DIR__ . '/config/Database.php';

// Démarrer la session
session_start();

// Récupérer la page à afficher, par défaut "home"
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Routeur pour charger les pages en fonction de la valeur de "page"
switch ($page) {
    case 'home':
        require_once __DIR__ . '/Controller/HomeController.php';
        break;

    case 'login':
        require_once __DIR__ . '/Controller/LoginController.php';
        break;

    case 'logout':
        require_once __DIR__ . '/logout.php';
        break;

    case 'register':
        require_once __DIR__ . '/Controller/RegisterController.php';
        break;

    case 'dashboard':
        require_once __DIR__ . '/Controller/DashboardController.php';
        break;

    case 'account':
        require_once __DIR__ . '/Controller/AccountController.php';
        break;

    case 'edit_account':
        require_once __DIR__ . '/Controller/EditAccountController.php';
        break;

    case 'create_trip':
        require_once __DIR__ . '/Controller/CreateTripController.php';
        break;

    case 'offer_trip':
        require_once __DIR__ . '/Controller/OfferTripController.php';
        break;

    case 'cancel_trip':
        require_once __DIR__ . '/Controller/CancelTripController.php';
        break;

    case 'reserve_trip':
        require_once __DIR__ . '/Controller/ReserveTripController.php';
        break;

    case 'search_trips':
        require_once __DIR__ . '/Controller/SearchTripsController.php';
        break;

    case 'trip_details':
        require_once __DIR__ . '/Controller/TripDetailsController.php';
        break;

    case 'notifications':
        require_once __DIR__ . '/Controller/UserController.php';
        (new UserController())->showNotifications();
        break;

    case 'trip_history':
        require_once __DIR__ . '/Controller/UserController.php';
        (new UserController())->showTripHistory();
        break;

    case 'admin':
        require_once __DIR__ . '/Controller/UserController.php';
        (new UserController())->adminPanel();
        break;

    case 'add_favorite':
        require_once __DIR__ . '/Controller/AddFavoriteController.php';
        break;

    case 'remove_favorite':
        require_once __DIR__ . '/Controller/RemoveFavoriteController.php';
        break;

    case 'review_driver':
        require_once __DIR__ . '/Controller/ReviewController.php';
        break;

    case 'fixtures':
        require_once __DIR__ . '/fixtures.php';
        break;

    default:
        require_once __DIR__ . '/Controller/HomeController.php';
        break;
}
