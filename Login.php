<?php
require_once 'koneksi/koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menulis query untuk mencari username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);  // Bind parameter
    $stmt->execute();
    $result = $stmt->get_result();  // Menjalankan query dan mendapatkan hasil

    // Mengecek apakah ada hasil untuk username yang dicari
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();  // Ambil data pengguna
        if (password_verify($password, $user['password'])) {  // Verifikasi password
            $_SESSION['username'] = $username;  // Simpan username dalam session
            header("Location: index.php");  // Redirect ke halaman index setelah login
            exit();
        } else {
            $error_message = "Password salah!";
        }
    } else {
        $error_message = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                        url('img/i.jpg') center/cover no-repeat fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }

        .container {
            width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            position: relative;
            z-index: 1;
        }

        /* Optional: Add a subtle glow effect */
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 15px;
            background: linear-gradient(45deg, 
                transparent,
                rgba(205, 155, 106, 0.1),
                transparent
            );
            z-index: -1;
        }

        h2 {
            color: #CD9B6A;
            text-align: center;
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 600;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        label {
            display: block;
            color: #ffffff;
            margin-bottom: 8px;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid rgba(205, 155, 106, 0.5);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 6px;
            color: #ffffff;
            box-sizing: border-box;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #CD9B6A;
            box-shadow: 0 0 15px rgba(205, 155, 106, 0.3);
            outline: none;
            background: rgba(255, 255, 255, 0.1);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            background: rgba(205, 155, 106, 0.8);
            border: none;
            border-radius: 6px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            background: rgba(205, 155, 106, 0.9);
            box-shadow: 0 0 20px rgba(205, 155, 106, 0.4);
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            color: #ff6b6b;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        p {
            color: #ffffff;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        p a {
            color: #CD9B6A;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        p a:hover {
            color: #E5B589;
            text-shadow: 0 0 10px rgba(205, 155, 106, 0.5);
        }

        /* Error message styling */
        .error-message {
            background: rgba(255, 87, 87, 0.1);
            border: 1px solid rgba(255, 87, 87, 0.5);
            color: #ff5757;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        /* Optional: Add animation for container appearance */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login Akun</h2>
    <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a>.</p>
</div>

</body>
</html>