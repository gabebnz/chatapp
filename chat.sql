-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2019 at 12:57 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tweetid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `msg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` (`tweetid`, `userid`, `posted`, `msg`) VALUES
(19, 1, '2019-08-01 11:05:14', 'Hello Big testing'),
(24, 1, '2019-08-05 14:20:20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad mini.'),
(36, 1, '2019-08-05 15:10:48', '<img src=\"css/pardon.gif\">'),
(52, 1, '2019-08-08 11:07:55', 'Foam cakes are cakes with very little (if any) fatty material such as butter, oil or shortening. They are leavened primarily by the air that'),
(56, 1, '2019-08-09 09:53:04', '<img src=\"css/poppin.gif\">'),
(60, 1, '2019-08-09 10:02:46', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse a consectetur urna. Duis eleifend scelerisque ipsum, vel porttitor enim sagittis et. Fusce auctor aliquam molestie. Duis id nisl vel dolor faucibus sollicitudin ligmanuts.'),
(61, 2, '2019-08-09 10:05:30', 'Hello, this is a test.'),
(64, 1, '2019-08-09 10:06:25', 'Nunc orci lorem, gravida posuere turpis in, tincidunt fringilla felis. Cras laoreet metus id est molestie scelerisque. Fusce molestie justo eu eros tristique interdum. Sed malesuada pulvinar est, vel commodo urna consequat nec. Fusce eget.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `created_at`, `admin`) VALUES
(1, 'Gabe', 'Vortex', '$2y$10$ykugi7Sm9SUc1tYM/Mn7Fue1WrpxmcdHcYOsKdaGE5JEuaLrLpwT6', '2019-08-01 11:03:45', 1),
(2, 'Test User', 'TestingBot', '$2y$10$49hcemzU6FY05l4I.TnY3.BlzwszCKWF/VBlrG4JmyiUxhJaX.NQG', '2019-08-09 10:05:03', 0),
(3, 'dddd', 'd', '$2y$10$r50h6pKkFI7tmNghTJBoH.z3ceSLhZ/DBQcYWqkZHANKBZcKvEL/e', '2019-08-16 10:01:21', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweetid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tweets`
--
ALTER TABLE `tweets`
  MODIFY `tweetid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
