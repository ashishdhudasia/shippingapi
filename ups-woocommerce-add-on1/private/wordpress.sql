-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2023 at 01:35 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wordpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_ibconfig`
--

CREATE TABLE `wp_ibconfig` (
  `ib_id` int(11) NOT NULL AUTO_INCREMENT,
  `ib_api_key` varchar(255) DEFAULT NULL,
  `ib_api_secret` varchar(255) DEFAULT NULL,
  `ib_connection_id` varchar(255) DEFAULT NULL,
  `ib_account_name` varchar(50) DEFAULT NULL,
  `ib_account_status` varchar(50) DEFAULT NULL,
  `ib_created_date` datetime DEFAULT NULL,
  `ib_updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`ib_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wp_ibconfig`
--
ALTER TABLE `wp_ibconfig`
  ADD PRIMARY KEY (`ib_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wp_ibconfig`
--
ALTER TABLE `wp_ibconfig`
  MODIFY `ib_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
