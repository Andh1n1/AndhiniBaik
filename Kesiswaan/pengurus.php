<?php
session_start();
include 'koneksi.php';

$data = mysqli_query($koneksi, "SELECT * FROM pengurus");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengurus</title>
</head>
<body>

<h2>Data Pengurus Kesiswaan</h2>

<a href="tambah.php">Tambah Data</a>
<br><br>

<table border="1" cellpadding="10">

<tr>
    <th>No</th>
    <th>Nama Lengkap</th>
    <th>Jabatan</th>
    <th>Bidang</th>
    <th>Masa Jabatan</th>
</tr>

<?php
$no = 1;
while($d = mysqli_fetch_array($data)){
?>

<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $d['nama_lengkap']; ?></td>
    <td><?php echo $d['jabatan']; ?></td>
    <td><?php echo $d['bidang']; ?></td>
    <td><?php echo $d['masa_jabatan']; ?></td>
</tr>

<?php } ?>

</table>

</body>
</html>