<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['pegawai'])) {
    header("Location: login.php");
    exit;
}

// Ambil email pegawai dari sesi login
$email = $_SESSION['pegawai'];

// Ambil data pegawai berdasarkan email
$query = "SELECT * FROM pegawai WHERE nama = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$pegawai = $result->fetch_assoc();
$id_pegawai = $pegawai['id_pegawai'];

// Ambil jadwal shift pegawai
$query = "
    SELECT shift.nama_shift, shift.jam_mulai, shift.jam_selesai, jadwal_shift.hari 
    FROM jadwal_shift 
    JOIN shift ON jadwal_shift.id_shift = shift.id_shift 
    WHERE jadwal_shift.id_pegawai = ?
    ORDER BY FIELD(jadwal_shift.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_pegawai);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">PT. Sukasari</h1>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-md hover:bg-red-600">Logout</a>
        </div>
    </nav>

    <!-- Container Utama -->
    <div class="flex flex-grow justify-center items-center p-6">
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-lg">
            <h2 class="text-2xl font-bold text-gray-700 text-center">Selamat Datang, <?php echo $email; ?>!</h2>
            <p class="text-gray-500 mt-2 text-center">Berikut adalah jadwal shift Anda:</p>

            <!-- Tabel Jadwal -->
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="border border-gray-300 p-2">Hari</th>
                        <th class="border border-gray-300 p-2">Shift</th>
                        <th class="border border-gray-300 p-2">Jam Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="text-center bg-white hover:bg-gray-100">
                            <td class="border border-gray-300 p-2"><?php echo $row['hari']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $row['nama_shift']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $row['jam_mulai'] . " - " . $row['jam_selesai']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
