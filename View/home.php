<?php require 'header.php'; ?>

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

<div class="container mt-5">
    <h1>Bienvenue sur l'application de covoiturage</h1>
    <p>Ceci est la page d'accueil de l'application.</p>

    <!-- Bouton Bootstrap vers fixtures.php -->
    <a href="/fixtures.php" class="btn btn-warning mt-4">
        Initialiser la base de données (fixtures)
    </a>

    <!-- Identifiants pour les profs -->
    <div class="mt-5">
        <h3>Identifiants de test (professeurs)</h3>
        <ul class="list-group">
            <li class="list-group-item"><strong>Email :</strong> testuser1@example.com</li>
            <li class="list-group-item"><strong>Mot de passe :</strong> password1</li>
            <li class="list-group-item text-muted"><em>Rôle : admin</em></li>
        </ul>
    </div>
</div>
