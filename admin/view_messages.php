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
            background-color: #f0c674;
            color: white;
        }

        td {
            background-color: ;
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
