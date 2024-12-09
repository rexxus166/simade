<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once '../koneksi/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pesan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $message = $result->fetch_assoc();
} else {
    echo "Pesan tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesan</title>
    <style>
        /* Styling untuk halaman detail pesan */
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
            color: #00796b;
        }
        p {
            color: #333;
            font-size: 16px;
        }
        .message-content {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1>Admin Dashboard</h1>
    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="artikel.php">Kelola Artikel</a>
        <a href="view_messages.php">Pesan Pengguna</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Detail Pesan</h2>
    <p><strong>Nama:</strong> <?php echo htmlspecialchars($message['nama']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($message['email']); ?></p>
    <p><strong>Pesan:</strong></p>
    <div class="message-content">
        <p><?php echo nl2br(htmlspecialchars($message['pesan'])); ?></p>
    </div>
    <p><strong>Tanggal Kirim:</strong> <?php echo date("d-m-Y H:i", strtotime($message['tanggal'])); ?></p>
</div>

</body>
</html>