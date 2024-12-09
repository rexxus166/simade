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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }
        .navbar {
            background-color: #00796b;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #005662;
            margin-bottom: 20px;
        }
        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
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
            background-color: #00796b;
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
            color: #00796b;
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
            <form style="display:inline;" method="POST" action="logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <!-- Konten Dashboard -->
    <div class="container">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Gunakan navigasi di atas untuk mengelola data pengguna, artikel, atau melihat pesan dari pengguna.</p>
    </div>
</body>

</html>
