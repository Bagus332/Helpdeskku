<?php
session_start();
require 'includes/db.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Retrieve user role
$user_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk System</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        nav {
            margin: 20px 0;
            text-align: center;
        }
        nav a {
            text-decoration: none;
            color: #007BFF;
            margin: 0 10px;
            padding: 8px 15px;
            border: 1px solid #007BFF;
            border-radius: 5px;
        }
        nav a:hover {
            background-color: #007BFF;
            color: white;
        }
        main {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Helpdesk System</h1>
    </header>
    <nav>
        <?php if ($user_role === 'admin'): ?>
            <a href="admin/dashboard.php">Dashboard</a>
            <a href="admin/assign_task.php">Assign Task</a>
            <a href="admin/view_reports.php">Reports</a>
        <?php elseif ($user_role === 'technician'): ?>
            <a href="technician/tasks.php">My Tasks</a>
            <a href="technician/update_status.php">Update Status</a>
        <?php elseif ($user_role === 'user'): ?>
            <a href="user/report_issue.php">Report Issue</a>
            <a href="user/view_status.php">View My Issues</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
    <main>
        <h2>Hello, <?= htmlspecialchars($_SESSION['role']); ?>!</h2>
        <p>Use the navigation links above to access your features.</p>
    </main>
</body>
</html>
