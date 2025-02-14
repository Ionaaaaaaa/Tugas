<?php
session_start();
require 'koneksi.php';

// Pastikan hanya admin yang bisa menghapus
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Pastikan ada ID pegawai yang dikirim
if (isset($_GET['id'])) {
    $id_pegawai = $_GET['id'];

    // Hapus pegawai berdasarkan ID
    $query = "DELETE FROM pegawai WHERE id_pegawai = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_pegawai);

    if ($stmt->execute()) {
        echo "<script>
                alert('Pegawai berhasil dihapus!');
                window.location.href = 'dashboard_admin.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus pegawai!');
                window.location.href = 'dashboard_admin.php';
              </script>";
    }

    $stmt->close();
    $koneksi->close();
} else {
    echo "<script>
            alert('ID Pegawai tidak ditemukan!');
            window.location.href = 'dashboard_admin.php';
          </script>";
}
?>
