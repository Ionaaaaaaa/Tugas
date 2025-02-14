<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard_admin.php");
    exit;
}

$id_pegawai = $_GET['id'];

// Ambil data pegawai
$query = "SELECT * FROM pegawai WHERE id_pegawai = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_pegawai);
$stmt->execute();
$result = $stmt->get_result();
$pegawai = $result->fetch_assoc();

// Ambil daftar shift
$query = "SELECT * FROM shift";
$shift_result = $koneksi->query($query);

// Ambil jadwal pegawai
$query = "SELECT * FROM jadwal_shift WHERE id_pegawai = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $id_pegawai);
$stmt->execute();
$jadwal_result = $stmt->get_result();

$jadwal_pegawai = [];
while ($jadwal = $jadwal_result->fetch_assoc()) {
    $jadwal_pegawai[$jadwal['hari']] = $jadwal['id_shift'];
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jabatan = $_POST['jabatan'];
    $jadwal = $_POST['jadwal'];

    $query = "UPDATE pegawai SET nama = ?, email = ?, jabatan = ? WHERE id_pegawai = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssi", $nama, $email, $jabatan, $id_pegawai);
    $stmt->execute();

    $query = "DELETE FROM jadwal_shift WHERE id_pegawai = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id_pegawai);
    $stmt->execute();

    foreach ($jadwal as $hari => $id_shift) {
        $query = "INSERT INTO jadwal_shift (id_pegawai, id_shift, hari) VALUES (?, ?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("iis", $id_pegawai, $id_shift, $hari);
        $stmt->execute();
    }

    header("Location: dashboard_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">PT. Sukasari</h1>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">Logout</a>
        </div>
    </nav>

    <!-- Container -->
    <div class="flex flex-grow justify-center items-center p-6">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold text-gray-700 text-center">Edit Pegawai</h2>

            <form action="" method="POST" class="mt-6">
                <!-- Nama -->
                <div class="mb-4">
                    <label class="block text-gray-600">Nama</label>
                    <input type="text" name="nama" value="<?php echo $pegawai['nama']; ?>" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-600">Email</label>
                    <input type="email" name="email" value="<?php echo $pegawai['email']; ?>" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <!-- Jabatan -->
                <div class="mb-4">
                    <label class="block text-gray-600">Jabatan</label>
                    <input type="text" name="jabatan" value="<?php echo $pegawai['jabatan']; ?>" class="w-full p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition" required>
                </div>

                <!-- Jadwal Kerja -->
                <h3 class="text-xl font-bold text-gray-600 mt-6">Jadwal Kerja</h3>
                <div class="grid grid-cols-2 gap-4 mt-2">
                    <?php
                    $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    while ($shift = $shift_result->fetch_assoc()) {
                        foreach ($hari_list as $hari) {
                            $checked = isset($jadwal_pegawai[$hari]) && $jadwal_pegawai[$hari] == $shift['id_shift'] ? "checked" : "";
                            echo "
                            <label class='flex items-center space-x-2 bg-gray-200 p-3 rounded-md hover:bg-gray-300 transition'>
                                <input type='checkbox' name='jadwal[$hari]' value='{$shift['id_shift']}' $checked class='w-5 h-5 text-blue-500'>
                                <span class='text-gray-700 font-medium'>{$hari} - {$shift['nama_shift']} ({$shift['jam_mulai']} - {$shift['jam_selesai']})</span>
                            </label>";
                        }
                    }
                    ?>
                </div>

                <!-- Tombol Simpan -->
                <button type="submit" name="update" class="mt-6 bg-blue-500 text-white py-3 px-6 rounded-md w-full hover:bg-blue-600 transition duration-300">
                    Simpan Perubahan
                </button>

                <!-- Tombol Kembali -->
                <a href="dashboard_admin.php" class="block text-center text-gray-500 mt-4 hover:text-gray-700 transition">Kembali</a>
            </form>
        </div>
    </div>
</body>
</html>
