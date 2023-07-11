<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['nama'])) {
  header('Location: ../login.php');
  exit();
}

// Mendapatkan data dari form pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_SESSION['nama'];
  $judulBuku = $_POST['judul_buku'];
  $jumlahBuku = $_POST['jumlah_buku'];
  $tanggalPengembalian = $_POST['tanggal_pengembalian'];
// Mendapatkan data nama dan judul buku dari table peminjaman
  $queryPeminjaman = "SELECT * FROM tbl_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
  $resultPeminjaman = mysqli_query($conn, $queryPeminjaman);
// Mengambil data data yang berhasil di dapatkan dari table peminjaman
  $rowPeminjaman = mysqli_fetch_assoc($resultPeminjaman);

  // User tidak meminjam buku
  if (!$rowPeminjaman) {
    $errorMessage = "Buku dengan judul $judulBuku tidak ditemukan dalam peminjaman Anda.";
  } else {
    // MEndeklarasikan variable dan mengambil data tanggal peminjaman, total peminjaman, dan tanggal pengembalian
    $tanggalPeminjaman = $rowPeminjaman['tanggal_peminjaman'];
    $totalBukuDipinjam = $rowPeminjaman['total'];
    $tanggalPengembalianSeharusnya = $rowPeminjaman['tanggal_pengembalian'];

    // Mengatur deadline pengembalian
    $tanggalKembali = date_create($tanggalPengembalian);
    $tanggalSeharusnyaKembali = date_create($tanggalPengembalianSeharusnya);
    $selisihHari = date_diff($tanggalKembali, $tanggalSeharusnyaKembali)->format("%a");

  // User telat mengembalikan selama 1 hari terkenda denda 2k berlaku kelipatan
if ($selisihHari > 1) {
  $denda = $selisihHari * 2000;
  $errorMessage = "Anda terlambat mengembalikan buku. Denda yang harus Anda bayar adalah Rp$denda.";
} elseif ($selisihHari < 0) {
  $errorMessage = "Tanggal pengembalian tidak valid.";
} else {
  // Jika berhasil melakukan pengembalian maka akan:
  // Melakukan penghapusan data peminjaman buku yang telah di lakukan oleh user di table peminjaman 
  $queryDeletePeminjaman = "DELETE FROM tbl_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
  mysqli_query($conn, $queryDeletePeminjaman);
  // Melakukan penghapusan data peminjaman buku yang telah di lakukan oleh user di table history peminjaman
  $queryDeleteHistory = "DELETE FROM tbl_history_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
  mysqli_query($conn, $queryDeleteHistory);
  // Menambahkan jumlah buku yang di pinjam oleh user sesuai dengan jumlah yang di kembalikan nya
  $queryUpdateJumlahBuku = "UPDATE tbl_buku SET jumlah = jumlah + $jumlahBuku WHERE judul = '$judulBuku'"; 
  mysqli_query($conn, $queryUpdateJumlahBuku);

  // Berhasil melakukan pengembalian
  $successMessage = "Buku dengan judul $judulBuku berhasil dikembalikan.";
}


  }
}

// Mendapatkan data dari formulir pengembalian
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // ...
  
  $jumlahBuku = $_POST['jumlah_buku'];
  // Filter untuk tidak bisa mengembalikan buku kurang dari 0
  if ($jumlahBuku < 0) {
    $errorMessage = "Jumlah buku yang ingin dikembalikan tidak boleh kurang dari 0.";
    // Filter untuk mengembalikan buku tidak boleh melebihi jumlah buku yang di pinjam
  } elseif ($jumlahBuku > $totalBukuDipinjam) {
    $errorMessage = "Jumlah buku yang ingin dikembalikan melebihi jumlah buku yang dipinjam.";
  } else {
    // Proses pengembalian buku
    if ($jumlahBuku == $totalBukuDipinjam) {
      $queryDeletePeminjaman = "DELETE FROM tbl_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
      mysqli_query($conn, $queryDeletePeminjaman);

      $queryDeleteHistory = "DELETE FROM tbl_history_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
      mysqli_query($conn, $queryDeleteHistory);
    } else {
      $queryUpdatePeminjaman = "UPDATE tbl_peminjaman SET total = total - $jumlahBuku WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
      mysqli_query($conn, $queryUpdatePeminjaman);
    }

    $queryUpdateJumlahBuku = "UPDATE tbl_buku SET jumlah = jumlah + $jumlahBuku WHERE judul = '$judulBuku'";
    mysqli_query($conn, $queryUpdateJumlahBuku);

    $successMessage = "Anda telah mengembalikan $jumlahBuku buku dengan judul $judulBuku.";
  }
}

// Mengambil data nama siswa dari table peminjaman
$queryPeminjamanUser = "";
if (isset($_SESSION['nama'])) {
  $nama = $_SESSION['nama'];
  $queryPeminjamanUser = "SELECT * FROM tbl_peminjaman WHERE nama_siswa = '$nama'";
  $resultPeminjamanUser = mysqli_query($conn, $queryPeminjamanUser);
}

$resultPeminjamanUser = mysqli_query($conn, $queryPeminjamanUser);
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
    <div class="bg-white shadow overflow-hidden sm:rounded-lg.">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Form Pengembalian Buku</h3>
      </div>
      <div class="border-t border-gray-200">
        <form action="" method="POST" class="px-4 py-5 space-y-6 sm:p-6">
          <?php if (isset($errorMessage)): ?>
            <div class="text-red-500"><?php echo $errorMessage; ?></div>
          <?php endif; ?>
          <?php if (isset($successMessage)): ?>
            <div class="text-green-500"><?php echo $successMessage; ?></div>
          <?php endif; ?>
          <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2">
              <label for="judul_buku" class="block text-sm font-medium text-gray-700">Judul Buku</label>
              <select name="judul_buku" id="judul_buku" required
                class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              <option value="" disabled selected>Pilih Judul Buku</option>
            <?php while ($row = mysqli_fetch_assoc($resultPeminjamanUser)): ?>
        <option value="<?php echo $row['judul_buku']; ?>"><?php echo $row['judul_buku']; ?></option>
      <?php endwhile; ?>
    </select>
      </div>
        </div>
        <div class="grid grid-cols-3 gap-6">
           <div class="col-span-3 sm:col-span-2">
            <label for="jumlah_buku" class="block text-sm font-medium text-gray-700">Jumlah Buku yang Dikembalikan</label>
              <input type="number" name="jumlah_buku" id="jumlah_buku" min="0" required
              class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
          </div>
        </div>
          <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2">
              <label for="tanggal_pengembalian" class="block text-sm font-medium text-gray-700">Tanggal Pengembalian</label>
              <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian" required
                     class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
          </div>
          <div class="px-4 py-3 text-right sm:px-6">
            <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              Kembalikan Buku
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
