<?php
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../config/Database.php';

// Vérifier si une session est déjà active avant de démarrer une nouvelle session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = getPDO();
    $user = User::authenticate($pdo, $email, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: index.php?page=dashboard');
        exit();
    } else {
        $error = "Identifiants incorrects.";
    }
}

require_once __DIR__ . '/../View/login.php';
