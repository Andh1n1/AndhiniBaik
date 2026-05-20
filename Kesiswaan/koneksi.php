<?php
// PENGAMAN: Hanya jalankan session jika memang belum dimulai sebelumnya
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host     = "localhost";
$username = "2526_22"; // Sesuaikan jika Anda memiliki username db yang berbeda
$password = "12345678";     // Kosongkan jika menggunakan XAMPP default
$database = "2526_22db";

// Membuat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengecek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>