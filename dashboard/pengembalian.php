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
  $tanggalPengembalian = $_POST['tanggal_pengembalian'];
  $jumlahBuku = $_POST['jumlah_buku'];

// Mendapatkan data nama dan judul buku dari table peminjaman
  $queryPeminjaman = "SELECT * FROM tbl_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
  $resultPeminjaman = mysqli_query($conn, $queryPeminjaman);

  // Mengambil data nama dan judul buku dari table peminjaman
  $rowPeminjaman = mysqli_fetch_assoc($resultPeminjaman);

  // User tidak meminjam buku
  if (!$rowPeminjaman) {
    $errorMessage = "Buku dengan judul $judulBuku tidak ditemukan dalam peminjaman Anda.";
  } else {
    // Mendeklarasikan variable dan mengambil data tanggal peminjaman, total peminjaman, dan tanggal pengembalian
    $tanggalPeminjaman = $rowPeminjaman['tanggal_peminjaman'];
    $totalBukuDipinjam = $rowPeminjaman['total'];
    $tanggalPengembalianSeharusnya = $rowPeminjaman['tanggal_pengembalian'];

    // Mengubah data string ke waktu berbentuk object
    $tanggalPengembalian = new DateTime($_POST['tanggal_pengembalian']);
    $tanggalPengembalianSeharusnya = new DateTime($tanggalPengembalianSeharusnya);

     // Memeriksa apakah tanggal pengembalian lebih awal dari tanggal peminjaman
    if ($tanggalPengembalianSeharusnya < $tanggalPeminjaman) {
      $errorMessage = "Tanggal pengembalian tidak valid. Tanggal pengembalian harus setelah tanggal peminjaman.";
    } else {
      // Menghitung perbedaan hari
      $selisih = $tanggalPengembalian->diff($tanggalPengembalianSeharusnya);
      $selisihHari = $selisih->days;
    }
      // User telat mengembalikan selama 1 hari terkenda denda 2k berlaku kelipatan
      if ($tanggalPengembalian > $tanggalPengembalianSeharusnya) {
        $denda = $selisihHari * 2000;
        $dendaMess = "Anda terlambat mengembalikan buku. Denda yang harus Anda bayar adalah Rp$denda.";

        // Menambahkan total denda ke dalam database siswa
        $queryDenda = "UPDATE tbl_siswa SET denda = denda + $denda WHERE nama = '$nama'";
        mysqli_query($conn, $queryDenda);
      }
      elseif ($tanggalPengembalian <= $tanggalPengembalianSeharusnya) {
    }
    // User masih kurang mengembalikan buku
    if ($totalBukuDipinjam != $jumlahBuku) {
      // Kata yang muncul pada saat user kurang mengembalikan buku
      $getData = $totalBukuDipinjam - $jumlahBuku;
      $errorMessage = "Anda masih harus mengembalikan buku sebanyak $getData";

      // Mengupdate total buku yang di pinjam di table peminjaman
        $queryUpdateTbl1 = "UPDATE tbl_peminjaman SET total = total - $jumlahBuku WHERE judul_buku = $judulBuku";
        mysqli_query($conn, $queryUpdateTbl1); 

      // Mengupdate total buku yang di pinjam di table history peminjaman
        $queryUpdateTbl2 = "UPDATE tbl_history_peminjaman SET total = total - $jumlahBuku WHERE judul_buku = $judulBuku";
        mysqli_query($conn, $queryUpdateTbl2); 
    } 
    // User telah mengembalikan seluruh buku
    else {
      // Melakukan penghapusan data peminjaman buku yang telah di lakukan oleh user di table peminjaman 
      $queryDeletePeminjaman = "DELETE FROM tbl_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
      mysqli_query($conn, $queryDeletePeminjaman);

      // Melakukan penghapusan data peminjaman buku yang telah di lakukan oleh user di table history peminjaman 
      $queryDeleteHistory = "DELETE FROM tbl_history_peminjaman WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
      mysqli_query($conn, $queryDeleteHistory);

      $jumlahBuku = $_POST['jumlah_buku'];
      // Menambahkan jumlah buku yang di pinjam oleh user sesuai dengan jumlah yang di kembalikan nya
      $queryUpdateJumlahBuku = "UPDATE tbl_buku SET jumlah = jumlah + $jumlahBuku WHERE judul = '$judulBuku'";
      mysqli_query($conn, $queryUpdateJumlahBuku);

      $successMessage = "Buku dengan judul $judulBuku berhasil dikembalikan.";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $jumlahBuku = $_POST['jumlah_buku'];

  if ($jumlahBuku < 0) {
    $errorMessage = "Jumlah buku yang ingin dikembalikan tidak boleh kurang dari 0.";
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

      $queryUpdatePeminjaman1 = "UPDATE tbl_history_peminjaman SET total = total - $jumlahBuku WHERE nama_siswa = '$nama' AND judul_buku = '$judulBuku'";
      mysqli_query($conn, $queryUpdatePeminjaman1);

      $jumlahBuku = $_POST['jumlah_buku'];
      // Menambahkan jumlah buku yang di pinjam oleh user sesuai dengan jumlah yang di kembalikan nya
      $queryUpdateJumlahBuku = "UPDATE tbl_buku SET jumlah = jumlah + $jumlahBuku WHERE judul = '$judulBuku'";
      mysqli_query($conn, $queryUpdateJumlahBuku);
    }

    $successMessage = "Anda telah mengembalikan $jumlahBuku buku $judulBuku.";
  }
}

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
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
      <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Pengembalian Buku</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Silakan isi formulir pengembalian buku di bawah ini.</p>
      </div>
      <div class="border-t border-gray-200">
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <form method="POST" class="space-y-8">
          <?php if (isset($errorMessage)): ?>
            <div class="text-red-500"><?php echo $errorMessage; ?></div>
          <?php endif; ?>
          <?php if (isset($dendaMess)): ?>
            <div class="text-red-500"><?php echo $dendaMess; ?></div>
          <?php endif; ?>
          <?php if (isset($successMessage)): ?>
            <div class="text-green-500"><?php echo $successMessage; ?></div>
          <?php endif; ?>
          <?php if (isset($dendaMess1)): ?>
            <div class="text-green-500"><?php echo $dendaMess1; ?></div>
          <?php endif; ?>
          <div class="grid grid-cols-3 gap-6">
            <div class="col-span-3 sm:col-span-2">
            <select name="judul_buku" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Pilih Judul Buku</option>
            <?php while ($row = mysqli_fetch_assoc($resultPeminjamanUser)): ?>
              <option value="<?= $row['judul_buku']; ?>"><?= $row['judul_buku']; ?> (Di pinjam: <?= $row['total']; ?>)</option>
      <?php endwhile; ?>
    </select>
      </div>
        </div>
        <div class="mb-4">
              <label for="buku" class="block text-sm font-medium text-gray-700">Banyak Buku</label>
              <input type="number" name="jumlah_buku" id="jumlah_buku" class="border-blue-500 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm">
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
<script src="../assets/main.js"></script>
</body><br><br>
<?php 
include '../assets/footer.php';
?>
</html>