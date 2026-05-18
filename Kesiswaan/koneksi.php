<?php
session_start(); // INI HARUS ADA DI SINI
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