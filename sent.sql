-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2016 at 09:12 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `holyco`
--

-- --------------------------------------------------------

--
-- Table structure for table `sent`
--

CREATE TABLE IF NOT EXISTS `sent` (
  `id` int(200) NOT NULL,
  `number` varchar(20) NOT NULL,
  `message` varchar(9000) NOT NULL,
  `status` varchar(900) NOT NULL,
  `dates` varchar(900) NOT NULL,
  `type` varchar(200) NOT NULL,
  `name` varchar(2000) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sent`
--

INSERT INTO `sent` (`id`, `number`, `message`, `status`, `dates`, `type`, `name`) VALUES
(86, '0244064636', 'try', 'Not Delivered', '1338755463', 'Staff', 'JOHN ARTHUR'),
(87, '0243501509', 'try', 'Not Delivered', '1338755463', 'Staff', 'THOMAS BEN. ACHEAMPONG'),
(88, '0244', 'try', 'Not Delivered', '1338755463', 'Staff', 'ISAAC IGNATIUS YANKEY'),
(89, '0244543514', 'try', 'Not Delivered', '1338755463', 'Staff', 'BOB ABEIKU HEMANS'),
(90, '0244219579', 'try', 'Not Delivered', '1338755567', 'Staff', 'john okrah'),
(91, '233247754778', 'try 3', 'Not Delivered', '1338756759', 'Student', ' Ivy Naa Aku  Allotey'),
(92, '233269808082', 'try 3', 'Not Delivered', '1338756759', 'Student', 'Jennifer  Allotey'),
(93, '233247754778', 'try', 'Not Delivered', '1338756906', 'Student', ' Ivy Naa Aku  Allotey'),
(94, '233247754778', 'from holyshil', 'Delivered', '1023280495', 'Student', ' Ivy Naa Aku  Allotey'),
(95, '233269808082', 'try', 'Delivered', '1023280936', 'Staff', 'alex allotey'),
(96, '0269808082', 'ttt', 'Delivered', '1023280987', 'Staff', 'alex allotey'),
(97, '233269808082', 'hello', 'Delivered', '1379587203', 'Student', 'Helena  Adiamah'),
(98, '233269808082', 'hello', 'Delivered', '1379587220', 'Student', 'Helena  Adiamah'),
(99, '233247754778', 'hello', 'Delivered', '1379587221', 'Student', ' Ivy Naa Aku  Allotey'),
(100, '233269808082', 'hello', 'Delivered', '1379587223', 'Student', 'Jennifer  Allotey'),
(101, '233269808082', 'try 2', 'Delivered', '1379587344', 'Student', 'Helena  Adiamah'),
(102, '233269808082', 'try 3', 'Delivered', '1379587395', 'Student', 'Helena  Adiamah'),
(103, '233247754778', 'try 3', 'Delivered', '1379587396', 'Student', ' Ivy Naa Aku  Allotey'),
(104, '233269808082', 'the try 2', 'Delivered', '1379685382', 'Student', 'Helena  Adiamah'),
(105, '233247754778', 'try 45', 'Delivered', '1379685491', 'Student', ' Ivy Naa Aku  Allotey'),
(106, '233247754778', 'the try 2', 'Delivered', '1387205046', 'Student', ' Ivy Naa Aku  Allotey'),
(107, '233244543514', 'try from alex', 'Delivered', '1387205277', 'Student', 'Samantha Asheley  Amarhfio'),
(108, '233269808082', 'try again', 'Delivered', '1387206901', 'Student', 'Helena  Adiamah'),
(109, '233269808082', 'from me to me', 'Not Delivered', '1387215770', 'Student', 'Helena  Adiamah'),
(110, '233269808082', 'sent again', 'Delivered', '1387216014', 'Student', 'Helena  Adiamah'),
(111, '233269808082', 'now now', 'Delivered', '1387216103', 'Student', 'Helena  Adiamah'),
(112, '233269808082', 'Name: Helena  Adiamah Form:1C1 Term:3 Grades: CRS=A1, ', 'Delivered', '1391508281', 'Student', 'Helena  Adiamah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sent`
--
ALTER TABLE `sent`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sent`
--
ALTER TABLE `sent`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=113;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
