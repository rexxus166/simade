<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
require_once '../koneksi/koneksi.php';

// Proses penyimpanan data artikel (Tambah Artikel)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];

    // Proses upload gambar
    $target_dir = "../uploads/"; // Direktori tempat menyimpan gambar
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file adalah gambar
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $pesan = "File bukan gambar.";
            $uploadOk = 0;
        }
    } else {
        $pesan = "Gagal mengunggah gambar.";
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($_FILES["gambar"]["size"] > 2000000) { // Maksimal 2MB
        $pesan = "Ukuran file terlalu besar.";
        $uploadOk = 0;
    }

    // Periksa format file
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $pesan = "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Jika lolos semua pemeriksaan, upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = basename($_FILES["gambar"]["name"]); // Simpan nama file untuk database

            // Simpan data artikel ke database
            $sql = "INSERT INTO artikel (judul, konten, gambar, tanggal) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $judul, $konten, $gambar);
                if ($stmt->execute()) {
                    $pesan = "Artikel berhasil disimpan!";
                } else {
                    $pesan = "Gagal menyimpan artikel: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $pesan = "Gagal menyimpan artikel: " . $conn->error;
            }
        } else {
            $pesan = "Terjadi kesalahan saat mengunggah gambar.";
        }
    }
}

// Proses Edit Artikel
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $artikel = $result->fetch_assoc();
    $stmt->close();
}

// Proses Edit (Update) Artikel
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $edit_id = $_POST['id'];
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $gambar = $_POST['existing_image'];

    // Proses upload gambar jika ada file baru
    if (isset($_FILES["gambar"]) && $_FILES["gambar"]["error"] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Periksa apakah file adalah gambar
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check !== false) {
            // Periksa ukuran file
            if ($_FILES["gambar"]["size"] <= 2000000) {
                // Periksa format file
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
                    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                        $gambar = basename($_FILES["gambar"]["name"]);
                    }
                } else {
                    $pesan = "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
                }
            } else {
                $pesan = "Ukuran file terlalu besar.";
            }
        } else {
            $pesan = "File bukan gambar.";
        }
    }

    // Update artikel
    $sql = "UPDATE artikel SET judul = ?, konten = ?, gambar = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $judul, $konten, $gambar, $edit_id);

    if ($stmt->execute()) {
        $pesan = "Artikel berhasil diperbarui!";
    } else {
        $pesan = "Gagal memperbarui artikel: " . $stmt->error;
    }
    $stmt->close();
}

// Proses Hapus Artikel
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM artikel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $pesan = "Artikel berhasil dihapus!";
    } else {
        $pesan = "Gagal menghapus artikel: " . $stmt->error;
    }
    $stmt->close();
}

// Ambil daftar artikel
$sql = "SELECT * FROM artikel ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artikel</title>
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
    <h2><?php echo isset($artikel) ? 'Edit Artikel' : 'Tambah Artikel Baru'; ?></h2>
    <?php if (!empty($pesan)): ?>
        <p class="pesan"><?php echo $pesan; ?></p>
    <?php endif; ?>

    <form method="POST" action="artikel.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo isset($artikel) ? 'edit' : 'add'; ?>">
        <?php if (isset($artikel)): ?>
            <input type="hidden" name="id" value="<?php echo $artikel['id']; ?>">
            <input type="hidden" name="existing_image" value="<?php echo $artikel['gambar']; ?>">
        <?php endif; ?>

        <label for="judul">Judul Artikel:</label>
        <input type="text" name="judul" id="judul" value="<?php echo isset($artikel) ? $artikel['judul'] : ''; ?>" required>

        <label for="konten">Konten Artikel:</label>
        <textarea name="konten" id="konten" rows="10" required><?php echo isset($artikel) ? $artikel['konten'] : ''; ?></textarea>

        <label for="gambar">Upload Gambar:</label>
        <input type="file" name="gambar" id="gambar">

        <?php if (isset($artikel) && $artikel['gambar']): ?>
            <p>Gambar Lama: <img src="../uploads/<?php echo $artikel['gambar']; ?>" width="100"></p>
        <?php endif; ?>

        <button type="submit"><?php echo isset($artikel) ? 'Perbarui Artikel' : 'Simpan Artikel'; ?></button>
    </form>

    <h2>Daftar Artikel</h2>
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background-color: #333; color: #fff;">
        <thead>
            <tr>
                <th style="text-align: center;">No</th>
                <th>Judul Artikel</th>
                <th>Tanggal Publikasi</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1; // Mulai dari nomor 1
            while ($artikel = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($artikel['judul']); ?></td>
                <td><?php echo date("d M Y", strtotime($artikel['tanggal'])); ?></td>
                <td style="text-align: center;">
                    <!-- Aksi Edit dan Hapus dengan URL sesuai keinginan -->
                    <a href="artikel.php?edit_id=<?php echo $artikel['id']; ?>" 
                    style="color: #f0c674; text-decoration: none; font-weight: bold; padding: 5px 10px; background-color: #444; border-radius: 5px;">Edit</a>
                    <a href="artikel.php?delete_id=<?php echo $artikel['id']; ?>" 
                    style="color: #e57373; text-decoration: none; font-weight: bold; padding: 5px 10px; background-color: #444; border-radius: 5px; margin-left: 10px;"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">Hapus</a>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</div>

</body>
</html>