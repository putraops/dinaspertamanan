-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2017 at 10:48 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinaspertamanan`
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
  `filename` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL,
  `tipe` varchar(20) NOT NULL COMMENT 'Absensi masuk / pulang kantor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `id_user`, `TaskID`, `longitude`, `latitude`, `lokasi`, `filename`, `tanggal`, `tipe`) VALUES
(1, 1, 1, 1, 1, 'surabaya', '2342934234.jpg', '2017-11-13 00:00:00', 'checkin');

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
(3, 'Sopir');

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
(3, 7, 'avanza', 'L 1515 B', 0, '2017-09-26 23:01:39', '2017-10-19 17:35:57');

-- --------------------------------------------------------

--
-- Table structure for table `pengerjaan`
--

CREATE TABLE `pengerjaan` (
  `ID` int(11) NOT NULL,
  `TaskDetailID` int(11) NOT NULL,
  `UserId` int(50) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengerjaan`
--

INSERT INTO `pengerjaan` (`ID`, `TaskDetailID`, `UserId`, `filename`, `latitude`, `longitude`, `lokasi`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'asdasd', 0, 0, 'sub', '2017-11-16 00:00:00', '2017-11-16 00:00:00'),
(2, 2, 7, 'asdasd', 0, 0, 'sub', '2017-11-16 00:00:00', '2017-11-16 00:00:00');

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
(1, 'Buang Sampah Tunjungna Plaza', '2017-11-10 00:00:00', 'Dikerjakan oleh:\r\n\r\nPak Anton\r\nPak Budi\r\nPak Karjo', 'Baru', 6);

-- --------------------------------------------------------

--
-- Table structure for table `taskkendaraan`
--

CREATE TABLE `taskkendaraan` (
  `id` int(11) NOT NULL,
  `TaskId` int(11) NOT NULL,
  `KendaraanId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskkendaraan`
--

INSERT INTO `taskkendaraan` (`id`, `TaskId`, `KendaraanId`, `UserId`) VALUES
(1, 1, 1, 7);

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
(1, 1, 'Tujungan', 0, 0, 'Belum', '2017-11-10 00:00:00', '2017-11-10 00:00:00'),
(2, 1, 'Darmo', 0.5645645456, 0.03453456, 'Belum', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(6, 'eko', '5c58f7f2b3ec57ec92faaa329d382360', 'Eko Admin', '085757686767', 2, '1', '2017-10-31 16:13:23', '2017-10-31 16:13:23'),
(7, 'doni', '5c58f7f2b3ec57ec92faaa329d382360', 'Doni Sopir', '085757686767', 3, '1', '2017-10-31 16:13:23', '2017-10-31 16:13:23'),
(8, 'Jhon', '5c58f7f2b3ec57ec92faaa329d382360', 'Jhon Sopir', '085757686767', 3, '1', '2017-10-31 16:13:23', '2017-10-31 16:13:23');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pengerjaan`
--
ALTER TABLE `pengerjaan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `taskkendaraan`
--
ALTER TABLE `taskkendaraan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `task_detail`
--
ALTER TABLE `task_detail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
