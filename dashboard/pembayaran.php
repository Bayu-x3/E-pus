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

$dendaFormatted = "Rp" . number_format($denda, 0, ',', '.'); // Formatted denda value with currency symbol and separators

// Bagian untuk mengupdate (crud) pembayaran denda siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $bayarDenda = $_POST['bayar_denda'];

  // Remove the currency symbol and any non-numeric characters from the input
  $bayarDenda = preg_replace("/[^0-9]/", "", $bayarDenda);

  // Remove the currency symbol and thousand separators from the formatted denda value
  $dendaNumber = preg_replace("/[^0-9]/", "", $denda);

  // Validasi inputan jumlah pembayaran
  if (empty($bayarDenda) || $bayarDenda <= 0) {
    $error = "<b>Jumlah pembayaran tidak valid.<b/>";
  } elseif ($bayarDenda > $dendaNumber) {
    $error = "<b>Jumlah pembayaran melebihi total denda yang Anda miliki.<b/>";
  } else {
    // Mengurangi denda sesuai dengan pembayaran
    $newDenda = $dendaNumber - $bayarDenda;

    // Update data denda siswa di database
    $updateQuery = "UPDATE tbl_siswa SET denda=$newDenda WHERE nama='$nama'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
      // Update berhasil, refresh halaman ini
      $success = "<b>Anda telah berhasil membayar denda sebesar $bayarDenda.</b>";
      $dendaFormatted = "Rp" . number_format($newDenda, 0, ',', '.'); // Update the formatted denda value
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
  <title>Pembayaran Denda</title>
  <script>
    function formatRupiah(angka) {
      var formatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
      });

      return formatter.format(angka);
    }

    function convertToRupiah(input) {
      var value = input.value;
      var number = value.replace(/[^0-9]/g, '');
      input.value = formatRupiah(number);
    }
  </script>
</head>
<body class="light-mode">
<?php
include '../assets/navbar.php';
?><br>
<!-- Content area -->
<div class="py-10">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <!-- Content goes here -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Pembayaran Denda</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Anda memiliki denda sebesar <?= $dendaFormatted; ?></p>
      </div>
      <div class="border-t border-gray-200">
        <form method="POST" class="px-4 py-5 sm:p-6">
          <div class="mb-4">
            <label for="bayar_denda" class="block text-sm font-medium text-gray-700">Jumlah Pembayaran</label>
            <input type="text" name="bayar_denda" id="bayar_denda" onkeyup="convertToRupiah(this)" class="border-blue-500 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
          </div>
          <?php if (isset($error)) { ?>
            <div class="text-red-500"><?= $error; ?></div>
          <?php } ?>
          <?php if (isset($success)) { ?>
            <div class="text-green-500"><?= $success; ?></div>
          <?php } ?>
          <br>
          <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Bayar Denda</button>
        </form>
      </div>
    </div>
  </div>
</div>
<br><br><br>
<script src="../assets/main.js"></script>
</body>
<?php 
include '../assets/footer.php';
?>
</html>
