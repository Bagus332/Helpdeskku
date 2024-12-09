<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../includes/db.php';

// Fetch statistics
$total_issues = $pdo->query("SELECT COUNT(*) FROM issues")->fetchColumn();
$open_issues = $pdo->query("SELECT COUNT(*) FROM issues WHERE status != 'closed'")->fetchColumn();
$resolved_issues = $pdo->query("SELECT COUNT(*) FROM issues WHERE status = 'resolved'")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Welcome, Admin</h1>
    <div class="stats">
        <p>Total Issues: <?= $total_issues ?></p>
        <p>Open Issues: <?= $open_issues ?></p>
        <p>Resolved Issues: <?= $resolved_issues ?></p>
    </div>
    <div class="dashboard-links"> <a href="assign_task.php">Assign Task</a> <a href="view_reports.php">View Reports</a> </div>
</body>
</html>
