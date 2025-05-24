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
    <h2>Détails du trajet</h2>

    <?php if (!empty($trip)): ?>
        <p><strong>Départ :</strong> <?= htmlspecialchars($trip['departure']); ?></p>
        <p><strong>Arrivée :</strong> <?= htmlspecialchars($trip['arrival']); ?></p>
        <p><strong>Date :</strong> <?= htmlspecialchars($trip['date']); ?></p>
        <p><strong>Heure :</strong> <?= htmlspecialchars($trip['time']); ?></p>
        <p><strong>Places disponibles :</strong> <?= htmlspecialchars($trip['seats']); ?></p>
        <p><strong>Prix :</strong> <?= htmlspecialchars($trip['price']); ?> €</p>

        <?php if (!empty($tripStops)): ?>
            <hr>
            <h5>Étapes intermédiaires :</h5>
            <ul class="list-group mb-3">
                <?php foreach ($tripStops as $stop): ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span><?= htmlspecialchars($stop['location']); ?></span>
                        <span class="text-muted"><?= htmlspecialchars($stop['stop_time']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="index.php?page=reserve_trip" method="POST">
            <input type="hidden" name="trip_id" value="<?= htmlspecialchars($trip['id']); ?>">
            <div class="form-group">
                <label for="seats">Nombre de places à réserver :</label>
                <input type="number" class="form-control" id="seats" name="seats" required>
            </div>
            <button type="submit" class="btn btn-primary">Réserver</button>
        </form>
    <?php else: ?>
        <p>Ce trajet n'existe pas.</p>
    <?php endif; ?>
</div>
