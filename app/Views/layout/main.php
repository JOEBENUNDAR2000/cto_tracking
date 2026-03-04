<?= view('layout/navbar') ?>
<?= view('layout/sidebar') ?>

<main class="app-main">
    <div class="app-content p-3">
        <?= $this->renderSection('content') ?>
    </div>
</main>

<!-- AdminLTE JS -->
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>

<!-- Bootstrap Bundle (Required for Dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<?= $this->renderSection('scripts') ?>

</div>
</body>
</html>