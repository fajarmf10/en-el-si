-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2017 at 10:09 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tescok`
--

-- --------------------------------------------------------

--
-- Table structure for table `edisi`
--

CREATE TABLE `edisi` (
  `id_edisi` int(11) NOT NULL,
  `edisi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `edisi`
--

INSERT INTO `edisi` (`id_edisi`, `edisi`) VALUES
(1, 'Schematics 2017'),
(2, 'Schematics 2018');

-- --------------------------------------------------------

--
-- Table structure for table `edisites`
--

CREATE TABLE `edisites` (
  `id_tes` int(11) NOT NULL,
  `id_edisi` int(11) NOT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `edisites`
--

INSERT INTO `edisites` (`id_tes`, `id_edisi`, `aktif`) VALUES
(3, 1, 'Y'),
(4, 1, 'Y'),
(4, 2, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_tim` varchar(20) NOT NULL,
  `id_tes` int(11) NOT NULL,
  `acak_soal` text NOT NULL,
  `jawaban` text NOT NULL,
  `sisa_waktu` int(11) NOT NULL,
  `jml_benar` int(11) NOT NULL,
  `nilai` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `panel`
--

CREATE TABLE `panel` (
  `ID_PANEL` int(11) NOT NULL,
  `NAMA_PANEL` varchar(50) DEFAULT NULL,
  `UNAME_PANEL` varchar(50) DEFAULT NULL,
  `PWD` varchar(50) DEFAULT NULL,
  `LEVEL` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `panel`
--

INSERT INTO `panel` (`ID_PANEL`, `NAMA_PANEL`, `UNAME_PANEL`, `PWD`, `LEVEL`) VALUES
(1, 'Fajar Maulana Firdaus', 'fajarmf', '62e4254d833c0e72e8ddab789ee33430', 'admin'),
(2, 'ashkan dejagah', 'askan', 'f3673480629ae7a7c94539feeb39423d', 'operator');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id_tim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_edisi` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_tim`, `nama`, `password`, `id_edisi`, `status`) VALUES
('asik_deq', 'asdeq', '37f67e08f90c807878c65521d6fdb24b', 1, 'off'),
('huerzo_smanda', 'Huerzo', '5f9f534099bd1dc4305fd48bf4410665', 2, 'off');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL,
  `id_tes` int(11) NOT NULL,
  `soal` text NOT NULL,
  `pilihan_1` text NOT NULL,
  `pilihan_2` text NOT NULL,
  `pilihan_3` text NOT NULL,
  `pilihan_4` text NOT NULL,
  `pilihan_5` text NOT NULL,
  `kunci` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id_soal`, `id_tes`, `soal`, `pilihan_1`, `pilihan_2`, `pilihan_3`, `pilihan_4`, `pilihan_5`, `kunci`) VALUES
(1, 4, '<p>Ayam apa yang nakal?</p>', '<p>Tidak mandi ya?</p>', '<p>Tidak gosok gigi 2</p>', '<p>Pejuang</p>', '<p>Pernahkah aku sakit?</p>', '<p>Rindu mantan</p>', 5),
(2, 4, '<p>tes soal 2</p>', '<p>Tidak mandi besar</p>', '<p>Tidak gosok gigi anjing</p>', '<p>Pejuang jancok</p>', '<p>Pernahkah aku sakit? 2</p>', '<p>Rindu mantan? Hehe</p>', 2),
(4, 4, '<p>Why is everything so heavy?</p>', '<p>Linkin Park</p>', '<p>Avenged Sevenfold</p>', '<p>Mantap anjing</p>', '<p>Kiaara</p>', '<p>Tiara</p>', 3),
(5, 4, '<p>Berwarna apakah sebuah gurun?</p>', '<p>Hijau</p>', '<p>Merah</p>', '<p>Kuning</p>', '<p>Abu-abu</p>', '<p>Oranye</p>', 3),
(6, 4, '<p>Sembari pergi</p>', '<p>1</p>', '<p>2</p>', '<p>3</p>', '<p>4</p>', '<p>455</p>', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tes`
--

CREATE TABLE `tes` (
  `id_tes` int(11) NOT NULL,
  `judul` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` int(11) NOT NULL,
  `jml_soal` int(11) NOT NULL,
  `acak_soal` enum('Y','N') NOT NULL,
  `acak_jawaban` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tes`
--

INSERT INTO `tes` (`id_tes`, `judul`, `tanggal`, `waktu`, `jml_soal`, `acak_soal`, `acak_jawaban`) VALUES
(3, 'Schhhhhhh17', '2017-07-13', 190, 150, 'Y', 'Y'),
(4, 'Warmup dude', '2017-07-19', 129, 123, 'Y', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `edisi`
--
ALTER TABLE `edisi`
  ADD PRIMARY KEY (`id_edisi`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `panel`
--
ALTER TABLE `panel`
  ADD PRIMARY KEY (`ID_PANEL`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_tim`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`);

--
-- Indexes for table `tes`
--
ALTER TABLE `tes`
  ADD PRIMARY KEY (`id_tes`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `edisi`
--
ALTER TABLE `edisi`
  MODIFY `id_edisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tes`
--
ALTER TABLE `tes`
  MODIFY `id_tes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
