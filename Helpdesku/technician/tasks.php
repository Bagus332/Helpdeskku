<?php
session_start();

if ($_SESSION['role'] !== 'technician') {
    header("Location: ../login.php");
    exit;
}

require '../includes/db.php';

// Ambil tugas yang ditugaskan ke teknisi saat ini
$technician_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM issues WHERE technician_id = ? AND status IN ('assigned', 'in_progress')");
$stmt->execute([$technician_id]);
$tasks = $stmt->fetchAll();

// Update status tugas
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issue_id = $_POST['issue_id'];
    $new_status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE issues SET status = ? WHERE id = ?");
    $stmt->execute([$new_status, $issue_id]);

    $message = "Task status updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Tasks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Your Tasks</h2>
    <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Update Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= $task['id'] ?></td>
                    <td><?= $task['description'] ?></td>
                    <td><?= ucfirst($task['priority']) ?></td>
                    <td><?= ucfirst($task['status']) ?></td>
                    <td>
                        <form method="POST" action="">
                            <select name="status" required>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                            </select>
                            <input type="hidden" name="issue_id" value="<?= $task['id'] ?>">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
