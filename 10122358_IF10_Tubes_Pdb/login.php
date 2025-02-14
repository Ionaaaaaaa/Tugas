<?php
session_start();
require 'koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Debugging sementara
    // echo "Email: $email, Password: $password <br>";

    // Cek apakah user adalah admin
    $query = "SELECT * FROM admin WHERE email = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        if ($password == $admin['password']) { // Bandingkan langsung karena password tidak di-hash
            $_SESSION['admin'] = $admin['nama'];
            header("Location: dashboard_admin.php");
            exit;
        }
    }

    // Cek apakah user adalah pegawai
    $query = "SELECT * FROM pegawai WHERE email = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pegawai = $result->fetch_assoc();
        if ($password == $pegawai['password']) { // Bandingkan langsung karena password tidak di-hash
            $_SESSION['pegawai'] = $pegawai['nama'];
            header("Location: dashboard_pegawai.php");
            exit;
        }
    }

    // Jika gagal login
    $error = "Email atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
    <div class="bg-white p-8 rounded-xl shadow-md w-96">
        <h2 class="text-2xl font-bold text-center text-gray-700">Login</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center mt-2"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-600">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300" required>
            </div>

            <button type="submit" name="login" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">Login</button>
        </form>
    </div>
</body>
</html>
