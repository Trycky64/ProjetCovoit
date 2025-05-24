<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../Model/User.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pdo = getPDO();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = User::authenticate($pdo, $email, $password);

    if ($user) {
        if ($user['banned']) {
            $_SESSION['error'] = "Votre compte a été banni.";
            header("Location: index.php?page=login");
            exit;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['success'] = "Connexion réussie.";
        header("Location: index.php?page=dashboard");
        exit;
    } else {
        $_SESSION['error'] = "Identifiants incorrects.";
        header("Location: index.php?page=login");
        exit;
    }
}

require_once __DIR__ . '/../View/login.php';
