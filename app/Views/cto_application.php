<?= $this->extend('layout/main'); ?>
<?= $this->section('content'); ?>

<style>
/* Responsive column fix (992px–1200px) */
@media (min-width: 992px) and (max-width: 1200px) {
    .col-lg-custom-3 {
        flex: 0 0 33.333%;
        max-width: 33.333%;
    }
}

/* Full-width button on small screens */
@media (max-width: 576px) {
    .btn-submit-full {
        width: 100%;
    }
}

/* Card spacing */
.card-body {
    padding: clamp(1.2rem, 2vw, 3rem);
}

/* Section title */
.section-title h6 {
    font-weight: 600;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}
</style>

<div class="container-fluid py-4 px-lg-5 px-3">

    <!-- Success Message -->
    <?php if ($success = session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            <?= esc($success); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow border-0 rounded-4">
        <div class="card-body">

            <!-- Header -->
            <div class="mb-4">
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-file-earmark-text text-primary me-2"></i>
                    CTO Application
                </h3>
                <small class="text-muted">Compensatory Time-Off Form</small>
            </div>

            <form action="<?= base_url('save-cto'); ?>" method="post">

                <!-- ================= EMPLOYEE INFO ================= -->
                <div class="section-title mt-4">
                    <h6><i class="bi bi-person-circle me-2"></i>Employee Information</h6>
                </div>
                <hr>

                <?php
                $months = [
                    'January','February','March','April','May','June',
                    'July','August','September','October','November','December'
                ];
                ?>

                <div class="row g-4">

                    <div class="col-12 col-md-6 col-lg-3 col-lg-custom-3">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-select" required>
                            <option value="">Select Month</option>
                            <?php foreach ($months as $month): ?>
                                <option value="<?= esc($month); ?>">
                                    <?= esc($month); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-lg-custom-3">
                        <label class="form-label">Employee Name</label>
                        <input type="text" name="employee_name" class="form-control" required>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-lg-custom-3">
                        <label class="form-label">Division</label>
                        <input type="text" name="division" class="form-control" required>
                    </div>

                    <div class="col-12 col-md-6 col-lg-3 col-lg-custom-3">
                        <label class="form-label">Employment Type</label>
                        <select name="employment_type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="Regular">Regular</option>
                            <option value="Contractual">Contractual</option>
                        </select>
                    </div>

                </div>

                <!-- ================= CTO DETAILS ================= -->
                <div class="section-title mt-5">
                    <h6><i class="bi bi-calendar-check me-2"></i>CTO Details</h6>
                </div>
                <hr>

                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label class="form-label">Date of Filing</label>
                        <input type="date" name="date_filing" class="form-control" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Inclusive Date</label>
                        <input type="date" name="inclusive_date" class="form-control" required>
                    </div>
                </div>

                <!-- ================= COC HOURS ================= -->
                <div class="section-title mt-5">
                    <h6><i class="bi bi-clock-history me-2"></i>COC Hours</h6>
                </div>
                <hr>

                <div class="row g-4">

                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label">Total Earned Hours</label>
                        <input type="number"
                               step="0.01"
                               min="0"
                               name="total_earned_hours"
                               id="earned"
                               class="form-control text-center"
                               value="0.00">
                    </div>

                    <div class="col-12 col-md-6 col-lg-4">
                        <label class="form-label">Used COCs</label>
                        <input type="number"
                               step="0.01"
                               min="0"
                               name="total_used_hours"
                               id="used"
                               class="form-control text-center"
                               value="0.00">
                    </div>

                    <div class="col-12 col-md-12 col-lg-4">
                        <label class="form-label">Remaining Balance</label>
                        <input type="text"
                               name="remaining_balance"
                               id="remaining"
                               class="form-control fw-bold text-primary text-center"
                               value="0.00"
                               readonly>
                    </div>

                </div>

                <!-- ================= REMARKS ================= -->
                <div class="section-title mt-5">
                    <h6><i class="bi bi-chat-left-text me-2"></i>Remarks</h6>
                </div>
                <hr>

                <div class="mb-4">
                    <textarea name="remarks"
                              class="form-control"
                              rows="3"
                              placeholder="Division and Special Order/Request..."></textarea>
                </div>

                <!-- ================= SUBMIT ================= -->
                <div class="text-end mt-4">
                    <button type="submit"
                            class="btn btn-primary px-5 py-2 rounded-pill shadow-sm btn-submit-full">
                        <i class="bi bi-check-circle me-2"></i>
                        Submit Application
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const earnedInput = document.getElementById('earned');
    const usedInput = document.getElementById('used');
    const remainingInput = document.getElementById('remaining');

    function calculate() {
        const earned = parseFloat(earnedInput.value) || 0;
        const used = parseFloat(usedInput.value) || 0;

        const remaining = Math.max(earned - used, 0);
        remainingInput.value = remaining.toFixed(2);
    }

    earnedInput.addEventListener('input', calculate);
    usedInput.addEventListener('input', calculate);
});
</script>

<?= $this->endSection(); ?>