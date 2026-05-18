<?php
include 'koneksi.php';

if(isset($_POST['submit'])){

    mysqli_query($koneksi, "INSERT INTO pengurus VALUES(
        '1',
        '',
        '$_POST[nama_lengkap]',
        '$_POST[NIP]',
        '$_POST[jabatan]',
        '$_POST[bidang]',
        '$_POST[masa_jabatan]'
        
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

NIP:
<br>
<input type="text" name="NIP">
<br><br>

Jabatan:
<br>
<select name="jabatan">
    <option>Penanggung Jawab</option>
    <option>Ketua Pembina</option>
    <option>Staff</option>
    <option>Pembina Ekskul</option>
</select>
<br><br>

Bidang:
<br>
<select name="bidang">
    <option>Kesiswaan</option>
    <option>Kedisiplinan Putra</option>
    <option>Kedisiplinan Putri</option>
    <option>OSIS</option>
    <option>Paskibra</option>
    <option>Pramuka</option>
    <option>Kerohanian</option>
    <option>Pecinta Alam</option>
    <option>PMR</option>
    <option>Kesenian</option>
    <option>Bahasa</option>
    <option>Olahraga</option>
    <option>KKR</option>
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