<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="w-96 bg-white p-8 rounded-md shadow-lg">
            <center> 
                <h2 class="text-2xl font-bold mb-4">Login</h2>
            </center>
            <form method="POST">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 mb-2">Nama:</label>
                    <input type="nama" name="nama" required class="border border-gray-300 px-3 py-2 rounded-md w-full focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 mb-2">Password:</label>
                    <input type="password" name="password" required class="border border-gray-300 px-3 py-2 rounded-md w-full focus:outline-none focus:border-blue-500">
                </div>
                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </button>
                </div>
            </form>
            <p class="text-gray-700 mt-4">
                Don't have an account? <a href="pendaftaran.php" class="text-blue-500">Register</a>
            </p>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include 'koneksi.php';
$isLoggedIn = isset($_SESSION['nama']);
if ($isLoggedIn) {
    header('Location: dashboard/index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari form login
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Mengecek apakah nama dan password sesuai dengan database
    $query = "SELECT * FROM tbl_siswa WHERE nama = '$nama'";
    $result = mysqli_query($conn, $query);

    // Nama dan passwors sesuai dengan ada yang di database 
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['nama'] = $row['nama']; // Mengeset session nama
            header("Location: dashboard/index.php");
            exit;
        } else {
            // Password salah, berikan pesan kesalahan
            echo "<script>
                    Swal.fire('Error', 'Password salah. Silakan coba lagi.', 'error');
                  </script>";
        }
    } else {
        // Nama tidak ditemukan, berikan pesan kesalahan
        echo "<script>
                Swal.fire('Error', 'Nama tidak ditemukan. Silakan coba lagi.', 'error');
              </script>";
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>