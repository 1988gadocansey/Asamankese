-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2016 at 11:06 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angel_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms`
--

CREATE TABLE IF NOT EXISTS `tbl_sms` (
  `id` int(200) NOT NULL,
  `number` varchar(20) NOT NULL,
  `message` varchar(9000) NOT NULL,
  `status` varchar(900) NOT NULL,
  `dates` varchar(900) NOT NULL,
  `type` varchar(200) NOT NULL,
  `name` mediumtext NOT NULL,
  `term` int(11) NOT NULL,
  `year` varchar(50) NOT NULL,
  `sent_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sms`
--

INSERT INTO `tbl_sms` (`id`, `number`, `message`, `status`, `dates`, `type`, `name`, `term`, `year`, `sent_by`) VALUES
(2, '+233505284060', 'dmskdmksmdk', 'Not Delivered', '1456980728', '', '20501001', 0, '', 0),
(3, '+233505284060', 'hi gadoo', 'Not Delivered', '1457687863', '', '20501001', 0, '2015/2016', 0),
(4, '+233505284060', 'dsdsdkjskd', 'Delivered', '1457688860', '', '20501001', 0, '2016', 0),
(5, '+233505284060', 'hi gad', 'Delivered', '1457689037', '', '20501001', 0, '2016', 0),
(6, '+233505284060', 'mmm', 'Not Delivered', '1458115386', '', '', 0, '2015/2016', 0),
(7, '+233505284060', 'aksjkajsk', 'Not Delivered', '1458115495', '', '', 0, '2015/2016', 13423);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_sms`
--
ALTER TABLE `tbl_sms`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_sms`
--
ALTER TABLE `tbl_sms`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
