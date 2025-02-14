<?php
$host = "localhost"; // Sesuaikan dengan host database Anda
$user = "root"; // Sesuaikan dengan username database Anda
$password = ""; // Jika ada password, isi di sini
$database = "db_pegawai"; // Nama database

// Membuat koneksi ke MySQL
$koneksi = new mysqli($host, $user, $password, $database);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Jika ingin memastikan koneksi berhasil, bisa tambahkan:
// echo "Koneksi berhasil!";
?>
