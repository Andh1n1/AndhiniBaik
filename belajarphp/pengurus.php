<?php
// PENGAMAN SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Proteksi Halaman: Jika belum login, tendang ke login.php
if(!isset($_SESSION['id'])){
    header("location:login.php");
    exit;
}

// AMBIL DATA ROLE DAN ID DARI SESSION LOGIN
$user_id = $_SESSION['id'];
$role    = $_SESSION['role']; // Pastikan saat login, $_SESSION['role'] sudah diisi 'admin' atau 'guru'

// LOGIKA PEMBATASAN DATA (KUNCI UTAMA)
if ($role == 'admin') {
    // Jika dia Admin, tampilkan SEMUA data pengurus
    $data = mysqli_query($koneksi, "SELECT * FROM pengurus");
} else {
    // Jika dia Guru/User biasa, HANYA tampilkan data yang user_id nya cocok dengan ID loginnya
    $data = mysqli_query($koneksi, "SELECT * FROM pengurus WHERE user_id = '$user_id'");
}
?>