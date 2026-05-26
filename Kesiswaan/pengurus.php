<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("location:login.php");
    exit;
}

if($_SESSION['role'] == 'admin'){

    $data = mysqli_query($koneksi,
    "SELECT users.username, pengurus.*
    FROM users
    JOIN pengurus ON users.id = pengurus.user_id");

}else{

    $id_user = $_SESSION['id'];

    $data = mysqli_query($koneksi,
    "SELECT users.username, pengurus.*
    FROM users
    JOIN pengurus ON users.id = pengurus.user_id
    WHERE users.id='$id_user'");

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengurus - Kesiswaan</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        /* CSS UTAMA DASHBOARD */
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
    /* MENGGUNAKAN DUA LAPISAN: 
       1. linear-gradient sebagai filter/kaca film putih transparan (kebiruan lembut)
       2. url() sebagai foto gedungnya
    */
    background: linear-gradient(rgba(244, 246, 249, 0.75), rgba(244, 246, 249, 0.75)), 
                url('images/bg1.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
    color: #333;
    
    /* PENTING: Menghapus display flex agar susunan navbar atas tidak rusak */
}

.dashboard-container {
    /* Mengubah background container menjadi putih solid atau sedikit semi-transparan mewah */
    background-color: rgba(255, 255, 255, 0.93); 
    width: 100%;
    max-width: 1000px;
    padding: 30px;
    border-radius: 12px;
    
    /* Memberi bayangan lembut agar kotak tabel terlihat "mengambang" di atas background blur */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); 
}

        /* ========================================================
           CSS MENU NAVIGASI ATAS (BARU & COCOK DENGAN DASHBOARD)
           ======================================================== */
        .navbar-top {
            background-color: #2c3e50; /* Warna utama senada dengan judul dashboard */
            padding: 0 20px;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            color: #ffffff;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            height: 100%;
            align-items: center;
        }

        .navbar-item {
            height: 100%;
            display: flex;
            align-items: center;
        }

        .navbar-link {
            color: #b0bec5; /* Warna teks pasif: Abu-abu kebiruan lembut (bukan putih mencolok) */
            text-decoration: none;
            padding: 0 18px;
            font-size: 14px;
            font-weight: 600;
            height: 100%;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        /* Efek saat tab menu disorot (Hover) atau halaman aktif */
        .navbar-link:hover, 
        .navbar-item.active .navbar-link {
            color: #3498db !important; /* Berubah jadi Biru Langit cerah saat dipencet (bukan kuning) */
            background-color: rgba(255, 255, 255, 0.04); /* Efek background subtle */
            border-bottom: 3px solid #3498db; /* Garis penanda aktif di bawah */
        }

        .navbar-link i {
            margin-right: 7px;
            font-size: 15px;
        }

        /* CONTAINER UTAMA */
        .main-content {
            padding: 40px 20px;
            display: flex;
            justify-content: center;
        }

        .dashboard-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 1000px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-weight: 600;
            font-size: 24px;
        }

        .welcome-text {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .btn-tambah {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 25px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-tambah:hover {
            background-color: #2980b9;
        }

        .btn-tambah:active {
            transform: scale(0.98);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            color: #555;
            font-weight: 600;
            padding: 14px 16px;
            border-bottom: 2px solid #e9ecef;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f0f0f0;
            color: #444;
            vertical-align: middle;
        }

        tr:nth-child(even) td {
            background-color: #fdfdfd;
        }

        tr:hover td {
            background-color: #f4f7f9;
        }

        td:nth-child(1), th:nth-child(1),
        td:nth-child(7), td:nth-child(8),
        th:nth-child(7), th:nth-child(8) {
            text-align: center;
        }

        .btn-action {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }

        .btn-action:hover {
            opacity: 0.85;
        }

        .btn-edit {
            background-color: #e67e22;
            color: white;
        }

        .btn-hapus {
            background-color: #e74c3c;
            color: white;
        }

        
    </style>
</head>
<body>

<nav class="navbar-top">
    <a href="index.php" class="navbar-brand">
        <i class="" style="color: #3498db; margin-right: 5px;"></i> Kesiswaan - SMKN 2 Baleendah
    </a>
    <ul class="navbar-menu">
        <li class="navbar-item">
            <a href="index.php" class="navbar-link"><i class="fa-solid fa-house"></i>Home</a>
        </li>
        <li class="navbar-item">
            <a href="members.php" class="navbar-link"><i class="fa-solid fa-users"></i>Members</a>
        </li>
        <li class="navbar-item">
            <a href="about.php" class="navbar-link"><i class="fa-solid fa-briefcase"></i>Program Kerja</a>
        </li>
        <li class="navbar-item active">
            <a href="pengurus.php" class="navbar-link"><i class="fa-solid fa-address-card"></i>Biodata</a>
        </li>
        <li class="navbar-item">
            <a href="logout.php" class="navbar-link" style="color: #e74c3c !important;"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
        </li>
    </ul>
</nav>

<div class="main-content">
    <div class="dashboard-container">
        <h2>Data Pengurus Kesiswaan</h2>
        <p class="welcome-text">Halo, <strong><?php echo $_SESSION['username']; ?></strong>! Selamat mengelola data.</p>

        <a href="tambah.php" class="btn-tambah"><i class="fa-solid fa-user-plus" style="margin-right: 5px;"></i> Tambah Data</a>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NIP</th>
                        <th>Jabatan</th>
                        <th>Bidang</th>
                        <th>Masa Jabatan</th>
                        <th>Hapus</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td><strong><?php echo $no++; ?></strong></td>
                        <td style="font-weight: 600; color: #2c3e50;"><?php echo $d['nama_lengkap']; ?></td>
                        <td><?php echo $d['NIP']; ?></td>
                        <td><?php echo $d['jabatan']; ?></td>
                        <td><?php echo $d['bidang']; ?></td>
                        <td><?php echo $d['masa_jabatan']; ?></td>
                        <td><a href="hapus.php?id=<?= $d["user_id"] ?>" class="btn-action btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa-solid fa-trash"></i> Hapus</a></td>
                        <td><a href="edit.php?id=<?= $d["user_id"] ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i> Update</a></td>
                    </tr>
                    <?php 
                    } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>