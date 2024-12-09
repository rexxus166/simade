<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
require_once '../koneksi/koneksi.php';

// Ambil semua pesan dari database
$sql = "SELECT id, nama, email, pesan, tanggal FROM pesan ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Pengguna</title>
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
        /* Styling untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #00796b;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        td a {
            color: #00796b;
            text-decoration: none;
            font-weight: bold;
            margin-right: 10px;
        }

        td a:hover {
            color: #004d40;
        }

        /* Tambahkan style untuk kolom pesan */
        td:nth-child(4) {
            max-width: 300px;
            word-wrap: break-word;
        }

        /* Styling untuk kolom aksi */
        td:last-child {
            width: 150px;
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
    <h2>Daftar Pesan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Pesan</th>
                <th>Tanggal Kirim</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <?php 
                            // Jika pesan lebih dari 100 karakter, potong dan beri tautan "Lihat Selengkapnya"
                            $pesan = htmlspecialchars($row['pesan']);
                            echo (strlen($pesan) > 100) ? substr($pesan, 0, 100) . '...' : $pesan; 
                            ?>
                        </td>
                        <td><?php echo date("d-m-Y H:i", strtotime($row['tanggal'])); ?></td>
                        <td>
                            <a href="lihat_pesan.php?id=<?php echo $row['id']; ?>">Baca</a> |
                            <a href="delete_message.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus pesan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Belum ada pesan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
