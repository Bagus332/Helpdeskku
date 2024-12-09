<?php
session_start();
if ($_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit;
}

require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category = $_POST['category'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO issues (user_id, category, description, priority) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $category, $description, $priority]);
    $message = "Issue reported successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Issue</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Report an Issue</h2>
    <?php if (!empty($message)) echo "<p style='color:green;'>$message</p>"; ?>
    <form method="POST" action="">
        <select name="category" required>
            <option value="hardware">Hardware</option>
            <option value="software">Software</option>
            <option value="network">Network</option>
        </select>
        <textarea name="description" placeholder="Describe the issue..." required></textarea>
        <select name="priority" required>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
