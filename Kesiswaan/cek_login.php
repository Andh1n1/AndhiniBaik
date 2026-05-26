<?php
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$pass     = $_POST['password'];

// Hash password dulu sebelum dibandingkan (sama seperti saat simpan)
$pass_hash = md5($pass);

// Query benar: pakai username DAN password, pakai prepared statement style (minimal escape)
$username_aman = mysqli_real_escape_string($koneksi, $username);
$data = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username_aman' AND password='$pass_hash'");

$d = mysqli_fetch_array($data);

if ($d) {
    $_SESSION['id']       = $d['id'];
    $_SESSION['username'] = $d['username'];
    $_SESSION['role']     = $d['role'];
    header("location:index.php");
    exit;
} else {
    echo "<script>alert('Username atau password salah!'); window.history.back();</script>";
}
?>