<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Kesiswaan - SMKN 2 Baleendah</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        body {
            /* Menggunakan background gambar gedung sekolah kamu */
            background: url('images/bg1.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Lapisan gelap transparan di atas gambar biar tidak terlalu silau */
        body::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(44, 62, 80, 0.55); 
            backdrop-filter: blur(3px); /* Efek blur halus pada gambar gedung */
            z-index: 1;
        }

        /* Kotak Login Transparan Modern (Glassmorphism) */
        .login-card {
            background: rgba(255, 255, 255, 0.85); /* Warna putih semi-transparan */
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
            z-index: 2; /* Supaya berada di atas lapisan background */
            text-align: center;
        }

        /* Logo Icon Top */
        .login-icon {
            background-color: #3498db;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        p.subtitle {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Grup input pembungkus ikon */
        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #95a5a6;
            font-size: 16px;
            transition: color 0.3s;
        }

        .input-group input {
            width: 100%;
            padding: 14px 15px 14px 45px; /* Kasih space di kiri untuk ikon */
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            color: #333;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        /* Efek fokus saat input diklik */
        .input-group input:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.15);
        }

        .input-group input:focus + i {
            color: #3498db; /* Ikon ikut berubah biru saat diklik */
        }

        /* Tombol Login Modern */
        button[type="submit"] {
            width: 100%;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.2);
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-logo-container">
        <img src="images/logo.png" alt="Logo SMKN 2 Baleendah">
    </div>
    
    <h2>Login Kesiswaan</h2>
    <p class="subtitle">SMKN 2 Baleendah</p>

    <form method="POST" action="cek_login.php">
        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fa-solid fa-lock"></i>
        </div>

        <button type="submit">Log In</button>
    </form>
</div>

</body>
</html>