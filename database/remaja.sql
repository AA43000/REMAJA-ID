-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 15, 2022 at 10:29 PM
-- Server version: 10.3.31-MariaDB-0+deb10u1
-- PHP Version: 7.1.33-25+0~20210112.45+debian10~1.gbp1a89bf

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `remaja`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `jumlah` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`jumlah`) VALUES
(0);

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` int(100) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kas_detail`
--

CREATE TABLE `kas_detail` (
  `id` int(11) NOT NULL,
  `id_kas` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `jumlah` int(100) DEFAULT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `nama`, `tanggal`, `deskripsi`, `image`, `status_delete`) VALUES
(1, 'Shoreline', '2022-06-08', 'Grayscale is open source and MIT licensed. This means you can use it for any project - even commercial projects! Download it, customize it, and publish your website!', '1654695950954.jpg', 0),
(2, 'Misty', '2022-06-15', 'An example of where you can put an image of a project, or anything else, along with a description.', '1654696001579.jpg', 0),
(3, 'Mountains', '2022-06-22', 'Another example of a project with its respective description. These sections work well responsively as well, try this theme on a small screen!', '1654696054255.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lupa_password`
--

CREATE TABLE `lupa_password` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `no_wa` varchar(100) NOT NULL,
  `status_kirim` tinyint(1) NOT NULL DEFAULT 0,
  `password_baru` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lupa_password`
--

INSERT INTO `lupa_password` (`id`, `id_user`, `tanggal`, `no_wa`, `status_kirim`, `password_baru`) VALUES
(1, 5, '2022-06-14', '098138764', 1, '1655217699'),
(2, 1, '2022-06-15', '081328331831', 1, '1655298459'),
(3, 1, '2022-06-15', '081328331831', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `m_pemasukan`
--

CREATE TABLE `m_pemasukan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_pemasukan`
--

INSERT INTO `m_pemasukan` (`id`, `nama`, `status_delete`) VALUES
(1, 'Kas', 0);

-- --------------------------------------------------------

--
-- Table structure for table `m_pengeluaran`
--

CREATE TABLE `m_pengeluaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `status_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notif_pengumuman`
--

CREATE TABLE `notif_pengumuman` (
  `id` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_pengumuman` int(11) DEFAULT NULL,
  `telah_dibaca` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id` int(11) NOT NULL,
  `idm_pemasukan` int(11) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` int(100) DEFAULT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `pemasukan`
--
DELIMITER $$
CREATE TRIGGER `pemasukan_insert` AFTER INSERT ON `pemasukan` FOR EACH ROW BEGIN
    UPDATE anggaran SET jumlah = jumlah + NEW.jumlah;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pemasukan_update` AFTER UPDATE ON `pemasukan` FOR EACH ROW BEGIN
	IF(NEW.status_delete = 0) THEN
		UPDATE anggaran SET jumlah = (jumlah - OLD.jumlah) + NEW.jumlah;
    ELSE
    	UPDATE anggaran SET jumlah = jumlah - NEW.jumlah;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `text` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int(11) NOT NULL,
  `idm_pengeluaran` int(11) DEFAULT NULL,
  `kode` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah` int(100) DEFAULT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `pengeluaran`
--
DELIMITER $$
CREATE TRIGGER `pengeluaran_insert` AFTER INSERT ON `pengeluaran` FOR EACH ROW BEGIN
    UPDATE anggaran SET jumlah = jumlah - NEW.jumlah;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `pengeluaran_update` AFTER UPDATE ON `pengeluaran` FOR EACH ROW BEGIN
	IF(NEW.status_delete = 0) THEN
		UPDATE anggaran SET jumlah = (jumlah + OLD.jumlah) - NEW.jumlah;
    ELSE
    	UPDATE anggaran SET jumlah = jumlah + NEW.jumlah;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `waktu` time DEFAULT '00:00:00',
  `tempat` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` int(11) NOT NULL,
  `id_unit` int(11) DEFAULT NULL,
  `nama_peminjam` varchar(100) DEFAULT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0: belum; 1: kembali',
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `dipinjam` int(11) DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` int(11) NOT NULL,
  `nomor_wa` varchar(50) NOT NULL,
  `status_approve` tinyint(1) NOT NULL COMMENT '0:belum disetujui, 1: sudah disetujui',
  `status_delete` tinyint(1) DEFAULT 0,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `user_type`, `nomor_wa`, `status_approve`, `status_delete`, `image`) VALUES
(1, 'ahmad zaeni mubarok', 'admin', '$2y$10$eSvxyE3DurpUdC2zCu.0geO4.qUtPIW2nfhXyJewLyGwb1rlrt0w6', 1, '081328331831', 1, 0, '1654434556.png'),
(2, 'bendahara', 'bendahara', '$2y$10$6cDgbWeK61UPdGaGKPOshurTXfdpxWwy9Wdj1FBf35i5Bdq6LYukC', 2, '0987654321', 1, 0, ''),
(3, 'petugas', 'petugas', '$2y$10$1nn6xeMByGjPu0.L8S.xtuKDKcEHPf/YZK0lddj52H10nxVZANARu', 3, '09876543211', 1, 0, 'no-image.svg'),
(4, 'anggota', 'anggota', '$2y$10$1Gt9aYC3/Q/N1raXQE781e.Bn9tL3PGRoEh1qd.z.5IHy.zGFZspu', 4, '0192837465', 1, 0, 'no-image.svg');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `id_user_type` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `status_delete` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id_user_type`, `nama`, `status_delete`) VALUES
(1, 'admin', 0),
(2, 'bendahara', 0),
(3, 'petugas', 0),
(4, 'anggota', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_detail`
--
ALTER TABLE `kas_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lupa_password`
--
ALTER TABLE `lupa_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_pemasukan`
--
ALTER TABLE `m_pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_pengeluaran`
--
ALTER TABLE `m_pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif_pengumuman`
--
ALTER TABLE `notif_pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id_user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_detail`
--
ALTER TABLE `kas_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lupa_password`
--
ALTER TABLE `lupa_password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `m_pemasukan`
--
ALTER TABLE `m_pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `m_pengeluaran`
--
ALTER TABLE `m_pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notif_pengumuman`
--
ALTER TABLE `notif_pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id_user_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
