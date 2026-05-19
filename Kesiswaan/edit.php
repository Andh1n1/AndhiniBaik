<?php
// Pastikan session_start() sudah aktif di koneksi.php atau tambahkan di sini jika belum
include 'koneksi.php';

$target_id = $_GET['id'];

// Kunci Pintu: Jika dia Guru, pastikan dia hanya buka ID miliknya sendiri
if (isset($_SESSION['role']) && $_SESSION['role'] == 'guru' && $target_id != $_SESSION['id']) {
    die("Anda tidak berhak mengedit data orang lain!");
}

// Ambil data lama menggunakan JOIN yang benar
$query1 = mysqli_query($koneksi, "SELECT username from users");
$query2 = mysqli_query($koneksi, "SELECT * from pengurus");
$data1 = mysqli_fetch_array($query1);
$data2 = mysqli_fetch_array($query2);

// Jika ID tidak ditemukan di database, hentikan proses agar tidak error
if (!$data2) {
    die("Data dengan ID tersebut tidak ditemukan di database! Periksa kembali tabel users dan pengurus Anda.");
}

// Proses jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama_lengkap   = $_POST['nama_lengkap'];
    $NIP            = $_POST['NIP'];
    $jabatan        = $_POST['jabatan'];
    $bidang         = $_POST['bidang'];
    $masa_jabatan   = $_POST['masa_jabatan'];
    $username_baru  = $_POST['username'];
    $password_baru  = $_POST['password'];

    // Update biodata
    mysqli_query($koneksi, "UPDATE pengurus SET nama_lengkap='$nama_lengkap', NIP='$NIP', jabatan='$jabatan', bidang='$bidang', masa_jabatan='$masa_jabatan' WHERE user_id='$target_id'");

    // Update username
    mysqli_query($koneksi, "UPDATE users SET username='$username_baru' WHERE id='$target_id'");

    // Update password HANYA jika kolomnya diisi
    if (!empty($password_baru)) {
        $pass_enkripsi = md5($password_baru);
        mysqli_query($koneksi, "UPDATE users SET password='$pass_enkripsi' WHERE id='$target_id'");
    }

    header("location:pengurus.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data</title>
</head>
<body>
    <h2>Edit Data</h2>
    <form method="POST" action="">
        <h4>Akun Login</h4>
        Username: <input type="text" name="username" value="<?= $data1['username']; ?>" <?= (isset($_SESSION['role']) && $_SESSION['role'] == 'guru') ? 'readonly' : ''; ?> required><br><br>
        Password Baru: <input type="password" name="password" placeholder="Kosongkan jika tidak ganti"><br>
        
        <h4>Biodata Lengkap</h4>
        Nama Lengkap: <input type="text" name="nama_lengkap" value="<?php echo $data2['nama_lengkap']; ?>" required><br><br>
        NIP         : <input type="text" name="NIP" value="<?php echo $data2['NIP']; ?>" required><br><br>
        Jabatan     : <input type="text" name="jabatan" value="<?php echo $data2['jabatan']; ?>" required><br><br>
        Bidang      : <input type="text" name="bidang" value="<?php echo $data2['bidang']; ?>" required><br><br>
        Masa Jabatan: <input type="text" name="masa_jabatan" value="<?php echo $data2['masa_jabatan']; ?>" required><br><br>
        
        <button type="submit" name="update">Update Data</button>
    </form>
</body>
</html>