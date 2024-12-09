<?php
// Konfigurasi database
$host = 'localhost';       // Host database (umumnya 'localhost')
$dbname = 'helpdesk';      // Nama database
$username = 'root';        // Username database
$password = '';            // Password database

try {
    // Membuat koneksi menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Mengatur mode error PDO untuk menangani kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Menampilkan pesan kesalahan jika koneksi gagal
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>
