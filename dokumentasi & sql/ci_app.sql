-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 26, 2019 at 05:27 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ci_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_data_mahasiswa`
--

CREATE TABLE `ci_data_mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(250) NOT NULL,
  `nama_lengkap` varchar(250) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `angkatan` varchar(10) NOT NULL,
  `status` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_manajemen_akses`
--

CREATE TABLE `ci_manajemen_akses` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` text NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `added` varchar(250) NOT NULL,
  `last_login` varchar(250) NOT NULL,
  `primary` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_manajemen_akses`
--

INSERT INTO `ci_manajemen_akses` (`id`, `username`, `password`, `nama_lengkap`, `foto`, `added`, `last_login`, `primary`) VALUES
(4, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'New_Project.png', '23/06/2019&nbsp;(07:37:22am)', '26/06/2019&nbsp;(10:24:37pm)', '1');

-- --------------------------------------------------------

--
-- Table structure for table `ci_pengaturan`
--

CREATE TABLE `ci_pengaturan` (
  `id` int(11) NOT NULL,
  `nama_aplikasi` varchar(250) NOT NULL,
  `deskripsi_aplikasi` text NOT NULL,
  `intro_aplikasi` varchar(250) NOT NULL,
  `pembuat_aplikasi` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_pengaturan`
--

INSERT INTO `ci_pengaturan` (`id`, `nama_aplikasi`, `deskripsi_aplikasi`, `intro_aplikasi`, `pembuat_aplikasi`) VALUES
(1, 'Nama Aplikasi Anda', 'Deskripsi Aplikasi Anda', 'Intro Aplikasi Anda', 'Nama Anda');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_data_mahasiswa`
--
ALTER TABLE `ci_data_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `ci_manajemen_akses`
--
ALTER TABLE `ci_manajemen_akses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_pengaturan`
--
ALTER TABLE `ci_pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_data_mahasiswa`
--
ALTER TABLE `ci_data_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ci_manajemen_akses`
--
ALTER TABLE `ci_manajemen_akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
