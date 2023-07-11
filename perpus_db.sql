-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2023 at 08:31 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpus_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buku`
--

CREATE TABLE `tbl_buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `jumlah` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_buku`
--

INSERT INTO `tbl_buku` (`id`, `judul`, `penulis`, `jumlah`) VALUES
(1, 'Misteri Alam Semesta', 'Saragih', '913'),
(2, 'Cewek Gen-Z', 'Bayu Candra', '1000'),
(3, 'Bahasa Pemrograman Python', 'Gress', '998'),
(4, 'Kunci Jawaban UTBK', 'Gress', '990'),
(5, 'Kode Keras Cewek', 'Bayu', '998'),
(6, 'Cara Menjadi Anime', 'Bayu', '995');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history_peminjaman`
--

CREATE TABLE `tbl_history_peminjaman` (
  `id` int(11) NOT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `total` int(11) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_history_peminjaman`
--

INSERT INTO `tbl_history_peminjaman` (`id`, `nama_siswa`, `judul_buku`, `total`, `tanggal_peminjaman`, `tanggal_pengembalian`) VALUES
(18, 'Zee', 'Kunci Jawaban UTBK', 2, '2023-07-02', '2023-07-17'),
(56, 'Michie', 'Kunci Jawaban UTBK', 4, '2023-07-03', '2023-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_peminjaman`
--

CREATE TABLE `tbl_peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `tanggal_peminjaman` date NOT NULL,
  `tanggal_pengembalian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_peminjaman`
--

INSERT INTO `tbl_peminjaman` (`id_peminjaman`, `nama_siswa`, `judul_buku`, `total`, `tanggal_peminjaman`, `tanggal_pengembalian`) VALUES
(27, 'Zee', 'Kunci Jawaban UTBK', '2', '2023-07-02', '2023-07-17'),
(64, 'Michie', 'Kunci Jawaban UTBK', '4', '2023-07-03', '2023-07-10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengembalian`
--

CREATE TABLE `tbl_pengembalian` (
  `id_pengembalian` int(11) NOT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `denda` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `denda` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id`, `nama`, `password`, `email`, `denda`) VALUES
(10, 'Nasyah', '$2y$10$D60HXDoZGvyufRBOFTJaGu8kgc1T3B4Hs0OE2CqQOUJj7hUnJ1tHO', 'nasyah@gmail.com', 0),
(11, 'Nasyah Pratiwi', '$2y$10$qpgyibayRFYn3HePVROjUOz0GmTurVrCRPO1HqyKgoEI2oFanRCXC', 'nasyah@gmail.com', 0),
(13, 'wisnu', '$2y$10$4pfZ3K7A3r4e3BK0yqXNAOILjkxInFTgGewauX76nMr92b0d1PpYO', 'wisnu@gmail.com', 0),
(14, 'Bayu', '$2y$10$8ZpKx.HTfVAKMlKytcTEneb0eGESs5tHpGmulBPlCECP3oxZ3T3.e', 'bayugans@gmail.com', 0),
(19, 'Nanda', '$2y$10$Bq/Uu5CVr1Z1ZWGTgSgu5.1pvlzjnp7shrQXnko5YXzqSD4rR1zvK', 'dwinanda@gmail.com', 0),
(20, 'ayam', '$2y$10$x9EGR8u0UsGghhINz2ver.Uy0M4mZE7SO5SaI6v0OGqA4jla.K8wC', 'ayamsyr@gmail.com', 0),
(21, 'skini', '$2y$10$or2LXlp6cgItjqipGzHkvOt7pa46x1VfyxcO/DVgrCMdgVmfnVtKW', 'skini@gmail.com', 0),
(22, 'wawa', '$2y$10$DX/gJvz91VjHESgxx08vyuXQRzcpBzsnU9KgM2/EiJUH8dHEXQnDC', 'wawa@gmail.com', 0),
(24, 'Mathca', '$2y$10$Rs.USgfSqbiCh/vh2ZYY2ubIDa/i5DFjg/Sls73Urv5pNJKcU7r7K', 'adel123@gmail.com', 0),
(27, 'Nakano Miku', 'nakanomiku@gmail.com', 'nakanomiku@gmail.com', 0),
(28, 'Nakano', 'nakano@gmail.com', 'nakano@gmail.com', -32000),
(29, 'Voldigoad', '$2y$10$n/AcSw4/HSP57YSg/bMrE.kFOfmR3qXx/QkNq24UiaZszPq8lgPrC', 'voldigoad@gmail.com', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_history_peminjaman`
--
ALTER TABLE `tbl_history_peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_buku`
--
ALTER TABLE `tbl_buku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_history_peminjaman`
--
ALTER TABLE `tbl_history_peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_peminjaman`
--
ALTER TABLE `tbl_peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_pengembalian`
--
ALTER TABLE `tbl_pengembalian`
  ADD CONSTRAINT `tbl_pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `tbl_peminjaman` (`id_peminjaman`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
