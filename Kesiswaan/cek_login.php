<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM user 
WHERE username='$_POST[username]' 
AND password='$_POST[password]'");

$d = mysqli_fetch_array($data);

if($d){

    $_SESSION['id'] = $d['id'];
    $_SESSION['username'] = $d['username'];

    header("location:index.php");

}else{

    echo "Login gagal!";
}
?>