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
    <h2>Tableau de bord</h2>

    <h3 class="mt-4">Mes trajets créés</h3>
    <?php if (!empty($createdTrips)): ?>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places disponibles</th>
                <th>Prix (€)</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($createdTrips as $trip): ?>
                <tr>
                    <td><?= htmlspecialchars($trip['departure']); ?></td>
                    <td><?= htmlspecialchars($trip['arrival']); ?></td>
                    <td><?= htmlspecialchars($trip['date']); ?></td>
                    <td><?= htmlspecialchars($trip['time']); ?></td>
                    <td><?= htmlspecialchars($trip['seats']); ?></td>
                    <td><?= htmlspecialchars($trip['price']); ?></td>
                    <td>
                        <form action="index.php?page=cancel_trip" method="POST">
                            <input type="hidden" name="trip_id" value="<?= $trip['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Vous n'avez créé aucun trajet.</p>
    <?php endif; ?>

    <h3 class="mt-4">Mes trajets réservés</h3>
    <?php if (!empty($reservedTrips)): ?>
        <table class="table table-striped table-bordered mt-3">
            <thead class="thead-dark">
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Places réservées</th>
                <th>Prix (€)</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservedTrips as $trip): ?>
                <tr>
                    <td><?= htmlspecialchars($trip['departure']); ?></td>
                    <td><?= htmlspecialchars($trip['arrival']); ?></td>
                    <td><?= htmlspecialchars($trip['date']); ?></td>
                    <td><?= htmlspecialchars($trip['time']); ?></td>
                    <td><?= htmlspecialchars($trip['seats_reserved']); ?></td>
                    <td><?= htmlspecialchars($trip['price']); ?></td>
                    <td>
                        <form action="index.php?page=cancel_trip" method="POST">
                            <input type="hidden" name="reservation_id" value="<?= $trip['reservation_id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Annuler</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-muted">Vous n'avez réservé aucun trajet.</p>
    <?php endif; ?>
</div>
