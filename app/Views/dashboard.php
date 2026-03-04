<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

/* ================= DASHBOARD CARDS ================= */

.dashboard-card {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 22px 24px;
    border-radius: 16px;
    color: #fff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-4px);
}

.icon-box {
    width: 56px;
    height: 56px;
    background: rgba(255,255,255,0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.card-label {
    font-size: 14px;
    opacity: 0.9;
}

.card-value {
    font-size: 26px;
    font-weight: 700;
}

/* Gradients */
.bg-warning-gradient { background: linear-gradient(135deg,#f7971e,#ffd200); }
.bg-success-gradient { background: linear-gradient(135deg,#11998e,#38ef7d); }
.bg-primary-gradient { background: linear-gradient(135deg,#396afc,#2948ff); }
.bg-dark-gradient { background: linear-gradient(135deg,#232526,#414345); }

/* Chart fixed height */
#barChart,
#pieChart {
    height: 350px !important;
}

</style>

<div class="container-fluid dashboard-wrapper">

    <!-- HEADER -->
    <div class="mb-4">
        <h3 class="fw-bold">
            <i class="fas fa-chart-line me-2 text-primary"></i>
            Dashboard Overview (<?= date('Y') ?>)
        </h3>
        <small class="text-muted">System Analytics & CTO Summary</small>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card bg-warning-gradient">
                <div class="icon-box"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="card-label">Total Earned Hours</div>
                    <div class="card-value"><?= number_format($totalEarned ?? 0, 2) ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card bg-success-gradient">
                <div class="icon-box"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="card-label">Total Used Hours</div>
                    <div class="card-value"><?= number_format($totalUsed ?? 0, 2) ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card bg-primary-gradient">
                <div class="icon-box"><i class="fas fa-hourglass-half"></i></div>
                <div>
                    <div class="card-label">Remaining COCs</div>
                    <div class="card-value"><?= number_format($totalRemaining ?? 0, 2) ?></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card bg-dark-gradient">
                <div class="icon-box"><i class="fas fa-users"></i></div>
                <div>
                    <div class="card-label">Total Application</div>
                    <div class="card-value"><?= $totalEmployees ?? 0 ?></div>
                </div>
            </div>
        </div>

    </div>

    <div class="row g-4">

        <!-- BAR CHART -->
        <div class="col-lg-8">
            <div class="card shadow border-0 p-4 rounded-4">
                <h6 class="fw-semibold mb-3">
                    <i class="fas fa-chart-bar text-success me-2"></i>
                    Monthly Earned vs Used Hours
                </h6>

                <canvas id="barChart"></canvas>

                <?php
                $regularCount = 0;
                $contractualCount = 0;

                if (!empty($employment)) {
                    foreach ($employment as $emp) {
                        if ($emp['employment_type'] === 'Regular') {
                            $regularCount = $emp['total'];
                        }
                        if ($emp['employment_type'] === 'Contractual') {
                            $contractualCount = $emp['total'];
                        }
                    }
                }
                ?>

                <div class="row mt-4 g-3">
                    <div class="col-md-6">
                        <div class="card border-success shadow-sm text-center p-3 rounded-4">
                            <h6 class="text-success"><i class="fas fa-user-check me-1"></i>Regular</h6>
                            <h3 class="fw-bold text-success"><?= $regularCount ?></h3>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-warning shadow-sm text-center p-3 rounded-4">
                            <h6 class="text-warning"><i class="fas fa-user-clock me-1"></i>Contractual</h6>
                            <h3 class="fw-bold text-warning"><?= $contractualCount ?></h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- PIE CHART -->
        <div class="col-lg-4">
            <div class="card shadow border-0 p-4 rounded-4">
                <h6 class="fw-semibold mb-3">
                    <i class="fas fa-chart-pie text-primary me-2"></i>
                    Usage Overview
                </h6>
                <canvas id="pieChart"></canvas>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const monthlyData = <?= json_encode($monthly ?? []) ?>;

    const labels = monthlyData.map(item => item.month);
    const earned = monthlyData.map(item => parseFloat(item.earned));
    const used   = monthlyData.map(item => parseFloat(item.used));

    // BAR CHART (Legend Removed)
    const barChart = new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Earned',
                    data: earned,
                    backgroundColor: '#198754',
                    borderRadius: 6
                },
                {
                    label: 'Used',
                    data: used,
                    backgroundColor: '#ffc107',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false } 
            },
            scales: { 
                y: { beginAtZero: true } 
            }
        }
    });

    // PIE CHART (Legend Kept)
    const pieChart = new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Used', 'Remaining'],
            datasets: [{
                data: [
                    <?= (float)($totalUsed ?? 0) ?>,
                    <?= (float)($totalRemaining ?? 0) ?>
                ],
                backgroundColor: ['#ffc107', '#396afc'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { 
                legend: { position: 'bottom' } 
            }
        }
    });

    window.addEventListener('resize', function () {
        barChart.resize();
        pieChart.resize();
    });

});
</script>

<?= $this->endSection() ?>