<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Ambil daftar shift dari database
$query = "SELECT * FROM shift";
$shift_result = $koneksi->query($query);
$shifts = [];
while ($shift = $shift_result->fetch_assoc()) {
    $shifts[] = $shift;
}

// Inisialisasi pesan error
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Tidak di-hash
    $jabatan = $_POST['jabatan'];

    // Cek apakah email sudah terdaftar
    $cek_email_query = "SELECT * FROM pegawai WHERE email = '$email'";
    $cek_email_result = $koneksi->query($cek_email_query);
    
    if ($cek_email_result->num_rows > 0) {
        $error = "Email sudah terdaftar! Gunakan email lain.";
    } else {
        // Insert pegawai ke database
        $query = "INSERT INTO pegawai (nama, email, password, jabatan) VALUES ('$nama', '$email', '$password', '$jabatan')";
        if ($koneksi->query($query) === TRUE) {
            $id_pegawai = $koneksi->insert_id; // Ambil ID pegawai yang baru dibuat

            // Simpan jadwal kerja pegawai
            if (!empty($_POST['jadwal'])) {
                foreach ($_POST['jadwal'] as $hari => $shift_ids) {
                    foreach ($shift_ids as $id_shift) {
                        $query = "INSERT INTO jadwal_shift (id_pegawai, hari, id_shift) VALUES ('$id_pegawai', '$hari', '$id_shift')";
                        $koneksi->query($query);
                    }
                }
            }

            echo "<script>
                    alert('Pegawai berhasil ditambahkan!');
                    window.location.href = 'dashboard_admin.php';
                  </script>";
        } else {
            $error = "Terjadi kesalahan! Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pegawai</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">PT. Sukasari</h1>
            <a href="logout.php" class="bg-red-500 px-4 py-2 rounded-md hover:bg-red-600 transition">Logout</a>
        </div>
    </nav>

    <div class="flex justify-center items-center py-10">
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-3xl">
            <h2 class="text-2xl font-bold text-gray-700 text-center">Tambah Pegawai</h2>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (!empty($error)): ?>
                <div class="bg-red-200 text-red-700 p-3 rounded-md mb-4 text-center">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                
                <!-- Input Nama -->
                <div class="mt-4">
                    <label class="block font-semibold">Nama:</label>
                    <input type="text" name="nama" required class="w-full border p-2 rounded">
                </div>

                <!-- Input Email -->
                <div class="mt-4">
                    <label class="block font-semibold">Email:</label>
                    <input type="email" name="email" required class="w-full border p-2 rounded">
                </div>

                <!-- Input Password -->
                <div class="mt-4">
                    <label class="block font-semibold">Password:</label>
                    <input type="text" name="password" required class="w-full border p-2 rounded">
                </div>

                <!-- Input Jabatan -->
                <div class="mt-4">
                    <label class="block font-semibold">Jabatan:</label>
                    <input type="text" name="jabatan" required class="w-full border p-2 rounded">
                </div>

                <!-- Pilihan Jadwal Kerja -->
                <h3 class="text-xl font-bold text-gray-600 mt-6">Jadwal Kerja</h3>
                <div class="overflow-x-auto">
                    <table class="w-full mt-2 border border-gray-300">
                        <thead>
                            <tr class="bg-blue-500 text-white">
                                <th class="border border-gray-300 p-2">Shift / Hari</th>
                                <?php
                                $hari_list = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                foreach ($hari_list as $hari) {
                                    echo "<th class='border border-gray-300 p-2'>$hari</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shifts as $shift): ?>
                                <tr class="bg-white hover:bg-gray-100 text-center">
                                    <td class="border border-gray-300 p-2 font-bold"><?php echo $shift['nama_shift']; ?><br>
                                        <span class="text-sm text-gray-600">(<?php echo $shift['jam_mulai'] . " - " . $shift['jam_selesai']; ?>)</span>
                                    </td>
                                    <?php foreach ($hari_list as $hari): ?>
                                        <td class="border border-gray-300 p-2">
                                            <input type="checkbox" name="jadwal[<?php echo $hari; ?>][]" value="<?php echo $shift['id_shift']; ?>" class="w-5 h-5 text-blue-500">
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex justify-between">
                    <a href="dashboard_admin.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
