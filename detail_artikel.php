<?php
// Koneksi ke database dan ambil artikel berdasarkan ID
require_once 'koneksi/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $artikel = $result->fetch_assoc();
    } else {
        echo "Artikel tidak ditemukan!";
        exit;
    }
} else {
    echo "ID artikel tidak diberikan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Artikel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="navbar-logo">
            <a href="#home" class="navbar-logo">SIMADE<span>POLINDRA</span>.</a>
        </div>
        <div class="navbar-nav">
            <a href="index.php">Home</a>
            <a href="artikel.php">Artikel</a>
        </div>
    </div>

    <!-- Detail Artikel -->
    <div class="container" style="margin-top: 100px;">
        <h2><?php echo htmlspecialchars($artikel['judul']); ?></h2>
        <div class="article-meta">
            <span>Published on: <?php echo date("d M Y", strtotime($artikel['tanggal'])); ?></span>
        </div>
        <div class="article-content">
            <img src="uploads/<?php echo $artikel['gambar']; ?>" alt="Gambar Artikel" style="width: 100%; max-width: 700px; height: auto; margin: 20px 0;">
            <p><?php echo nl2br(htmlspecialchars($artikel['konten'])); ?></p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="socials">
            <a href="#">Facebook</a>
            <a href="#">Instagram</a>
            <a href="#">Twitter</a>
        </div>
        <div class="links">
            <a href="#">Privacy</a>
            <a href="#">Terms</a>
        </div>
        <p class="credit">© 2024 <a href="#">NewSimade</a>. All rights reserved.</p>
    </footer>

</body>
</html>