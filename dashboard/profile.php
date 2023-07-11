<?php 
session_start();
include '../koneksi.php';
if (!isset($_SESSION['nama'])) {
  header('Location: ../login.php');
}

// Mendapatkan nilai $nama dari session
$nama = $_SESSION['nama']; 

// Bagian untuk memanggil profile siswa
$query = "SELECT * FROM tbl_siswa WHERE nama='$nama'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Nama dari variable yang di row
$name = $row['nama'];
$email = $row['email'];
$denda = $row['denda'];
$password = $row['password'];

$denda = "Rp" . number_format($denda, 0, ',', '.');

// Bagian untuk mengubah (crud) profile siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $newName = $_POST['name'];
  $newEmail = $_POST['email'];
  $newPassword = $_POST['email'];

  // Periksa apakah nama atau email sudah ada di dalam database
  $checkQuery = "SELECT * FROM tbl_siswa WHERE (nama='$newName' OR email='$newEmail') AND nama!='$nama'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    // Nama atau email sudah ada, berikan pesan gagal
    $error = "<b>Nama atau email sudah digunakan oleh pengguna lain.<b/>";
  } else {
    // Update data profile siswa di database
    $updateQuery = "UPDATE tbl_siswa SET nama='$newName', email='$newEmail', password='$newPassword' WHERE nama='$nama'";
    $updateResult = mysqli_query($conn, $updateQuery);
    // Update nama siswa di table history
    $updateName = "UPDATE tbl_history_peminjaman SET nama_siswa='$newName' WHERE nama_siswa='$nama'";
    $updateRes = mysqli_query($conn, $updateName);
    // Update nama siswa di table peminjaman
    $updateName1 = "UPDATE tbl_peminjaman SET nama_siswa='$newName' WHERE nama_siswa='$nama'";
    $updateRes1 = mysqli_query($conn, $updateName1);

    if ($updateResult) {
      // Update berhasil, update data session dan redirect ke halaman profile
      $_SESSION['nama'] = $newName;
      $_SESSION['email'] = $newEmail;
      $success = "<b>Berhasil mengubah data, silahkan refresh halaman ini.</b>";
    } else {
      // Update gagal
      $error = "Terjadi kesalahan. Silakan coba lagi.";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css" rel="stylesheet">
  <link href="../assets/style.css" rel="stylesheet" type="text/css">
  <title>Siswa Dashboard</title>
</head>
<body class="light-mode">
<?php
    include '../assets/navbar.php';
?>
  <!-- Content area -->
  <div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <!-- Content goes here -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">Berikut Adalah Profile Anda</p>
        </div>
        <div class="border-t border-gray-200">
          <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Nama</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?= $name; ?></dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Email</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?= $email; ?></dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Denda</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
               <font color="red"><?= $denda; ?></font>
               <?php if ($denda != "Rp0") { ?>
              <i><font color="blue"><a href="pembayaran.php">Klik untuk membayar denda</a></font></i>
              <?php } ?>
              </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Ubah Profile</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                <form method="POST">
                  <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" name="name" id="name" class="border-blue-500 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm" value="<?= $name; ?>">
                  </div>
                  <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="border-blue-500 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm" value="<?= $email; ?>">
                  </div>
                  <?php if (isset($error)) { ?>
                    <div class="text-red-500"><?= $error; ?></div>
                  <?php } ?>
                  <?php if (isset($success)) { ?>
                    <div class="text-green-500"><?= $success; ?></div>
                  <?php } ?>
                  <br>
                  <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan</button>
                </form>
              </dd>
            </div>
          </dl>
        </div>    
      </div>
    </div>
  </div>
  
  <script src="../assets/main.js"></script>
</body>
<?php 
    include '../assets/footer.php';
?>
</html>