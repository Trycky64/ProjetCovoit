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

<div class="container">
    <h2>Annuler un voyage</h2>

    <?php if (!empty($trip)): ?>
        <p>Voulez-vous vraiment annuler le voyage de <strong><?= htmlspecialchars($trip['departure']); ?></strong> à <strong><?= htmlspecialchars($trip['arrival']); ?></strong> prévu le <strong><?= htmlspecialchars($trip['date']); ?></strong> à <strong><?= htmlspecialchars($trip['time']); ?></strong> ?</p>

        <form action="index.php?page=cancel_trip" method="POST">
            <input type="hidden" name="trip_id" value="<?= htmlspecialchars($trip['id']); ?>">
            <button type="submit" class="btn btn-danger">Annuler</button>
            <a href="index.php?page=dashboard" class="btn btn-secondary">Retour</a>
        </form>
    <?php else: ?>
        <p>Aucun voyage trouvé pour l'annulation.</p>
    <?php endif; ?>
</div>
