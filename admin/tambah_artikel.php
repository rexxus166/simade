<?php
// Impor koneksi database
require_once 'koneksi/koneksi.php';

// Proses tambah artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $tanggal = date('Y-m-d');

    $sql = "INSERT INTO artikel (judul, konten, tanggal) VALUES ('$judul', '$konten', '$tanggal')";
    if ($conn->query($sql) === TRUE) {
        echo "Artikel berhasil ditambahkan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!-- Form tambah artikel -->
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Artikel</title>
</head>
<body>
    <form method="POST" action="tambah_artikel.php">
        <label>Judul Artikel:</label>
        <input type="text" name="judul" required><br><br>
        <label>Konten Artikel:</label>
        <textarea name="konten" rows="10" cols="30" required></textarea><br><br>
        <button type="submit">Tambah Artikel</button>
    </form>
</body>
</html>
