<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

require_once '../koneksi/koneksi.php';

// Cek apakah ada ID yang dikirimkan lewat URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus pesan berdasarkan ID
    $sql = "DELETE FROM pesan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman daftar pesan setelah berhasil dihapus
        header("Location: view_messages.php?message=Pesan berhasil dihapus");
        exit();
    } else {
        // Jika gagal, beri pesan error
        echo "Terjadi kesalahan dalam menghapus pesan.";
    }
} else {
    // Jika tidak ada ID, redirect ke halaman daftar pesan
    header("Location: view_messages.php");
    exit();
}