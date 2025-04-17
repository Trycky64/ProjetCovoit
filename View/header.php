<!DOCTYPE html>
<html lang="fr">
<?php if (!empty($_SESSION['error'])): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['success'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application</title>

    <!-- Lien vers le fichier CSS Bootstrap local -->
    <link rel="stylesheet" href="/ProjetCovoit/css/bootstrap.css">

    <!-- Bootstrap JS et dépendances -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary px-4 shadow">
    <a class="navbar-brand" href="index.php">MonCovoit</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item"><a class="nav-link" href="index.php?page=create_trip">Créer un trajet</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=search_trips">Rechercher</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=notifications">Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=trip_history">Historique</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=dashboard">Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=logout">Déconnexion</a></li>
            <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="index.php?page=login">Connexion</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?page=register">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>



