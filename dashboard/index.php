<?php 
session_start();
include '../koneksi.php';
if (!isset($_SESSION['nama'])) {
  header('Location: ../login.php');
  exit;
}

// Mendapatkan nilai $nama dari session
$nama = $_SESSION['nama']; 

// Mendapatkan data dari table siswa
$totalSiswa = mysqli_query($conn, "SELECT count(*) as totalSiswa FROM tbl_siswa");
$dataSiswa = mysqli_fetch_assoc($totalSiswa);
// Mendapatkan data dari table buku
$totalBuku = mysqli_query($conn, "SELECT count(*) as totalBuku FROM tbl_buku");
$dataBuku = mysqli_fetch_assoc($totalBuku);
// Mendapatkan nama siswa dari table history peminjaman
$queryHistory = "SELECT * FROM tbl_history_peminjaman WHERE nama_siswa = '$nama'";
$resultHistory = mysqli_query($conn, $queryHistory);

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
        <h3 class="text-lg font-medium leading-6 text-gray-900">Dashboard</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Welcome <b><?php echo $nama;?></b> Di Dashboard Siswa</p>
      </div>
      <div class="border-t border-gray-200">
        <dl>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Siswa Terdaftar</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo $dataSiswa['totalSiswa'];?></dd>
          </div>
          <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Total Buku</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo $dataBuku['totalBuku'];?></dd>
          </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">Riwayat Peminjaman</dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Judul Buku
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total Buku
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deadline Pengembalian
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <?php while ($rowHistory = mysqli_fetch_assoc($resultHistory)) { ?>
                      <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900"><?php echo $rowHistory['judul_buku']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900"><?php echo $rowHistory['total']; ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm text-gray-900"><?php echo $rowHistory['tanggal_pengembalian']; ?></div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <br><br>
              </div>
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
