<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mendapatkan data dari form pendaftaran
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    // Filter jika nama sudah ada dalam database
    $query = "SELECT * FROM tbl_siswa WHERE nama = '$nama'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Nama yang sudah ada dalam database, berikan pesan kesalahan
        echo "<script>
                swal('Error', 'Nama sudah terdaftar. Silakan gunakan nama lain.', 'error');
                window.location.href = 'pendaftaran.php';
              </script>";
    } else {
        // Nama yang belum terdaftar, lakukan pendaftaran
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO tbl_siswa (nama, email, password) VALUES ('$nama', '$email', '$password')";
        
        if (mysqli_query($conn, $query)) {
            // Pendaftaran berhasil
            echo "<script>
                    swal('Sukses', 'Pendaftaran berhasil!', 'success');
                  </script>";
        } else {
            // Pendaftaran gagal
            echo "<script>
                    swal('Error', 'Pendaftaran gagal. Silakan coba lagi.', 'error');
                  </script>";
        }
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
   </head>
<body class="bg-gray-100">
    <div class="flex justify-center items-center h-screen">
        <div class="w-96 bg-white p-8 rounded-md shadow-lg">
         <center> 
            <h2 class="text-2xl font-bold mb-4">Pendaftaran Siswa</h2></center>
            <form method="POST">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 mb-2">Nama Lengkap:</label>
                    <input type="text" name="nama" required class="border border-gray-300 px-3 py-2 rounded-md w-full focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 mb-2">Email:</label>
                    <input type="email" name="email" required class="border border-gray-300 px-3 py-2 rounded-md w-full focus:outline-none focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 mb-2">Password:</label>
                    <input type="password" name="password" required class="border border-gray-300 px-3 py-2 rounded-md w-full focus:outline-none focus:border-blue-500">
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <i class="fas fa-check-circle mr-2"></i> Daftar
                     </button>
                </div>
            </form>
            <p class="text-gray-700 mt-4">
                Have an account? <a href="login.php" class="text-blue-500">Login</a>
            </p>
        </div>
    </div>
</body>
</html>