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
    <h2>Proposer un trajet</h2>

    <form action="index.php?page=offer_trip" method="POST">
        <div class="form-group">
            <label for="departure">Départ :</label>
            <input type="text" class="form-control" id="departure" name="departure" required>
        </div>
        <div class="form-group">
            <label for="arrival">Arrivée :</label>
            <input type="text" class="form-control" id="arrival" name="arrival" required>
        </div>
        <div class="form-group">
            <label for="date">Date :</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <div class="form-group">
            <label for="time">Heure :</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="seats">Nombre de places :</label>
            <input type="number" class="form-control" id="seats" name="seats" required>
        </div>
        <div class="form-group">
            <label for="price">Prix (€) :</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>
        <button type="submit" class="btn btn-primary">Proposer</button>
    </form>
</div>
