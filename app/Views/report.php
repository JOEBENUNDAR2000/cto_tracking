<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">

    <h2 class="mb-4">CTO Earned Hours Report</h2>

    <!-- FILTER CARD -->
    <div class="card mb-4">
        <div class="card-body">

            <form method="get" action="<?= base_url('report'); ?>" id="filterForm">
                <div class="row g-3 align-items-end">

                    <!-- Month -->
                    <div class="col-md-5">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-select">
                            <option value="">All Months</option>
                            <?php
                            $months = [
                                'January','February','March','April','May','June',
                                'July','August','September','October','November','December'
                            ];
                            foreach ($months as $m):
                            ?>
                                <option value="<?= $m; ?>"
                                    <?= ($selectedMonth ?? '') == $m ? 'selected' : ''; ?>>
                                    <?= $m; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Employee -->
                    <div class="col-md-5">
                        <label class="form-label">Employee</label>
                        <select name="employee" class="form-select">
                            <option value="">All Employees</option>
                            <?php foreach ($employees as $emp): ?>
                                <option value="<?= esc($emp['employee_name']); ?>"
                                    <?= ($selectedEmployee ?? '') == $emp['employee_name'] ? 'selected' : ''; ?>>
                                    <?= esc($emp['employee_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- GENERATE PDF BUTTON -->
                    <div class="col-md-2">
                        <a href="<?= base_url('report/pdf?month=' . urlencode($selectedMonth ?? '') . '&employee=' . urlencode($selectedEmployee ?? '')); ?>" 
                           class="btn btn-danger w-100">
                            Generate PDF
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            
                            <th>Month</th>
                            <th>Employee</th>
                            <th>Division</th>
                            <th>Earned</th>
                            <th>Used</th>
                            <th>Remaining COCs</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($applications)): ?>
                          
                            <?php foreach ($applications as $row): ?>
                                <tr>
                                    
                                    <td><?= esc($row['month']); ?></td>
                                    <td><?= esc($row['employee_name']); ?></td>
                                    <td><?= esc($row['division']); ?></td>
                                    <td><?= number_format($row['total_earned_hours'], 2); ?></td>
                                    <td><?= number_format($row['total_used_hours'], 2); ?></td>
                                    <td><?= number_format($row['remaining_coc'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script>
// Auto-submit filter
document.querySelectorAll('#filterForm select').forEach(function(select) {
    select.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
    });
});
</script>

<?= $this->endSection(); ?>