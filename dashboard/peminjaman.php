<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['nama'])) {
  header('Location: ../login.php');
  exit();
}

// Mendapatkan data dari form peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_SESSION['nama'];
  $judulBuku = $_POST['judul_buku'];
  $banyakBuku = $_POST['buku'];
  $tanggalPinjam = $_POST['tanggal_pinjam'];
  $tanggalKembali = $_POST['tanggal_kembali'];

  // Mendapatkan data buku berdasarkan judul
  $query = "SELECT * FROM tbl_buku WHERE judul='$judulBuku'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  // Jika buku tidak ada
  if (!$row) {
    $errorMessage = "Buku tidak ditemukan";
  } else {
    // Mendapatkan data berapa banyak jumlah buku yang ada di database
    $stok = $row['jumlah'];
    // Jika stok buku di dalam database lebih dari 0 
    if ($stok > 0) {
      // Jika user meminjam lebih dari 36 buku 
      if ($banyakBuku > 36) {
        $errorMessage = "Maksimal peminjaman buku adalah 36";
      } else if ($stok < $banyakBuku) {
        // Jika user meminjam buku melebihi stok yang tersedia
        $errorMessage = "Stok buku tidak cukup";
      } // Mendapatkan data dari form peminjaman
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = $_SESSION['nama'];
        $judulBuku = $_POST['judul_buku'];
        $banyakBuku = $_POST['buku'];
        $tanggalPinjam = $_POST['tanggal_pinjam'];
        $tanggalKembali = $_POST['tanggal_kembali'];
      
        // Mendapatkan data buku berdasarkan judul
        $query = "SELECT * FROM tbl_peminjaman WHERE nama_siswa='$nama' AND judul_buku='$judulBuku'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
      
        if ($row) {
          // Jika pengguna telah meminjam buku dengan judul yang sama sebelumnya, update jumlah buku yang dipinjam
          $totalBuku = $row['total'] + $banyakBuku;
          $queryUpdate = "UPDATE tbl_peminjaman SET total=$totalBuku WHERE nama_siswa='$nama' AND judul_buku='$judulBuku'";
          mysqli_query($conn, $queryUpdate);

          $queryUpdate1 = "UPDATE tbl_history_peminjaman SET total=$totalBuku WHERE nama_siswa='$nama' AND judul_buku='$judulBuku'";
          mysqli_query($conn, $queryUpdate1);
      
          // Update stok buku
          $newStok = $stok - $banyakBuku;
          $queryUpdateBuku = "UPDATE tbl_buku SET jumlah=$newStok WHERE judul='$judulBuku'";
          mysqli_query($conn, $queryUpdateBuku);
      
          // Berhasil memperbarui jumlah buku yang dipinjam
          $successMessage = "Berhasil memperbarui peminjaman buku $judulBuku. Total buku yang dipinjam: $totalBuku";
        } else {
          $queryInsert = "INSERT INTO tbl_peminjaman (nama_siswa, judul_buku, total, tanggal_peminjaman, tanggal_pengembalian) VALUES ('$nama', '$judulBuku', '$banyakBuku', '$tanggalPinjam', '$tanggalKembali')";
              $queryInsert2 = "INSERT INTO tbl_history_peminjaman (nama_siswa, judul_buku, total, tanggal_peminjaman, tanggal_pengembalian) VALUES ('$nama', '$judulBuku', '$banyakBuku', '$tanggalPinjam', '$tanggalKembali')";
              mysqli_query($conn, $queryInsert);
              mysqli_query($conn, $queryInsert2);
      
              // Update stok buku
              $newStok = $stok - $banyakBuku;
              $queryUpdate = "UPDATE tbl_buku SET jumlah=$newStok WHERE judul='$judulBuku'";
              mysqli_query($conn, $queryUpdate);
              // Berhasil meminjam buku
              $successMessage = "Berhasil meminjam buku $judulBuku sebanyak $banyakBuku";
        }
      }      
    } else {
      // Jika stok buku tidak ada di dalam database
      $errorMessage = "Stok buku habis";
    }
  }
}

// Mengambil data dari table buku
$query1 = "SELECT * FROM tbl_buku";
$result1 = mysqli_query($conn, $query1);
?>

<!-- Tampilan HTML/Formulir -->
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
        <h3 class="text-lg font-medium leading-6 text-gray-900">Peminjaman Buku</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Silakan isi formulir peminjaman buku di bawah ini.</p>
        <b><p class="mt-1 max-w-2xl text-sm text-gray-500">Jika kamu telat mengembalikan buku selama 1 hari dari tanggal pengembalian yang kamu ajukan, maka akan di kenakan denda sebesar Rp 2.000 berlaku kelipatan!!.</p><b>
      </div>
      <div class="border-t border-gray-200">
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <form method="POST" class="space-y-8">
            <div class="inline-block relative w-64">
              <select name="judul_buku" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Pilih Judul Buku</option>
                <?php while ($row1 = mysqli_fetch_assoc($result1)) { ?>
                  <option value="<?= $row1['judul']; ?>"><?= $row1['judul']; ?> (Stok: <?= $row1['jumlah']; ?>)</option>
                <?php } ?>
              </select>
              <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
              </div>
            </div>
            <div class="mb-4">
              <label for="buku" class="block text-sm font-medium text-gray-700">Banyak Buku</label>
              <input type="number" name="buku" id="buku" class="border-blue-500 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
            </div>
            <div>
              <label for="borrow_date" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
              <div class="mt-1">
                <input type="date" name="tanggal_pinjam" id="borrow_date" class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
            </div>
            <div>
              <label for="return_date" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
              <div class="mt-1">
                <input type="date" name="tanggal_kembali" id="return_date" class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
              </div>
            </div>
            <?php if (isset($successMessage)) { ?>
              <div class="text-green-500"><?= $successMessage; ?></div>
            <?php } ?>
            <?php if (isset($errorMessage)) { ?>
              <div class="text-red-500"><?= $errorMessage; ?></div>
            <?php } ?>
            <div>
              <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Submit</button>
            </div>
          </form>
        </div>
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