<?php
include 'koneksi.php';

if(isset($_POST['register'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    mysqli_query($koneksi, "INSERT INTO user VALUES(
        '',
        '$username',
        '$password',
        'user'
    )");

    header("location:login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Daftar Akun</h2>

<form method="POST">

Username:
<br>
<input type="text" name="username">
<br><br>

Password:
<br>
<input type="password" name="password">
<br><br>

<button type="submit" name="register">
Daftar
</button>

</form>

<br>

Sudah punya akun?
<a href="login.php">Login</a>

</body>
</html>