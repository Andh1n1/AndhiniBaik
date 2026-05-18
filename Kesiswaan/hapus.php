<?php
include 'koneksi.php';

// Kunci Pintu: Hanya Admin
if ($_SESSION['role'] != 'admin') die("Akses Ditolak!");

$id_target = $_GET['id'];

// Hapus biodatanya dulu
mysqli_query($koneksi, "DELETE FROM pengurus WHERE user_id = '$id_target'");

// Baru hapus akun loginnya
mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id_target'");

header("location:pengurus.php");
?>