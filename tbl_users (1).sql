-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2017 at 04:53 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gallery`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `userEmail` varchar(100) NOT NULL,
  `num` varchar(15) NOT NULL,
  `userPass` varchar(255) NOT NULL,
  `type` enum('Student','Teacher') NOT NULL,
  `lat` varchar(100) NOT NULL,
  `lng` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `fullName`, `userEmail`, `num`, `userPass`, `type`, `lat`, `lng`) VALUES
(1, 'Prateek', 'prateek@gmail.com', '', 'ec275c8bfb1b38a26cbcc343b78590d711b395bcc4e3adbc8b1c0f0d14c8c15d52ac186bf9fdf0d90f9ee672d49d63f86d3641ecfd5dca453d0bdd0d13358699', 'Student', '13.0732111', '77.50532'),
(2, 'Shilpa', 'maharshiyogalayam@gmail.com', '', '66c7cfc5dd40aa94c553a3f1435bd94151d2a1e2e590d4154c034931fbc6797352ccc4b1091523b01536a117f55f5e4f04f1bf2ac0012b39e1aae57e67fe3da0', 'Student', '', ''),
(3, 'Ananth', 'a@b.com', '245641564', '7d1b4c68c8263e430a7c132a05f39a97141b6ba2294470c4b65a686ec29f55cb8033e43b4ffe7e986141abf3de26fac11a461cf31a8fd33020ad1c742902f21b', 'Teacher', '13.073208699999999', '77.50532679999999'),
(4, 'Prateek', 'prateek12@gmail.com', '123', 'ec275c8bfb1b38a26cbcc343b78590d711b395bcc4e3adbc8b1c0f0d14c8c15d52ac186bf9fdf0d90f9ee672d49d63f86d3641ecfd5dca453d0bdd0d13358699', 'Teacher', '13.073153999999999', '77.5052966'),
(5, 'bhatta', 'b@b.v', '5456', '7d1b4c68c8263e430a7c132a05f39a97141b6ba2294470c4b65a686ec29f55cb8033e43b4ffe7e986141abf3de26fac11a461cf31a8fd33020ad1c742902f21b', 'Student', '13.073236955353233', '77.50547290800398');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
