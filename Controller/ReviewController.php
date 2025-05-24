<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../Model/Review.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_POST['reviewed_id']) || !isset($_POST['rating'])) {
    $_SESSION['error'] = "Données de notation incomplètes.";
    header("Location: index.php?page=trip_history");
    exit;
}

$pdo = getPDO();

$reviewerId = $_SESSION['user_id'];
$reviewedId = (int) $_POST['reviewed_id'];
$rating = (int) $_POST['rating'];
$comment = $_POST['comment'] ?? '';

if ($reviewerId === $reviewedId || $rating < 1 || $rating > 5) {
    $_SESSION['review_form'] = [
        'reviewed_id' => $reviewedId,
        'rating' => $rating,
        'comment' => $comment
    ];
    $_SESSION['error'] = "Notation invalide.";
    header("Location: index.php?page=trip_history");
    exit;
}

// Créer l'avis
Review::create($pdo, $reviewerId, $reviewedId, $rating, $comment);

// Mettre à jour les bannissements
Review::autoBanUsers($pdo);

// Nettoyage
unset($_SESSION['review_form']);
$_SESSION['success'] = "Avis enregistré.";
header("Location: index.php?page=trip_history");
exit;
