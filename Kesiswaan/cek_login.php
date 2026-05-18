<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';
$username = $_POST['username'];
$pass = $_POST['password'];


$data = mysqli_query($koneksi, " SELECT * FROM users WHERE  password=$pass");

$d = mysqli_fetch_array($data);

if($d){

    $_SESSION['id'] = $d['id'];
    $_SESSION['username'] = $d['username'];
    $_SESSION['role'] = $d['role'];
    header("location:index.php");

}else{

    echo "Login gagal!";
}
?>