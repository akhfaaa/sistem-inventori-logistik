SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Struktur dari tabel `tb_barang`
-- --------------------------------------------------------
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

-- --------------------------------------------------------
-- Struktur dari tabel `tb_customer`
-- --------------------------------------------------------
CREATE TABLE `tb_customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(150) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_kategori`
-- --------------------------------------------------------
CREATE TABLE `tb_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_keluar`
-- --------------------------------------------------------
CREATE TABLE `tb_keluar` (
  `id_keluar` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `qty_keluar` int(11) NOT NULL,
  `tanggal_keluar` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_klaster_kmeans`
-- --------------------------------------------------------
CREATE TABLE `tb_klaster_kmeans` (
  `id_klaster` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `velocity_score` decimal(10,2) NOT NULL,
  `label_klaster` enum('Fast Moving','Slow Moving','Dead Stock') NOT NULL,
  `terakhir_diupdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_log_aktivitas`
-- --------------------------------------------------------
CREATE TABLE `tb_log_aktivitas` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `modul` varchar(50) NOT NULL,
  `waktu` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_masuk`
-- --------------------------------------------------------
CREATE TABLE `tb_masuk` (
  `id_masuk` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `qty_masuk` int(11) NOT NULL,
  `tanggal_masuk` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_nilai_supplier`
-- --------------------------------------------------------
CREATE TABLE `tb_nilai_supplier` (
  `id_supplier` int(11) NOT NULL,
  `c1_harga` int(11) NOT NULL COMMENT 'Cost (Semakin murah semakin baik)',
  `c2_kecepatan` int(11) NOT NULL COMMENT 'Benefit (Skala 1-100)',
  `c3_kualitas` int(11) NOT NULL COMMENT 'Benefit (Skala 1-100)',
  `c4_jarak` int(11) NOT NULL COMMENT 'Cost (Dalam Kilometer)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_rak`
-- --------------------------------------------------------
CREATE TABLE `tb_rak` (
  `id_rak` int(11) NOT NULL,
  `nama_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_rak_gudang`
-- --------------------------------------------------------
CREATE TABLE `tb_rak_gudang` (
  `id_rak` int(11) NOT NULL,
  `kode_rak` varchar(50) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_retur`
-- --------------------------------------------------------
CREATE TABLE `tb_retur` (
  `id_retur` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `aksi_stok` enum('Kembali ke Stok','Musnahkan') NOT NULL,
  `tanggal_retur` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_retur_keluar`
-- --------------------------------------------------------
CREATE TABLE `tb_retur_keluar` (
  `id_retur_keluar` int(11) NOT NULL,
  `id_keluar` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_retur` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_retur_masuk`
-- --------------------------------------------------------
CREATE TABLE `tb_retur_masuk` (
  `id_retur_masuk` int(11) NOT NULL,
  `id_masuk` int(11) NOT NULL,
  `qty_retur` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_retur` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_supplier`
-- --------------------------------------------------------
CREATE TABLE `tb_supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(150) NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Struktur dari tabel `tb_users`
-- --------------------------------------------------------
CREATE TABLE `tb_users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Administrator','Kepala Balai','Kasubbag','Staff') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------
-- PENGATURAN INDEXES (Primary Key & Kunci Tamu)
-- --------------------------------------------------------

ALTER TABLE `tb_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `kode_barang` (`kode_barang`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `fk_barang_rak` (`id_rak`);

ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_customer`);

ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

ALTER TABLE `tb_keluar`
  ADD PRIMARY KEY (`id_keluar`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `tb_keluar_ibfk_3` (`id_user`);

ALTER TABLE `tb_klaster_kmeans`
  ADD PRIMARY KEY (`id_klaster`),
  ADD KEY `id_barang` (`id_barang`);

ALTER TABLE `tb_log_aktivitas`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `tb_log_aktivitas_ibfk_1` (`id_user`);

ALTER TABLE `tb_masuk`
  ADD PRIMARY KEY (`id_masuk`),
  ADD KEY `id_barang` (`id_barang`),
  ADD KEY `id_supplier` (`id_supplier`),
  ADD KEY `tb_masuk_ibfk_3` (`id_user`);

ALTER TABLE `tb_nilai_supplier`
  ADD PRIMARY KEY (`id_supplier`);

ALTER TABLE `tb_rak`
  ADD PRIMARY KEY (`id_rak`);

ALTER TABLE `tb_rak_gudang`
  ADD PRIMARY KEY (`id_rak`),
  ADD UNIQUE KEY `kode_rak` (`kode_rak`);

ALTER TABLE `tb_retur`
  ADD PRIMARY KEY (`id_retur`);

ALTER TABLE `tb_retur_keluar`
  ADD PRIMARY KEY (`id_retur_keluar`),
  ADD KEY `id_keluar` (`id_keluar`);

ALTER TABLE `tb_retur_masuk`
  ADD PRIMARY KEY (`id_retur_masuk`),
  ADD KEY `id_masuk` (`id_masuk`);

ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_supplier`);

ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

-- --------------------------------------------------------
-- PENGATURAN AUTO_INCREMENT
-- --------------------------------------------------------

ALTER TABLE `tb_barang` MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_customer` MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_kategori` MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_keluar` MODIFY `id_keluar` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_klaster_kmeans` MODIFY `id_klaster` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_log_aktivitas` MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_masuk` MODIFY `id_masuk` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_rak` MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_rak_gudang` MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_retur` MODIFY `id_retur` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_retur_keluar` MODIFY `id_retur_keluar` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_retur_masuk` MODIFY `id_retur_masuk` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_supplier` MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tb_users` MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------
-- KETIDAKLELUASAAN (CONSTRAINTS / FOREIGN KEYS)
-- --------------------------------------------------------

ALTER TABLE `tb_barang`
  ADD CONSTRAINT `fk_barang_rak` FOREIGN KEY (`id_rak`) REFERENCES `tb_rak` (`id_rak`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`);

ALTER TABLE `tb_keluar`
  ADD CONSTRAINT `tb_keluar_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_keluar_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `tb_customer` (`id_customer`),
  ADD CONSTRAINT `tb_keluar_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tb_klaster_kmeans`
  ADD CONSTRAINT `tb_klaster_kmeans_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE;

ALTER TABLE `tb_log_aktivitas`
  ADD CONSTRAINT `tb_log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tb_masuk`
  ADD CONSTRAINT `tb_masuk_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `tb_barang` (`id_barang`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_masuk_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `tb_supplier` (`id_supplier`),
  ADD CONSTRAINT `tb_masuk_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `tb_retur_keluar`
  ADD CONSTRAINT `tb_retur_keluar_ibfk_1` FOREIGN KEY (`id_keluar`) REFERENCES `tb_keluar` (`id_keluar`) ON DELETE CASCADE;

ALTER TABLE `tb_retur_masuk`
  ADD CONSTRAINT `tb_retur_masuk_ibfk_1` FOREIGN KEY (`id_masuk`) REFERENCES `tb_masuk` (`id_masuk`) ON DELETE CASCADE;

COMMIT;