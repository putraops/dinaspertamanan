-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2017 at 09:15 AM
-- Server version: 5.5.57-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goldenli_pertamanan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL,
  `longitude` double NOT NULL COMMENT 'lokasi saat dia absen',
  `latitude` double NOT NULL COMMENT 'lokasi saat dia absen',
  `lokasi` varchar(255) NOT NULL,
  `tanggal` datetime NOT NULL,
  `tipe` varchar(20) NOT NULL COMMENT 'Absensi masuk / pulang kantor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL COMMENT 'ADMIN / SUPERADMIN / SALES/ SOPIR'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id`, `nama`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Koordinator'),
(4, 'Pekerja');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` int(11) NOT NULL,
  `PenanggungJawabUserId` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `no_polisi` varchar(10) NOT NULL,
  `isDelete` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `PenanggungJawabUserId`, `nama`, `no_polisi`, `isDelete`, `created_at`, `updated_at`) VALUES
(1, 5, 'Motor', 'S5525KR', 0, '2017-09-11 13:54:26', '2017-09-25 07:16:39'),
(2, 6, 'Box', 'S 4035 V', 0, '2017-09-11 18:24:28', '2017-10-19 17:35:49'),
(3, 7, 'avanza', 'L 1515 B', 0, '2017-09-26 23:01:39', '2017-10-19 17:35:57'),
(15, 0, '', '', 0, '2017-11-04 13:30:07', '2017-11-04 13:30:07');

-- --------------------------------------------------------

--
-- Table structure for table `pekerja`
--

CREATE TABLE `pekerja` (
  `id` int(11) NOT NULL,
  `TaskKendaraanID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Status` int(11) NOT NULL COMMENT 'penanggung jawab / pekerja'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pekerja`
--

INSERT INTO `pekerja` (`id`, `TaskKendaraanID`, `UserID`, `Status`) VALUES
(1, 7, 7, 0),
(2, 7, 6, 0),
(3, 9, 7, 0),
(4, 9, 6, 0),
(5, 11, 7, 0),
(6, 11, 6, 0),
(7, 13, 7, 0),
(8, 13, 6, 0),
(9, 15, 7, 0),
(10, 15, 6, 0),
(11, 17, 7, 0),
(12, 17, 6, 0),
(13, 19, 7, 0),
(14, 19, 6, 0),
(15, 2, 7, 0),
(16, 2, 6, 0),
(17, 3, 7, 0),
(18, 3, 6, 0),
(19, 4, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pengerjaan`
--

CREATE TABLE `pengerjaan` (
  `ID` int(11) NOT NULL,
  `TaskDetailID` int(11) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `Tipe` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengerjaan`
--

INSERT INTO `pengerjaan` (`ID`, `TaskDetailID`, `ext`, `Tipe`, `created_at`, `updated_at`) VALUES
(1, 1, '.jpg', '', '2017-10-10 13:42:45', '2017-10-10 13:42:45'),
(2, 1, '.jpg', '', '2017-10-10 13:45:33', '2017-10-10 13:45:33'),
(3, 1, '.jpg', '', '2017-10-13 09:51:42', '2017-10-13 09:51:42'),
(4, 1, '.jpg', '', '2017-10-13 09:55:30', '2017-10-13 09:55:30'),
(7, 1, '.jpg', '', '2017-10-13 10:19:28', '2017-10-13 10:19:28'),
(8, 3, '.jpg', '', '2017-10-13 10:26:53', '2017-10-13 10:26:53'),
(9, 7, '.jpg', '', '2017-10-14 12:53:41', '2017-10-14 12:53:41');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `ID` int(11) NOT NULL,
  `TaskName` varchar(500) NOT NULL,
  `TanggalDibuat` datetime NOT NULL,
  `DetailTask` varchar(1000) NOT NULL,
  `StatusTask` varchar(50) NOT NULL COMMENT 'Status : NEW TASK / PROCESS / DONE / FAILED',
  `CreatedUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`ID`, `TaskName`, `TanggalDibuat`, `DetailTask`, `StatusTask`, `CreatedUser`) VALUES
(4, 'Ke Taman Apsari', '2017-10-31 16:50:11', '', 'Baru', 5),
(5, 'Pembersihan Taman Prestasi', '2017-10-31 16:55:41', '', 'Baru', 5),
(6, 'sholeh', '2017-11-07 17:24:57', '', 'Baru', 5),
(7, 'sholeh', '2017-11-07 17:24:57', '', 'Baru', 5),
(8, 'tes', '2017-11-08 19:27:17', '', 'Baru', 5),
(9, 'tes', '2017-11-08 19:27:17', '', 'Baru', 5),
(10, 'gg', '2017-11-08 19:29:06', '', 'Baru', 5),
(11, 'gg', '2017-11-08 19:29:06', '', 'Baru', 5),
(12, 'sheiri', '2017-11-08 19:50:33', '', 'Baru', 5),
(13, 'sheiri', '2017-11-08 19:50:33', '', 'Baru', 5),
(14, 'gg', '2017-11-08 20:01:49', '', 'Baru', 5),
(15, 'gg', '2017-11-08 20:01:49', '', 'Baru', 5),
(16, 'gg', '2017-11-08 20:22:17', '', 'Baru', 5),
(17, 'gg', '2017-11-08 20:22:17', '', 'Baru', 5),
(18, 'gg', '2017-11-08 20:23:34', '', 'Baru', 5),
(19, 'gg', '2017-11-08 20:23:34', '', 'Baru', 5),
(28, 'gg', '2017-11-08 22:06:32', '', 'Baru', 5),
(29, 'gg', '2017-11-09 07:49:02', '', 'Baru', 5),
(30, 'igig', '2017-11-09 11:29:38', '', 'Baru', 5);

-- --------------------------------------------------------

--
-- Table structure for table `taskkendaraan`
--

CREATE TABLE `taskkendaraan` (
  `id` int(11) NOT NULL,
  `TaskId` int(11) NOT NULL,
  `KendaraanId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskkendaraan`
--

INSERT INTO `taskkendaraan` (`id`, `TaskId`, `KendaraanId`) VALUES
(1, 27, 3),
(2, 28, 3),
(3, 29, 3),
(4, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_detail`
--

CREATE TABLE `task_detail` (
  `ID` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL,
  `Lokasi` varchar(500) NOT NULL,
  `Latitude` double NOT NULL,
  `Longitude` double NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Belum' COMMENT 'Status: Belum, Sudah',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_detail`
--

INSERT INTO `task_detail` (`ID`, `TaskID`, `Lokasi`, `Latitude`, `Longitude`, `status`, `created_at`, `updated_at`) VALUES
(7, 4, '', 0, 0, 'New', '2017-10-31 16:50:12', '2017-10-31 16:50:12'),
(8, 5, '', 0, 0, 'New', '2017-10-31 16:55:47', '2017-10-31 16:55:47'),
(9, 5, '', 0, 0, 'New', '2017-10-31 16:55:48', '2017-10-31 16:55:48'),
(10, 6, 'Jl. Emb Tanjung No.9, Embong Kaliasin, Genteng, Kota SBY, Jawa Timur 60271, Indonesia', -7.266567500000002, 112.74630859375002, 'Belum', '2017-11-07 17:24:57', '2017-11-07 17:24:57'),
(11, 6, 'Jl. Emb Tanjung No.9, Embong Kaliasin, Genteng, Kota SBY, Jawa Timur 60271, Indonesia', -7.266567500000002, 112.74630859375002, 'Belum', '2017-11-07 17:24:57', '2017-11-07 17:24:57'),
(12, 8, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 19:27:17', '2017-11-08 19:27:17'),
(13, 8, 'Jl. Margo Rukun XI No.8, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2522425, 112.72509765624997, 'Belum', '2017-11-08 19:27:17', '2017-11-08 19:27:17'),
(14, 10, 'Adi Jasa, JL. Demak, No. 90-92, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2517439, 112.7216028, 'Belum', '2017-11-08 19:29:06', '2017-11-08 19:29:06'),
(15, 10, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 19:29:06', '2017-11-08 19:29:06'),
(16, 12, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 19:50:33', '2017-11-08 19:50:33'),
(17, 12, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 19:50:33', '2017-11-08 19:50:33'),
(18, 14, 'Jl. Demak Timur No.53, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2501874999999885, 112.72169921874993, 'Belum', '2017-11-08 20:01:49', '2017-11-08 20:01:49'),
(19, 14, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 20:01:49', '2017-11-08 20:01:49'),
(20, 16, 'Jl. Demak Timur No.53, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2501874999999885, 112.72169921874993, 'Belum', '2017-11-08 20:22:17', '2017-11-08 20:22:17'),
(21, 16, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 20:22:17', '2017-11-08 20:22:17'),
(22, 18, 'Jl. Demak Timur No.53, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2501874999999885, 112.72169921874993, 'Belum', '2017-11-08 20:23:34', '2017-11-08 20:23:34'),
(23, 18, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 20:23:34', '2017-11-08 20:23:34'),
(24, 28, 'Jl. Demak Timur No.53, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2501874999999885, 112.72169921874993, 'Belum', '2017-11-08 22:06:32', '2017-11-08 22:06:32'),
(25, 28, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-08 22:06:32', '2017-11-08 22:06:32'),
(26, 29, 'Jl. Demak Timur No.53, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.2501874999999885, 112.72169921874993, 'Belum', '2017-11-09 07:49:02', '2017-11-09 07:49:02'),
(27, 29, 'Jl. Tembok Dukuh IX No.31, Gundih, Bubutan, Kota SBY, Jawa Timur 60172, Indonesia', -7.251797500000003, 112.72210546874996, 'Belum', '2017-11-09 07:49:02', '2017-11-09 07:49:02'),
(28, 30, 'Jl. Panglima Sudirman No.23-25, Embong Kaliasin, Genteng, Kota SBY, Jawa Timur 60271, Indonesia', -7.265757499999986, 112.74555859374998, 'Belum', '2017-11-09 11:29:38', '2017-11-09 11:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `id_jabatan` int(11) NOT NULL COMMENT 'Jabatan dia sebagai apa, sales, admin ,sopir, atau super admin',
  `is_active` varchar(2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `telepon`, `id_jabatan`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'sholeh', '5c58f7f2b3ec57ec92faaa329d382360', 'sholeh', '085733929226', 1, '1', '2017-10-31 16:03:19', '2017-10-31 16:03:19'),
(6, 'eko', '5c58f7f2b3ec57ec92faaa329d382360', 'Eko Pasukan Kuning', '085757686767', 2, '1', '2017-10-31 16:13:23', '2017-10-31 16:13:23'),
(7, 'doni', '5c58f7f2b3ec57ec92faaa329d382360', 'Doni Pasukan Kuning', '085757686767', 3, '1', '2017-10-31 16:13:23', '2017-10-31 16:13:23'),
(8, 'Jhon', '5c58f7f2b3ec57ec92faaa329d382360', 'Jhon', '085757686767', 4, '1', '2017-10-31 16:13:23', '2017-10-31 16:13:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pekerja`
--
ALTER TABLE `pekerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengerjaan`
--
ALTER TABLE `pengerjaan`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `taskkendaraan`
--
ALTER TABLE `taskkendaraan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_detail`
--
ALTER TABLE `task_detail`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `pekerja`
--
ALTER TABLE `pekerja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `pengerjaan`
--
ALTER TABLE `pengerjaan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `taskkendaraan`
--
ALTER TABLE `taskkendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `task_detail`
--
ALTER TABLE `task_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
