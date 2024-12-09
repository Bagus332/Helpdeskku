<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

require '../includes/db.php';

// Ambil daftar masalah yang belum ditugaskan
$stmt = $pdo->query("SELECT issues.id, issues.description, issues.priority, users.username AS reporter 
                     FROM issues 
                     JOIN users ON issues.user_id = users.id 
                     WHERE issues.status = 'submitted'");
$issues = $stmt->fetchAll();

// Ambil daftar teknisi
$stmt = $pdo->query("SELECT id, username FROM users WHERE role = 'technician'");
$technicians = $stmt->fetchAll();

// Jika admin menetapkan teknisi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issue_id = $_POST['issue_id'];
    $technician_id = $_POST['technician_id'];

    $stmt = $pdo->prepare("UPDATE issues SET technician_id = ?, status = 'assigned' WHERE id = ?");
    $stmt->execute([$technician_id, $issue_id]);

    $message = "Task has been assigned successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Task</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Assign Tasks</h2>
    <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Reporter</th>
                <th>Assign Technician</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($issues as $issue): ?>
                <tr>
                    <td><?= $issue['id'] ?></td>
                    <td><?= $issue['description'] ?></td>
                    <td><?= ucfirst($issue['priority']) ?></td>
                    <td><?= $issue['reporter'] ?></td>
                    <td>
                        <form method="POST" action="">
                            <select name="technician_id" required>
                                <option value="" disabled selected>Select Technician</option>
                                <?php foreach ($technicians as $tech): ?>
                                    <option value="<?= $tech['id'] ?>"><?= $tech['username'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="hidden" name="issue_id" value="<?= $issue['id'] ?>">
                            <button type="submit">Assign</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
