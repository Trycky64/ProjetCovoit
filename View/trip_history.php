<?php require 'header.php'; ?>

<?php
$trips = $_SESSION['trip_history']['trips'] ?? [];
$favoriteDriverIds = $_SESSION['trip_history']['favoriteDriverIds'] ?? [];
$alreadyReviewedDriverIds = $_SESSION['trip_history']['alreadyReviewedDriverIds'] ?? [];
$reviewForm = $_SESSION['review_form'] ?? null;
unset($_SESSION['trip_history'], $_SESSION['review_form']);
?>

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
            <th>Chauffeur</th>
            <th>Favori</th>
            <th>Noter</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($trips as $trip): ?>
            <?php
            $isBeingEdited = $reviewForm && $reviewForm['reviewed_id'] == $trip['driver_id'];
            $selectedRating = $isBeingEdited ? (int)($reviewForm['rating'] ?? 5) : 5;
            $commentText = $isBeingEdited ? htmlspecialchars($reviewForm['comment']) : '';
            ?>
            <tr>
                <td><?= htmlspecialchars($trip['departure']); ?></td>
                <td><?= htmlspecialchars($trip['arrival']); ?></td>
                <td><?= htmlspecialchars($trip['date']); ?></td>
                <td><?= htmlspecialchars($trip['time']); ?></td>
                <td><?= htmlspecialchars($trip['seats_reserved']); ?></td>
                <td><?= htmlspecialchars($trip['driver_email']); ?></td>
                <td>
                    <?php if (!in_array($trip['driver_id'], $favoriteDriverIds)): ?>
                        <a href="index.php?page=add_favorite&driver_id=<?= $trip['driver_id'] ?>" class="btn btn-sm btn-outline-primary">
                            Ajouter aux favoris
                        </a>
                    <?php else: ?>
                        <a href="#" class="btn btn-sm btn-success disabled">
                            <i class="bi bi-check-circle"></i> Déjà en favori
                        </a>
                        <a href="index.php?page=remove_favorite&driver_id=<?= $trip['driver_id'] ?>" class="btn btn-sm btn-outline-danger ms-2">
                            Retirer
                        </a>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!in_array($trip['driver_id'], $alreadyReviewedDriverIds)): ?>
                        <form method="POST" action="index.php?page=review_driver">
                            <div class="d-grid gap-2">
                                <input type="hidden" name="reviewed_id" value="<?= $trip['driver_id'] ?>">
                                <select name="rating" class="form-select form-select-sm">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <option value="<?= $i ?>" <?= $selectedRating == $i ? 'selected' : '' ?>>
                                            <?= $i ?>/5
                                        </option>
                                    <?php endfor; ?>
                                </select>
                                <input type="text" name="comment" class="form-control form-control-sm"
                                       placeholder="Commentaire (optionnel)" value="<?= $commentText ?>">
                                <button type="submit" class="btn btn-sm btn-outline-success">Envoyer</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">Déjà noté</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>
