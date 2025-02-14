<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Ambil daftar pegawai
$query = "SELECT * FROM pegawai";
$pegawai_result = $koneksi->query($query);

// Ambil daftar shift
$query = "SELECT * FROM shift";
$shift_result = $koneksi->query($query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">PT. Sukasari</h1>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-md hover:bg-red-600 transition">Logout</a>
        </div>
    </nav>

    <!-- Container Utama -->
    <div class="flex flex-grow justify-center items-center p-6">
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-4xl">
            <h2 class="text-2xl font-bold text-gray-700 text-center">Dashboard Admin</h2>

            <!-- Daftar Pegawai -->
            <h3 class="text-xl font-bold text-gray-600 mt-6">Kelola Pegawai</h3>
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="border border-gray-300 p-2">Id</th>
                        <th class="border border-gray-300 p-2">Nama</th>
                        <th class="border border-gray-300 p-2">Email</th>
                        <th class="border border-gray-300 p-2">Jabatan</th>
                        <th class="border border-gray-300 p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pegawai = $pegawai_result->fetch_assoc()): ?>
                        <tr class="text-center bg-white hover:bg-gray-100">
                            <td class="border border-gray-300 p-2"><?php echo $pegawai['id_pegawai']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $pegawai['nama']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $pegawai['email']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $pegawai['jabatan']; ?></td>
                            <td class="border border-gray-300 p-2">
                                <a href="edit_pegawai.php?id=<?php echo $pegawai['id_pegawai']; ?>" class="text-blue-500">Edit</a>
                                <a href="#" class="text-red-500 ml-2" onclick="konfirmasiHapus(<?php echo $pegawai['id_pegawai']; ?>)">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- Tombol Tambah Pegawai -->
            <div class="mt-4 flex justify-center">
                <a href="tambah_pegawai.php" class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                    + Tambah Pegawai
                </a>
            </div>
            <!-- Daftar Shift -->
            <h3 class="text-xl font-bold text-gray-600 mt-6">Shift</h3>
            <table class="w-full mt-4 border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-blue-500 text-white">
                        <th class="border border-gray-300 p-2">Nama Shift</th>
                        <th class="border border-gray-300 p-2">Jam Mulai</th>
                        <th class="border border-gray-300 p-2">Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($shift = $shift_result->fetch_assoc()): ?>
                        <tr class="text-center bg-white hover:bg-gray-100">
                            <td class="border border-gray-300 p-2"><?php echo $shift['nama_shift']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $shift['jam_mulai']; ?></td>
                            <td class="border border-gray-300 p-2"><?php echo $shift['jam_selesai']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function konfirmasiHapus(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data pegawai akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "hapus_pegawai.php?id=" + id;
                }
            });
        }
    </script>

</body>
</html>
