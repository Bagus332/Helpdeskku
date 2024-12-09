<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

require '../includes/db.php';

// Ambil status laporan dari database
$stmt = $pdo->prepare("SELECT * FROM issues WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$issues = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Status</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>View Issue Status</h2>
    <?php if (count($issues) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Issue ID</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($issues as $issue): ?>
                    <tr>
                        <td><?= htmlspecialchars($issue['id']) ?></td>
                        <td><?= htmlspecialchars($issue['category']) ?></td>
                        <td><?= htmlspecialchars($issue['description']) ?></td>
                        <td><?= htmlspecialchars($issue['priority']) ?></td>
                        <td><?= htmlspecialchars($issue['status']) ?></td>
                        <td><?= htmlspecialchars($issue['updated_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No issues reported yet.</p>
    <?php endif; ?>
</body>
</html>
