<!DOCTYPE html>
<html>
<head>
    <title>CTO Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #000; padding:6px; text-align:center; }
        th { background:#f2f2f2; }
    </style>
</head>
<body>

<?php 
    // Get selected year from request OR default to current year
    $year = $_GET['year'] ?? date('Y'); 
?>

<h2>
    CTO Earned Hours Report - Year <?= $year; ?>
</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Month</th>
            <th>Employee</th>
            <th>Division</th>
            <th>Earned</th>
            <th>Used</th>
            <th>Remaining</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($applications)): ?>
            <?php $rank = 1; ?>
            <?php foreach ($applications as $row): ?>
                <tr>
                    <td><?= $rank++; ?></td>
                    <td>
                        <?= $row['month']; ?> <?= $year; ?>
                    </td>
                    <td><?= $row['employee_name']; ?></td>
                    <td><?= $row['division']; ?></td>
                    <td><?= number_format($row['total_earned_hours'], 2); ?></td>
                    <td><?= number_format($row['total_used_hours'], 2); ?></td>
                    <td><?= number_format($row['remaining_coc'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No data available for <?= $year; ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>