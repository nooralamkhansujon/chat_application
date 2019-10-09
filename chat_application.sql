-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2019 at 08:22 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(255) NOT NULL,
  `to_user_id` int(200) NOT NULL,
  `from_user_id` int(200) NOT NULL,
  `chat_message` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 2, 1, 'Hi,jairkhan', '0000-00-00 00:00:00', 0),
(2, 2, 1, 'Kita koro?', '2019-10-07 15:49:10', 0),
(3, 2, 1, 'HI,jakirkhan', '2019-10-07 22:52:31', 0),
(4, 2, 1, 'Tui akhon ki koros?', '2019-10-07 22:57:25', 0),
(5, 3, 1, 'Jibon Dev akta beyadob?', '2019-10-07 23:08:53', 0),
(6, 2, 1, 'khobor ki?', '2019-10-07 23:15:53', 0),
(7, 3, 2, 'Kitare jibon?', '2019-10-07 23:30:36', 0),
(8, 1, 3, 'ti naki?', '2019-10-07 23:33:54', 0),
(9, 2, 1, 'kal collage khola naki ?', '2019-10-08 00:10:36', 0),
(10, 3, 1, 'ami to vala na vala loya thaiko?', '2019-10-08 00:19:17', 0),
(11, 2, 1, 'Ki korbo akhon?', '2019-10-08 00:28:25', 0),
(12, 3, 1, 'kal collage jabon naki?', '2019-10-08 00:39:35', 0),
(13, 2, 1, '😅', '2019-10-08 14:39:38', 0),
(14, 2, 1, 'Kitabae ?😗', '2019-10-08 14:49:26', 2),
(15, 0, 2, 'Ki koro sobai?', '2019-10-08 23:46:35', 1),
(16, 0, 4, 'Kal ki collage Khola naki na?          ', '2019-10-08 23:56:00', 1),
(17, 0, 1, '<p>\n                 <img src=\"upload/2019-08-15-13-13-39-528.jpg\" class=\"img-thumbnail\" width=\"200\" height=\"160\"></p> <br>', '2019-10-09 09:49:52', 1),
(18, 0, 1, 'ami to bala na vala loya thaiko?', '2019-10-09 12:08:01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(255) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`) VALUES
(1, 'nooralam', '0d018e584086320b9118547201d14c6e'),
(2, 'jakirkhan', '0d018e584086320b9118547201d14c6e'),
(3, 'jibon Dev', '0d018e584086320b9118547201d14c6e'),
(4, 'atikulislam', '0d018e584086320b9118547201d14c6e'),
(5, 'manik', '0d018e584086320b9118547201d14c6e');

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(255) NOT NULL,
  `user_id` int(200) NOT NULL,
  `last_activity` datetime NOT NULL,
  `is_type` enum('yes','no') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 1, '0000-00-00 00:00:00', NULL),
(2, 1, '0000-00-00 00:00:00', NULL),
(3, 1, '2019-10-09 23:33:27', 'no'),
(4, 2, '2019-10-07 23:32:49', NULL),
(5, 3, '2019-10-08 10:23:46', 'no'),
(6, 2, '2019-10-09 14:30:56', 'no'),
(7, 3, '2019-10-08 23:49:30', NULL),
(8, 4, '2019-10-09 00:11:00', 'no'),
(9, 5, '2019-10-10 00:22:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
