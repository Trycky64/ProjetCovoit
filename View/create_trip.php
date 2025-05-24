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
    <h2>Créer un voyage</h2>

    <form action="index.php?page=create_trip" method="POST">
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
            <label for="time">Heure de départ :</label>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>
        <div class="form-group">
            <label for="estimated_arrival_time">Heure d'arrivée estimée :</label>
            <input type="time" class="form-control" id="estimated_arrival_time" name="estimated_arrival_time" required>
        </div>
        <div class="form-group">
            <label for="seats">Nombre de places :</label>
            <input type="number" class="form-control" id="seats" name="seats" required>
        </div>
        <div class="form-group">
            <label for="price">Prix (€) :</label>
            <input type="number" class="form-control" id="price" name="price" required>
        </div>

        <hr>
        <div class="form-group">
            <label>Lieux intermédiaires :</label>
            <div id="stops-container">
                <div class="d-flex mb-2 gap-2 stop-row">
                    <input type="text" name="stops[]" class="form-control" placeholder="Lieu (ex : Bordeaux)">
                    <input type="time" name="stop_times[]" class="form-control" placeholder="Heure de passage">
                </div>
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addStop()">+ Ajouter un arrêt</button>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Créer</button>
    </form>
</div>

<script>
    function addStop() {
        const container = document.getElementById('stops-container');
        const div = document.createElement('div');
        div.className = 'd-flex mb-2 gap-2 stop-row';
        div.innerHTML = `
        <input type="text" name="stops[]" class="form-control" placeholder="Lieu (ex : Lyon)">
        <input type="time" name="stop_times[]" class="form-control" placeholder="Heure de passage">
    `;
        container.appendChild(div);
    }
</script>
