<?php
include 'koneksi.php';

if(isset($_POST['submit'])){

    mysqli_query($koneksi, "INSERT INTO pengurus VALUES(
        '',
        '$_POST[nama_lengkap]',
        '$_POST[jabatan]',
        '$_POST[bidang]',
        '$_POST[masa_jabatan]',
        ''
    )");

    header("location:pengurus.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pengurus</title>
</head>
<body>

<h2>Tambah Pengurus</h2>

<form method="POST">

Nama Lengkap:
<br>
<input type="text" name="nama_lengkap">
<br><br>

Jabatan:
<br>
<select name="jabatan">
    <option>Penanggung Jawab</option>
    <option>Staff</option>
    <option>Pembina Ekskul</option>
</select>
<br><br>

Bidang:
<br>
<select name="bidang">
    <option>Kepala Sekolah</option>
    <option>Ketua Pembina</option>
    <option>Kedisiplinan Putra</option>
    <option>Kedisiplinan Putri</option>
    <option>Pramuka</option>
    <option>Paskibra</option>
</select>
<br><br>

Masa Jabatan:
<br>
<input type="text" name="masa_jabatan">
<br><br>

<button type="submit" name="submit">
Tambah
</button>

</form>

</body>
</html>