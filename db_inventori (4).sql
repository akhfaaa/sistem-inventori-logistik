-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2026 pada 11.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventori`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_barang`
--

CREATE TABLE `tb_barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(150) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `harga_beli` decimal(15,2) NOT NULL,
  `stok_aktual` int(11) NOT NULL DEFAULT 0,
  `stok_minimum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_barang`
--

INSERT INTO `tb_barang` (`id_barang`, `kode_barang`, `nama_barang`, `id_kategori`, `id_rak`, `harga_beli`, `stok_aktual`, `stok_minimum`) VALUES
(1, 'SKU-098', 'Spark', 2, 1, 50000.00, 100, 10),
(2, 'SKU-097', 'Fuel Pump', 2, 2, 200000.00, 50, 10),
(3, 'SKU-099', 'Dry Clutch', 2, NULL, 999984.00, 25, 10),
(4, 'SKU-096', 'Disc Brake', 2, NULL, 50000.00, 50, 10),
(5, 'SKU-095', 'Rear Gear', 2, NULL, 60000.00, 60, 10),
(6, 'SKU-094', 'Air Filter', 2, NULL, 20000.00, 13, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(150) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_customer`
--

INSERT INTO `tb_customer` (`id_customer`, `nama_customer`, `kontak`, `alamat`) VALUES
(1, 'Subbagian Tata Usaha', '0811223344', 'Banjarmasin Tengah'),
(2, 'Seksi Penyelenggaraan', '0811556677', 'Banjarmasin Utara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Bahan Habis Pakai', 'Barang konsumabel harian'),
(2, 'Suku Cadang', 'Komponen perbaikan mesin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_keluar`
--

CREATE TABLE `tb_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `qty_keluar` int(11) NOT NULL,
  `tanggal_keluar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_keluar`
--

INSERT INTO `tb_keluar` (`id_keluar`, `id_barang`, `id_customer`, `id_user`, `qty_keluar`, `tanggal_keluar`) VALUES
(1, 1, 1, 1, 10, '2026-04-19 11:18:03'),
(2, 2, 2, 1, 10, '2026-04-19 11:26:45'),
(3, 3, 2, 1, 5, '2026-04-19 11:26:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_klaster_kmeans`
--

CREATE TABLE `tb_klaster_kmeans` (
  `id_klaster` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `velocity_score` decimal(10,2) NOT NULL,
  `label_klaster` enum('Fast Moving','Slow Moving','Dead Stock') NOT NULL,
  `terakhir_diupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_klaster_kmeans`
--

INSERT INTO `tb_klaster_kmeans` (`id_klaster`, `id_barang`, `velocity_score`, `label_klaster`, `terakhir_diupdate`) VALUES
(7, 2, 80.00, 'Fast Moving', '2026-04-25 20:29:42'),
(8, 3, 100.00, 'Fast Moving', '2026-04-25 20:29:42'),
(9, 1, 70.00, 'Slow Moving', '2026-04-25 20:29:42'),
(10, 4, 0.00, 'Dead Stock', '2026-04-25 20:29:42'),
(11, 5, 0.00, 'Dead Stock', '2026-04-25 20:29:42'),
(12, 6, 0.00, 'Dead Stock', '2026-04-25 20:29:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_log_aktivitas`
--

CREATE TABLE `tb_log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `modul` varchar(50) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_log_aktivitas`
--

INSERT INTO `tb_log_aktivitas` (`id_log`, `id_user`, `aksi`, `modul`, `waktu`) VALUES
(1, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 09:48:50'),
(2, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-19 09:49:26'),
(3, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 10:00:13'),
(4, 1, 'Menambah stok barang ID: 6 sebanyak 11', 'Inbound', '2026-04-19 10:17:28'),
(5, 1, 'Input Retur: Spark (1 unit) - Musnahkan', 'Retur', '2026-04-19 12:21:57'),
(6, 1, 'Mendaftarkan akun baru: andi (Staff)', 'User Admin', '2026-04-19 12:31:50'),
(7, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:42:52'),
(8, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:44:53'),
(9, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:45:09'),
(10, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:45:15'),
(11, 1, 'Mendaftarkan akun baru: budi (Kasir)', 'User Admin', '2026-04-19 12:45:49'),
(12, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:45:52'),
(13, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:45:59'),
(14, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:46:14'),
(15, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:46:21'),
(16, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:46:34'),
(17, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:46:41'),
(18, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:47:03'),
(19, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:47:12'),
(20, 3, 'Input Retur: Air Filter (2 unit) - Kembali ke Stok', 'Retur', '2026-04-19 12:47:36'),
(21, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-19 12:47:43'),
(22, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 12:47:49'),
(23, 1, 'Mendaftarkan akun baru: daffa (Admin)', 'User Admin', '2026-04-19 13:42:07'),
(24, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-19 13:42:11'),
(25, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 13:42:17'),
(26, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-19 13:56:43'),
(27, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-19 13:56:50'),
(28, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-20 00:13:21'),
(29, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-20 00:14:06'),
(30, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-20 02:41:57'),
(31, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-20 05:17:09'),
(32, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-21 03:35:39'),
(33, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 10:56:26'),
(34, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 12:47:25'),
(35, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 12:47:31'),
(36, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 12:47:59'),
(37, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 12:48:06'),
(38, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 12:48:15'),
(39, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 12:48:21'),
(40, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 12:49:28'),
(41, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 12:49:36'),
(42, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 12:51:32'),
(43, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 12:51:37'),
(44, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:02:43'),
(45, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:02:51'),
(46, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:03:41'),
(47, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:03:50'),
(48, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:04:50'),
(49, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:04:57'),
(50, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:05:46'),
(51, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:05:57'),
(52, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:24:33'),
(53, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:24:44'),
(54, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:25:10'),
(55, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:25:27'),
(56, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:25:39'),
(57, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:25:46'),
(58, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:26:16'),
(59, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:26:24'),
(60, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:32:05'),
(61, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:34:20'),
(62, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:35:54'),
(63, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:36:51'),
(64, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:38:11'),
(65, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:39:11'),
(66, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:39:17'),
(67, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:39:23'),
(68, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:39:33'),
(69, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:39:40'),
(70, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:40:03'),
(71, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:40:10'),
(72, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 13:40:15'),
(73, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 13:40:23'),
(74, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 14:04:27'),
(75, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 14:04:45'),
(76, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 14:04:50'),
(77, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 14:09:23'),
(78, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 14:09:36'),
(79, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 14:11:40'),
(80, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 14:24:19'),
(81, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 14:26:40'),
(82, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 14:26:49'),
(83, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:04:09'),
(84, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:07:16'),
(85, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:07:23'),
(86, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:13:59'),
(87, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:14:06'),
(88, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:26:30'),
(89, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:26:41'),
(90, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:28:14'),
(91, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:28:22'),
(92, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:29:15'),
(93, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:29:22'),
(94, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:32:14'),
(95, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:32:22'),
(96, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:32:37'),
(97, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:35:13'),
(98, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:35:25'),
(99, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:37:49'),
(100, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:38:22'),
(101, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:38:30'),
(102, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:39:16'),
(103, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:39:42'),
(104, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:41:31'),
(105, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:41:38'),
(106, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:41:45'),
(107, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:42:56'),
(108, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:43:04'),
(109, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:43:19'),
(110, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:43:29'),
(111, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:46:25'),
(112, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:46:31'),
(113, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:47:13'),
(114, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:50:35'),
(115, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:50:41'),
(116, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:51:23'),
(117, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:51:31'),
(118, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:52:00'),
(119, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:52:08'),
(120, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:57:44'),
(121, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:57:58'),
(122, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 16:59:40'),
(123, 2, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 16:59:46'),
(124, 2, 'User logout dari sistem', 'Autentikasi', '2026-04-25 17:00:38'),
(125, 3, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 17:00:45'),
(126, 3, 'User logout dari sistem', 'Autentikasi', '2026-04-25 17:01:15'),
(127, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 17:01:22'),
(128, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 17:11:39'),
(129, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 17:15:27'),
(130, 4, 'Memperbarui data kredensial: kabalai', 'User Admin', '2026-04-25 17:20:39'),
(131, 4, 'Memperbarui data kredensial: kasubbag', 'User Admin', '2026-04-25 17:22:29'),
(132, 4, 'Memperbarui data kredensial: staff', 'User Admin', '2026-04-25 17:25:17'),
(133, 4, 'Memperbarui data kredensial: admin', 'User Admin', '2026-04-25 17:26:24'),
(134, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 17:44:57'),
(135, 1, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 17:45:09'),
(136, 1, 'User logout dari sistem', 'Autentikasi', '2026-04-25 17:53:07'),
(137, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 17:53:18'),
(138, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-25 20:05:50'),
(139, 4, 'Menjalankan ulang algoritma RFM & K-Means', 'Spatial Intelligence', '2026-04-25 20:29:42'),
(140, 4, 'User logout dari sistem', 'Autentikasi', '2026-04-25 20:52:48'),
(141, 4, 'User login ke dalam sistem', 'Autentikasi', '2026-04-26 08:19:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_masuk`
--

CREATE TABLE `tb_masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `qty_masuk` int(11) NOT NULL,
  `tanggal_masuk` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_masuk`
--

INSERT INTO `tb_masuk` (`id_masuk`, `id_barang`, `id_supplier`, `id_user`, `qty_masuk`, `tanggal_masuk`) VALUES
(2, 1, 1, 1, 10, '2026-04-19 11:03:22'),
(3, 2, 1, 1, 10, '2026-04-19 11:25:43'),
(4, 3, 1, 1, 10, '2026-04-19 11:25:56'),
(5, 4, 2, 1, 10, '2026-04-19 11:26:15'),
(6, 5, 2, 1, 10, '2026-04-19 11:26:24'),
(7, 6, 2, 1, 11, '2026-04-19 18:17:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_nilai_supplier`
--

CREATE TABLE `tb_nilai_supplier` (
  `id_supplier` int(11) NOT NULL,
  `c1_harga` int(11) NOT NULL COMMENT 'Cost (Semakin murah semakin baik)',
  `c2_kecepatan` int(11) NOT NULL COMMENT 'Benefit (Skala 1-100)',
  `c3_kualitas` int(11) NOT NULL COMMENT 'Benefit (Skala 1-100)',
  `c4_jarak` int(11) NOT NULL COMMENT 'Cost (Dalam Kilometer)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_nilai_supplier`
--

INSERT INTO `tb_nilai_supplier` (`id_supplier`, `c1_harga`, `c2_kecepatan`, `c3_kualitas`, `c4_jarak`) VALUES
(1, 150000, 80, 85, 12),
(2, 140000, 70, 80, 25),
(3, 160000, 95, 90, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rak`
--

CREATE TABLE `tb_rak` (
  `id_rak` int(11) NOT NULL,
  `nama_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_rak`
--

INSERT INTO `tb_rak` (`id_rak`, `nama_rak`, `lokasi`) VALUES
(1, 'RAK-A1', 'Lantai 1 Sayap Barat'),
(2, 'RAK-B2', 'Lantai 2 Sayap Timur');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rak_gudang`
--

CREATE TABLE `tb_rak_gudang` (
  `id_rak` int(11) NOT NULL,
  `kode_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_retur`
--

CREATE TABLE `tb_retur` (
  `id_retur` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `aksi_stok` enum('Kembali ke Stok','Musnahkan') NOT NULL,
  `tanggal_retur` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_retur`
--

INSERT INTO `tb_retur` (`id_retur`, `id_barang`, `qty_retur`, `alasan`, `aksi_stok`, `tanggal_retur`) VALUES
(1, 1, 1, 'Barang Cacat', 'Musnahkan', '2026-04-19 12:21:57'),
(2, 6, 2, 'salah kirim', 'Kembali ke Stok', '2026-04-19 12:47:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_retur_keluar`
--

CREATE TABLE `tb_retur_keluar` (
  `id_retur_keluar` int(11) NOT NULL,
  `id_keluar` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_retur` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_retur_masuk`
--

CREATE TABLE `tb_retur_masuk` (
  `id_retur_masuk` int(11) NOT NULL,
  `id_masuk` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_retur` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(150) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_supplier`, `nama_supplier`, `kontak`, `alamat`) VALUES
(1, 'PT. Logistik Jaya', '0812345678', 'Jakarta'),
(2, 'CV. Sumber Makmur', '0852998877', 'Surabaya');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Kepala Balai','Kasubbag','Staff') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Heru Kurniawan, S.Pd., M.T.', 'kabalai', '$2y$10$dn/zb3kMuSyhG9jaSGoUp.0JBSHCgo2N17uHqRPuQBrdv5boB8ASO', 'Kepala Balai', '2026-04-19 03:02:54'),
(2, 'Dewi Ramadhiani, S.Psi.', 'kasubbag', '$2y$10$xWZeAmRLmQ4kO1bZJuGsYuPQWwDiHrurS2j979mjrylRcz7EBfMti', 'Kasubbag', '2026-04-19 12:31:50'),
(3, 'Kusworo, A.Md', 'staff', '$2y$10$rbf3EUSKbtKHnKDznjPFduUi33gDKOux7kClvXCVMqbdgWojM03/O', 'Staff', '2026-04-19 12:45:49'),
(4, 'Akhmad Daffa Hambali, S.Kom., M.T.', 'admin', '$2y$10$59X3yteL7SEx79ROuKzQZ.ps01yqPLgiW6WH1MZyUp852ziJpoB2W', 'Administrator', '2026-04-19 13:42:07');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `fk_barang_rak` (`id_rak`);

--
-- Indeks untuk tabel `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_keluar`
--
ALTER TABLE `tb_keluar`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `tb_keluar_ibfk_3` (`id_user`);

--
-- Indeks untuk tabel `tb_klaster_kmeans`
--
ALTER TABLE `tb_klaster_kmeans`
  ADD PRIMARY KEY (`id_klaster`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_log_aktivitas_ibfk_1` (`id_user`);

--
-- Indeks untuk tabel `tb_masuk`
--
ALTER TABLE `tb_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `tb_masuk_ibfk_3` (`id_user`);

--
-- Indeks untuk tabel `tb_nilai_supplier`
--
ALTER TABLE `tb_nilai_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tb_rak`
--
ALTER TABLE `tb_rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indeks untuk tabel `tb_rak_gudang`
--
ALTER TABLE `tb_rak_gudang`
  ADD PRIMARY KEY (`id_rak`),
  ADD UNIQUE KEY `kode_rak` (`kode_rak`);

--
-- Indeks untuk tabel `tb_retur`
--
ALTER TABLE `tb_retur`
  ADD PRIMARY KEY (`id_retur`);

--
-- Indeks untuk tabel `tb_retur_keluar`
--
ALTER TABLE `tb_retur_keluar`
  ADD PRIMARY KEY (`id_retur_keluar`),
  ADD KEY `id_keluar` (`id_keluar`);

--
-- Indeks untuk tabel `tb_retur_masuk`
--
ALTER TABLE `tb_retur_masuk`
  ADD PRIMARY KEY (`id_retur_masuk`),
  ADD KEY `id_masuk` (`id_masuk`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_customer`
--
ALTER TABLE `tb_customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_keluar`
--
ALTER TABLE `tb_keluar`
  MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_klaster_kmeans`
--
ALTER TABLE `tb_klaster_kmeans`
  MODIFY `id_klaster` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT untuk tabel `tb_masuk`
--
ALTER TABLE `tb_masuk`
  MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_rak`
--
ALTER TABLE `tb_rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_rak_gudang`
--
ALTER TABLE `tb_rak_gudang`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_retur`
--
ALTER TABLE `tb_retur`
  MODIFY `id_retur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_retur_keluar`
--
ALTER TABLE `tb_retur_keluar`
  MODIFY `id_retur_keluar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_retur_masuk`
--
ALTER TABLE `tb_retur_masuk`
  MODIFY `id_retur_masuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_barang`
--
ALTER TABLE `tb_barang`
  ADD CONSTRAINT `fk_barang_rak` FOREIGN KEY (`id_rak`) REFERENCES `tb_rak` (`id_rak`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `tb_keluar`
--
ALTER TABLE `tb_keluar`
  ADD CONSTRAINT `tb_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_keluar_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `tb_customer` (`id_customer`),
  ADD CONSTRAINT `tb_keluar_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_klaster_kmeans`
--
ALTER TABLE `tb_klaster_kmeans`
  ADD CONSTRAINT `tb_klaster_kmeans_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_log_aktivitas`
--
ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_masuk`
--
ALTER TABLE `tb_masuk`
  ADD CONSTRAINT `tb_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id_supplier`),
  ADD CONSTRAINT `tb_masuk_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_retur_keluar`
--
ALTER TABLE `tb_retur_keluar`
  ADD CONSTRAINT `tb_retur_keluar_ibfk_1` FOREIGN KEY (`id_keluar`) REFERENCES `tb_keluar` (`id_keluar`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_retur_masuk`
--
ALTER TABLE `tb_retur_masuk`
  ADD CONSTRAINT `tb_retur_masuk_ibfk_1` FOREIGN KEY (`id_masuk`) REFERENCES `tb_masuk` (`id_masuk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
