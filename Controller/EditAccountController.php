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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User($userId, $email, $password);
    User::updateUser($pdo, $user);

    header('Location: index.php?page=account');
    exit();
}

require_once __DIR__ . '/../View/edit_account.php';
