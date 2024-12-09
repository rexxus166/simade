<?php
require 'koneksi/koneksi.php'; // Pastikan jalur file sesuai dengan lokasi file Anda

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if (empty($name)) {
        $errors[] = "Nama harus diisi.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email tidak valid.";
    }
    if (empty($message)) {
        $errors[] = "Pesan tidak boleh kosong.";
    }

    if (!empty($errors)) {
        echo "<h3>Terjadi kesalahan:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO pesan (nama, email, pesan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Pesan berhasil dikirim dan disimpan.";
    } else {
        echo "Gagal menyimpan pesan: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
