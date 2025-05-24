<?php
// footer.php
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

<footer class="footer bg-light text-center text-lg-start mt-5">
    <div class="text-center p-3">
        © 2024 Mon Application - Tous droits réservés.
    </div>
</footer>

<!-- Bootstrap JS (nécessaire pour les alertes dismissibles) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour fermer automatiquement les alertes après 3 secondes -->
<script>
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 3000);
</script>

</body>
</html>
