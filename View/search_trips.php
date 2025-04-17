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
    <h2>Rechercher un trajet</h2>

    <form action="index.php?page=search_trips" method="POST">
        <div class="form-group">
            <label for="departure">Départ :</label>
            <input type="text" class="form-control" id="departure" name="departure">
        </div>
        <div class="form-group">
            <label for="arrival">Arrivée :</label>
            <input type="text" class="form-control" id="arrival" name="arrival">
        </div>
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <?php if (!empty($trips)): ?>
        <h3 class="mt-5">Résultats de recherche</h3>
        <table class="table table-bordered mt-3">
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
            <?php foreach ($trips as $trip): ?>
                <tr>
                    <td><?= htmlspecialchars($trip['departure']); ?></td>
                    <td><?= htmlspecialchars($trip['arrival']); ?></td>
                    <td><?= htmlspecialchars($trip['date']); ?></td>
                    <td><?= htmlspecialchars($trip['time']); ?></td>
                    <td><?= htmlspecialchars($trip['seats']); ?></td>
                    <td><?= htmlspecialchars($trip['price']); ?></td>
                    <td><a href="index.php?page=trip_details&trip_id=<?= $trip['id']; ?>" class="btn btn-info">Détails</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="alert alert-warning mt-5">Aucun trajet trouvé pour votre recherche.</div>
    <?php endif; ?>
</div>
