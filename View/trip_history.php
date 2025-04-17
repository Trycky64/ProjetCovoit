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
    <h2>Historique des Trajets</h2>
    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Places réservées</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($trips as $trip): ?>
            <tr>
                <td><?= htmlspecialchars($trip['departure']); ?></td>
                <td><?= htmlspecialchars($trip['arrival']); ?></td>
                <td><?= htmlspecialchars($trip['date']); ?></td>
                <td><?= htmlspecialchars($trip['time']); ?></td>
                <td><?= htmlspecialchars($trip['seats_reserved']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>
