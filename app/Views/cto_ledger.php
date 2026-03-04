<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">

    <!-- HEADER SECTION -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <div class="row align-items-center">

                <!-- LEFT: TITLE -->
                <div class="col-md-6">
                    <h4 class="fw-bold mb-1 text-primary">
                        <i class="bi bi-journal-text me-2"></i>
                        Compensatory Overtime Credits
                    </h4>
                    <small class="text-muted">
                        Employee Compensatory Time Off Records
                    </small>
                </div>

                <!-- RIGHT: SEARCH -->
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <input type="text"
                           id="searchInput"
                           class="form-control form-control-sm rounded-pill px-3 d-inline-block"
                           style="max-width: 300px;"
                           placeholder="Search employee...">
                </div>

            </div>
        </div>
    </div>

    <!-- LEDGER TABLE CARD -->
    <div class="card border-0 shadow rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="ledgerTable"
                       class="table table-hover align-middle text-center mb-0 modern-ledger w-100">

                    <thead>
                        <tr>
                            <th rowspan="2">Month/s</th>
                            <th rowspan="2">Employee</th>
                            <th rowspan="2">
                                Earned Hours<br>
                                <small class="text-muted">(Current Year)</small>
                            </th>
                            <th rowspan="2">Inclusive Date</th>
                            <th colspan="2">COC Usage</th>
                            <th rowspan="2">Remarks</th>
                        </tr>
                        <tr>
                            <th>Used</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php if(!empty($applications)): ?>
                        <?php foreach($applications as $row): ?>
                            <tr>
                                <td><?= esc($row['month']); ?></td>
                                <td class="fw-semibold text-start">
                                    <?= esc($row['employee_name']); ?>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        <?= number_format($row['total_earned_hours'], 2); ?>
                                    </span>
                                </td>
                                <td><?= esc($row['inclusive_date']); ?></td>
                                <td>
                                    <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                        <?= number_format($row['total_used_hours'], 2); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary px-3 py-2">
                                        <?= number_format($row['remaining_coc'], 2); ?>
                                    </span>
                                </td>
                                <td class="text-start">
                                    <?= esc($row['remarks']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-5 text-muted">
                                No records found.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {

    var table = $('#ledgerTable').DataTable({
        pageLength: 10,
        ordering: true,
        responsive: true,
        lengthChange: false,
        searching: true,
        info: false,
        dom: 'rtp',
        autoWidth: false
    });

    // Custom search
    $('#searchInput').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Fix on window resize
    $(window).on('resize', function () {
        table.columns.adjust().responsive.recalc();
    });

    // Fix when sidebar/menu toggles (works for most templates)
    $(document).on('click', '.sidebar-toggle, #sidebarToggle, #menu-toggle, .navbar-toggler', function () {
        setTimeout(function () {
            table.columns.adjust().responsive.recalc();
        }, 350);
    });

    // Strong fallback (detect layout class changes)
    const observer = new MutationObserver(function () {
        setTimeout(function () {
            table.columns.adjust().responsive.recalc();
        }, 300);
    });

    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });

});
</script>

<style>
.modern-ledger thead {
    background: linear-gradient(90deg, #f8f9fa, #eef2f7);
    font-size: 14px;
}

.modern-ledger th {
    vertical-align: middle;
}

.modern-ledger tbody tr:hover {
    background-color: #f9fbfd;
}

.dataTables_paginate .pagination {
    padding: 12px;
}

.page-link {
    border-radius: 8px !important;
    margin: 0 3px;
}

.page-item.active .page-link {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

@media print {
    #searchInput,
    .dataTables_paginate,
    .dataTables_info {
        display: none !important;
    }
}
</style>

<?= $this->endSection(); ?>