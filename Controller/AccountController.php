<?php
require_once __DIR__ . '/../Model/User.php';
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

// Récupérer les informations de l'utilisateur
$user = User::getUserById($pdo, $userId);

// Inclure la vue pour le compte
require_once __DIR__ . '/../View/account.php';
