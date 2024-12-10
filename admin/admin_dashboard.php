<?php
session_start();
// Periksa apakah user sudah login, jika belum redirect ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1b1b1b;
            color: #ffffff;
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff;
        }
        .navbar a {
            color: #ffffff;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #f0c674;
        }

        .container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: black;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #f0c674;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #dcdcdc;
        }
        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #b0bec5;
            border-radius: 8px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            background-color: #f0c674;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background-color: #004d40;
        }
        .pesan {
            margin-top: 20px;
            font-size: 14px;
            color: #f0c674;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <h1>Admin Dashboard</h1>
        <div>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="artikel.php">Kelola Artikel</a>
            <a href="view_messages.php">Pesan Pengguna</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Konten Dashboard -->
    <div class="container">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Gunakan navigasi di atas untuk mengelola data pengguna, artikel, atau melihat pesan dari pengguna.</p>
    </div>
</body>

</html>
