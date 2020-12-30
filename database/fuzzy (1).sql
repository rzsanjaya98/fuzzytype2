-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2020 at 11:34 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fuzzy`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_meteorologi`
--

CREATE TABLE `data_meteorologi` (
  `data_id` int(11) NOT NULL,
  `data_tanggal` date NOT NULL,
  `data_temperatur` double NOT NULL,
  `data_kelembapan` double NOT NULL,
  `data_lama_penyinaran_matahari` double NOT NULL,
  `data_kecepatan_angin` double NOT NULL,
  `data_curah_hujan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_meteorologi`
--

INSERT INTO `data_meteorologi` (`data_id`, `data_tanggal`, `data_temperatur`, `data_kelembapan`, `data_lama_penyinaran_matahari`, `data_kecepatan_angin`, `data_curah_hujan`) VALUES
(1, '2019-12-14', 28, 80, 7, 1.94, 1.7),
(2, '2019-12-16', 29, 82, 1.9, 1.94, 2.7),
(3, '2019-12-17', 30, 78, 9.1, 1.94, 2.5),
(4, '2019-12-20', 27.9, 88, 5.1, 1.94, 47.5),
(5, '2019-12-21', 28.2, 87, 5, 0, 15.5),
(6, '2019-12-22', 27.4, 89, 1.1, 1.94, 6.5),
(7, '2019-12-23', 28.5, 85, 4, 1.94, 8.5),
(8, '2019-12-24', 28.5, 84, 1.3, 1.94, 2.4),
(9, '2019-12-26', 28.3, 88, 4.3, 1.94, 8),
(10, '2019-12-28', 28, 80, 8.6, 1.94, 3);

-- --------------------------------------------------------

--
-- Table structure for table `data_meteorologi_fuzzifikasi`
--

CREATE TABLE `data_meteorologi_fuzzifikasi` (
  `data_id` int(11) NOT NULL,
  `data_tanggal` date NOT NULL,
  `data_temperaturUsejuk` double NOT NULL,
  `data_temperaturUnormal` double NOT NULL,
  `data_temperaturUpanas` double NOT NULL,
  `data_temperaturLsejuk` double NOT NULL,
  `data_temperaturLnormal` double NOT NULL,
  `data_temperaturLpanas` double NOT NULL,
  `data_kelembapanUkering` double NOT NULL,
  `data_kelembapanUlembab` double NOT NULL,
  `data_kelembapanUbasah` double NOT NULL,
  `data_kelembapanLkering` double NOT NULL,
  `data_kelembapanLlembab` double NOT NULL,
  `data_kelembapanLbasah` double NOT NULL,
  `data_lama_penyinaran_matahariUrendah` double NOT NULL,
  `data_lama_penyinaran_matahariUsedang` double NOT NULL,
  `data_lama_penyinaran_matahariUtinggi` double NOT NULL,
  `data_lama_penyinaran_matahariLrendah` double NOT NULL,
  `data_lama_penyinaran_matahariLsedang` double NOT NULL,
  `data_lama_penyinaran_matahariLtinggi` double NOT NULL,
  `data_kecepatan_anginUlambat` double NOT NULL,
  `data_kecepatan_anginUagakkencang` double NOT NULL,
  `data_kecepatan_anginUkencang` double NOT NULL,
  `data_kecepatan_anginLlambat` double NOT NULL,
  `data_kecepatan_anginLagakkencang` double NOT NULL,
  `data_kecepatan_anginLkencang` double NOT NULL,
  `data_curah_hujan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_meteorologi_fuzzifikasi`
--

INSERT INTO `data_meteorologi_fuzzifikasi` (`data_id`, `data_tanggal`, `data_temperaturUsejuk`, `data_temperaturUnormal`, `data_temperaturUpanas`, `data_temperaturLsejuk`, `data_temperaturLnormal`, `data_temperaturLpanas`, `data_kelembapanUkering`, `data_kelembapanUlembab`, `data_kelembapanUbasah`, `data_kelembapanLkering`, `data_kelembapanLlembab`, `data_kelembapanLbasah`, `data_lama_penyinaran_matahariUrendah`, `data_lama_penyinaran_matahariUsedang`, `data_lama_penyinaran_matahariUtinggi`, `data_lama_penyinaran_matahariLrendah`, `data_lama_penyinaran_matahariLsedang`, `data_lama_penyinaran_matahariLtinggi`, `data_kecepatan_anginUlambat`, `data_kecepatan_anginUagakkencang`, `data_kecepatan_anginUkencang`, `data_kecepatan_anginLlambat`, `data_kecepatan_anginLagakkencang`, `data_kecepatan_anginLkencang`, `data_curah_hujan`) VALUES
(1, '2019-12-14', 0, 1, 0, 0, 0.6, 0, 0, 0, 1, 0, 0, 0.5, 0, 1, 0, 0, 0.8, 0, 1, 0, 0, 0.8, 0, 0, 1.7),
(2, '2019-12-16', 0, 1, 0, 0, 0.8, 0, 0, 0, 1, 0, 0, 0.8, 1, 0, 0, 0.8, 0, 0, 1, 0, 0, 0.8, 0, 0, 2.7),
(3, '2019-12-17', 0, 0, 1, 0, 0, 0.75, 0, 1, 0, 0, 0.5, 0, 0, 0, 1, 0, 0, 0.6, 1, 0, 0, 0.8, 0, 0, 2.5),
(4, '2019-12-20', 0.2, 0.8, 0, 0, 0.4, 0, 0, 0, 1, 0, 0, 0.8, 0, 1, 0, 0, 0.6, 0, 1, 0, 0, 0.8, 0, 0, 47.5),
(5, '2019-12-21', 0, 1, 0, 0, 0.8, 0, 0, 0, 1, 0, 0, 0.8, 0, 1, 0, 0, 0.5, 0, 1, 0, 0, 0.8, 0, 0, 15.5),
(6, '2019-12-22', 1, 0, 0, 0.8, 0, 0, 0, 0, 1, 0, 0, 0.8, 1, 0, 0, 0.8, 0, 0, 1, 0, 0, 0.8, 0, 0, 6.5),
(7, '2019-12-23', 0, 1, 0, 0, 0.8, 0, 0, 0, 1, 0, 0, 0.8, 1, 0, 0, 0.5, 0, 0, 1, 0, 0, 0.8, 0, 0, 8.5),
(8, '2019-12-24', 0, 1, 0, 0, 0.8, 0, 0, 0, 1, 0, 0, 0.8, 1, 0, 0, 0.8, 0, 0, 1, 0, 0, 0.8, 0, 0, 2.4),
(9, '2019-12-26', 0, 1, 0, 0, 0.8, 0, 0, 0, 1, 0, 0, 0.8, 0.7, 0.3, 0, 0.2, 0, 0, 1, 0, 0, 0.8, 0, 0, 8),
(10, '2019-12-28', 0, 1, 0, 0, 0.6, 0, 0, 0, 1, 0, 0, 0.5, 0, 0.4, 0.6, 0, 0, 0.1, 1, 0, 0, 0.8, 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `data_prediksi`
--

CREATE TABLE `data_prediksi` (
  `data_id` int(11) NOT NULL,
  `data_tanggal` date NOT NULL,
  `data_curah_hujan` double NOT NULL,
  `data_curah_hujan_prediksi` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_prediksi`
--

INSERT INTO `data_prediksi` (`data_id`, `data_tanggal`, `data_curah_hujan`, `data_curah_hujan_prediksi`) VALUES
(1, '2019-12-14', 1.7, 2.5),
(2, '2019-12-16', 2.7, 2.5),
(3, '2019-12-17', 2.5, 2.5),
(4, '2019-12-20', 47.5, 12.01),
(5, '2019-12-21', 15.5, 2.5),
(6, '2019-12-22', 6.5, 12.5),
(7, '2019-12-23', 8.5, 2.5),
(8, '2019-12-24', 2.4, 2.5),
(9, '2019-12-26', 8, 2.5),
(10, '2019-12-28', 3, 2.5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_username`, `user_password`) VALUES
(11, 'root', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(10) NOT NULL,
  `user_profile_fullname` varchar(200) NOT NULL,
  `user_profile_email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `user_profile_fullname`, `user_profile_email`) VALUES
(11, 'Reza Sanjaya', 'rzsanjaya@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_meteorologi`
--
ALTER TABLE `data_meteorologi`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `data_meteorologi_fuzzifikasi`
--
ALTER TABLE `data_meteorologi_fuzzifikasi`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `data_prediksi`
--
ALTER TABLE `data_prediksi`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_meteorologi`
--
ALTER TABLE `data_meteorologi`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_meteorologi_fuzzifikasi`
--
ALTER TABLE `data_meteorologi_fuzzifikasi`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `data_prediksi`
--
ALTER TABLE `data_prediksi`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
