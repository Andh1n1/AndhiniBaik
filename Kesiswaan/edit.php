<?php
include 'koneksi.php';

$target_id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Kunci Pintu: Jika dia Guru, pastikan dia hanya buka ID miliknya sendiri
if (isset($_SESSION['role']) && $_SESSION['role'] == 'guru' && $target_id != $_SESSION['id']) {
    die("Anda tidak berhak mengedit data orang lain!");
}

// Ambil data dari kedua tabel
$query1 = mysqli_query($koneksi, "SELECT username FROM users WHERE id = '$target_id'");
$query2 = mysqli_query($koneksi, "SELECT * FROM pengurus WHERE user_id = '$target_id'");

$data1 = mysqli_fetch_array($query1);
$data2 = mysqli_fetch_array($query2);

// Jika ID tidak ditemukan di tabel pengurus, hentikan proses
if (!$data2) {
    die("<div style='text-align:center; margin-top:50px; font-family:sans-serif;'><h3>Data dengan ID tersebut tidak ditemukan di database!</h3></div>");
}

// Proses jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama_lengkap  = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $NIP           = mysqli_real_escape_string($koneksi, $_POST['NIP']);
    $jabatan       = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $bidang        = mysqli_real_escape_string($koneksi, $_POST['bidang']);
    $masa_jabatan  = mysqli_real_escape_string($koneksi, $_POST['masa_jabatan']);
    $username_baru = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password_baru = $_POST['password'];

    // Update biodata pengurus
    mysqli_query($koneksi, "UPDATE pengurus SET nama_lengkap='$nama_lengkap', NIP='$NIP', jabatan='$jabatan', bidang='$bidang', masa_jabatan='$masa_jabatan' WHERE user_id='$target_id'");

    // Update username (hanya admin yang bisa ubah username)
    if ($_SESSION['role'] == 'admin') {
        mysqli_query($koneksi, "UPDATE users SET username='$username_baru' WHERE id='$target_id'");
    }

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
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
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
            margin-top: 20px;
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
        input[type="number"],
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

        input[readonly] {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: #e9ecef;
            cursor: not-allowed;
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
            margin-top: 25px;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .btn-submit:hover {
            background-color: #2980b9;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Data</h1>
    
    <form method="POST" action="">
        <h3>Akun Login</h3>
        
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Masukkan username" 
                   value="<?php echo htmlspecialchars($data1['username'] ?? ''); ?>" 
                   <?php echo (isset($_SESSION['role']) && $_SESSION['role'] == 'guru') ? 'readonly' : ''; ?> required>
        </div>
        
        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ganti">
        </div>
        
        <h3>Biodata Lengkap</h3>
        
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" placeholder="Masukkan nama lengkap beserta gelar" 
                   value="<?php echo htmlspecialchars($data2['nama_lengkap']); ?>" required>
        </div>

        <!-- BUG FIX: NIP sekarang punya form-group + label + value dari database -->
        <div class="form-group">
            <label>NIP (Nomor Induk Pegawai)</label>
            <input type="text" 
                   inputmode="numeric" 
                   pattern="[0-9]*" 
                   name="NIP" 
                   maxlength="18" 
                   placeholder="Masukkan NIP" 
                   value="<?php echo htmlspecialchars($data2['NIP']); ?>"
                   required 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        </div>
        
        <!-- BUG FIX: Jabatan sekarang pre-fill dari database -->
        <div class="form-group">
            <label>Jabatan</label>
            <select name="jabatan" required>
                <option value="" disabled hidden>-- Pilih Jabatan Pekerjaan --</option>
                <option value="Penanggung Jawab"  <?php echo (trim($data2['jabatan']) == 'Penanggung Jawab')  ? 'selected' : ''; ?>>Penanggung Jawab</option>
                <option value="Ketua Kesiswaan"   <?php echo (trim($data2['jabatan']) == 'Ketua Kesiswaan')   ? 'selected' : ''; ?>>Ketua Kesiswaan</option>
                <option value="Pembina"      <?php echo (trim($data2['jabatan']) == 'Pembina OSIS')      ? 'selected' : ''; ?>>Pembina OSIS</option>
                <option value="Staff Kesiswaan"   <?php echo (trim($data2['jabatan']) == 'Staff Kesiswaan')   ? 'selected' : ''; ?>>Staff Kesiswaan</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Bidang</label>
            <select name="bidang" required>
                <option value="" disabled <?php echo empty(trim($data2['bidang'])) ? 'selected' : ''; ?> hidden>-- Pilih Bidang --</option>
                <option value="Kesiswaan"          <?php echo (trim($data2['bidang']) == 'Kesiswaan')          ? 'selected' : ''; ?>>Kesiswaan</option>
                <option value="Kedisiplinan Putra" <?php echo (trim($data2['bidang']) == 'Kedisiplinan Putra') ? 'selected' : ''; ?>>Kedisiplinan Putra</option>
                <option value="Kedisiplinan Putri" <?php echo (trim($data2['bidang']) == 'Kedisiplinan Putri') ? 'selected' : ''; ?>>Kedisiplinan Putri</option>
                <option value="OSIS"               <?php echo (trim($data2['bidang']) == 'OSIS')               ? 'selected' : ''; ?>>OSIS</option>
                <option value="Paskibra"           <?php echo (trim($data2['bidang']) == 'Paskibra')           ? 'selected' : ''; ?>>Paskibra</option>
                <option value="Pramuka"            <?php echo (trim($data2['bidang']) == 'Pramuka')            ? 'selected' : ''; ?>>Pramuka</option>
                <option value="Kerohanian"         <?php echo (trim($data2['bidang']) == 'Kerohanian')         ? 'selected' : ''; ?>>Kerohanian</option>
                <option value="Pecinta Alam"       <?php echo (trim($data2['bidang']) == 'Pecinta Alam')       ? 'selected' : ''; ?>>Pecinta Alam</option>
                <option value="PMR"                <?php echo (trim($data2['bidang']) == 'PMR')                ? 'selected' : ''; ?>>PMR</option>
                <option value="Kesenian"           <?php echo (trim($data2['bidang']) == 'Kesenian')           ? 'selected' : ''; ?>>Kesenian</option>
                <option value="Bahasa"             <?php echo (trim($data2['bidang']) == 'Bahasa')             ? 'selected' : ''; ?>>Bahasa</option>
                <option value="Olahraga"           <?php echo (trim($data2['bidang']) == 'Olahraga')           ? 'selected' : ''; ?>>Olahraga</option>
                <option value="KKR"                <?php echo (trim($data2['bidang']) == 'KKR')                ? 'selected' : ''; ?>>KKR</option>
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
                   value="<?php echo htmlspecialchars($data2['masa_jabatan']); ?>"
                   required 
                   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
        </div>
        
        <button type="submit" name="update" class="btn-submit">Update Data</button>
    </form>
</div>

</body>
</html>