<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

// Proteksi Halaman: Jika belum login, jangan boleh tambah data
if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit;
}

// Hanya admin yang boleh tambah data
if ($_SESSION['role'] != 'admin') {
    die("<div style='text-align:center;margin-top:50px;font-family:sans-serif;'><h3>Akses Ditolak! Hanya admin yang boleh menambah data.</h3><a href='pengurus.php'>Kembali</a></div>");
}

if (isset($_POST['submit'])) {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $NIP          = mysqli_real_escape_string($koneksi, $_POST['NIP']);
    $jabatan      = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $bidang       = mysqli_real_escape_string($koneksi, $_POST['bidang']);
    $masa_jabatan = mysqli_real_escape_string($koneksi, $_POST['masa_jabatan']);
    $username_baru = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_baru = md5($_POST['password']);

    // 1. Insert ke tabel users dulu untuk dapatkan ID
    mysqli_query($koneksi, "INSERT INTO users (username, password, role) VALUES ('$username_baru', '$password_baru', 'guru')");
    $new_user_id = mysqli_insert_id($koneksi);

    // 2. Baru insert ke tabel pengurus pakai ID yang baru didapat
    mysqli_query($koneksi, "INSERT INTO pengurus (user_id, nama_lengkap, NIP, jabatan, bidang, masa_jabatan) 
                            VALUES ('$new_user_id', '$nama_lengkap', '$NIP', '$jabatan', '$bidang', '$masa_jabatan')");

    header("location:pengurus.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengurus</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
        }

        h3 {
            color: #3498db;
            margin-top: 10px;
            margin-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 5px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            background-color: #fff;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-submit:hover {
            background-color: #2980b9;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }

        .btn-batal {
            display: block;
            text-align: center;
            text-decoration: none;
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 15px;
            font-weight: 600;
        }
        .btn-batal:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Tambah Data</h1>
    
    <form method="POST" action="">

        <h3>Akun Login</h3>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
        </div>

        <h3>Biodata Lengkap</h3>
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap beserta gelar" required>
        </div>
        
        <div class="form-group">
            <label>NIP (Nomor Induk Pegawai)</label>
            <input type="text" 
                   inputmode="numeric" 
                   pattern="[0-9]*" 
                   name="NIP" 
                   maxlength="18" 
                   placeholder="Masukkan NIP" 
                   required 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        </div>
        
        <div class="form-group">
            <label>Jabatan</label>
            <select name="jabatan" required>
                <option value="" disabled selected hidden>-- Pilih Jabatan Pekerjaan --</option>
                <option value="Penanggung Jawab">Penanggung Jawab</option>
                <option value="Ketua Kesiswaan">Ketua Kesiswaan</option>
                <option value="Pembina OSIS">Pembina</option>
                <option value="Staff Kesiswaan">Staff Kesiswaan</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Bidang</label>
            <select name="bidang" required>
                <option value="" disabled selected hidden>-- Pilih Bidang --</option>
                <option value="Kesiswaan">Kesiswaan</option>
                <option value="Kedisiplinan Putra">Kedisiplinan Putra</option>
                <option value="Kedisiplinan Putri">Kedisiplinan Putri</option>
                <option value="OSIS">OSIS</option>
                <option value="Paskibra">Paskibra</option>
                <option value="Pramuka">Pramuka</option>
                <option value="Kerohanian">Kerohanian</option>
                <option value="Pecinta Alam">Pecinta Alam</option>
                <option value="PMR">PMR</option>
                <option value="Kesenian">Kesenian</option>
                <option value="Bahasa">Bahasa</option>
                <option value="Olahraga">Olahraga</option>
                <option value="KKR">KKR</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Masa Jabatan (Jumlah Tahun)</label>
            <input type="text" 
                   inputmode="numeric" 
                   pattern="[0-9]*" 
                   name="masa_jabatan" 
                   maxlength="2" 
                   placeholder="Berapa lama (tahun) menjabat" 
                   required 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        </div>
        
        <button type="submit" name="submit" class="btn-submit">Tambah Pengurus</button>
        <a href="pengurus.php" class="btn-batal">Batal</a>
    </form>
</div>

</body>
</html>