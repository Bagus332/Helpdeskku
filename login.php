<?php
session_start();
require 'includes/db.php'; // File koneksi database

// Periksa apakah form dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars(trim($_POST['password']));
    $error = '';

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = 'Username dan Password harus diisi.';
    } else {
        // Ambil data pengguna dari database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && $password == $user['password']) { // Perbandingan langsung tanpa hashing
            // Set sesi dan regen ID sesi
            session_regenerate_id();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            // Redirect berdasarkan peran
            if ($user['role'] === 'admin') {
                header("Location: index.php");
            } elseif ($user['role'] === 'technician') {
                header("Location: index.php");
            } elseif ($user['role'] === 'user') {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = 'Username atau Password salah.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Helpdesk</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
