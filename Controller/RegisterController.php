<?php
require_once __DIR__ . '/../Model/User.php';
require_once __DIR__ . '/../config/Database.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = getPDO();
    $user = new User(null, $email, $password);
    User::createUser($pdo, $user);

    header('Location: index.php?page=login');
    exit();
}

require_once __DIR__ . '/../View/register.php';
