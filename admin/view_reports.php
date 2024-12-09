<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../includes/db.php';

// Ambil data statistik
$total_issues = $pdo->query("SELECT COUNT(*) FROM issues")->fetchColumn();
$open_issues = $pdo->query("SELECT COUNT(*) FROM issues WHERE status IN ('submitted', 'assigned', 'in_progress')")->fetchColumn();
$resolved_issues = $pdo->query("SELECT COUNT(*) FROM issues WHERE status = 'resolved'")->fetchColumn();
$closed_issues = $pdo->query("SELECT COUNT(*) FROM issues WHERE status = 'closed'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Reports</h2>
    <canvas id="issuesChart" width="400" height="200"></canvas>
    <script>
        const ctx = document.getElementById('issuesChart').getContext('2d');
        const issuesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total', 'Open', 'Resolved', 'Closed'],
                datasets: [{
                    label: 'Number of Issues',
                    data: [<?= $total_issues ?>, <?= $open_issues ?>, <?= $resolved_issues ?>, <?= $closed_issues ?>],
                    backgroundColor: ['#f39c12', '#3498db', '#2ecc71', '#e74c3c']
                }]
            }
        });
    </script>
</body>
</html>
