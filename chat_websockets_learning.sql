-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2021 at 03:33 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat_websockets_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `chatrooms`
--

CREATE TABLE `chatrooms` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `msg` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chatrooms`
--

INSERT INTO `chatrooms` (`id`, `userid`, `msg`, `created_on`) VALUES
(6, 2, 'Hi sstefan29!', '2021-06-24 01:50:06'),
(7, 1, 'hi', '2021-06-24 03:13:11'),
(8, 3, 'ee', '2021-06-24 03:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(10) UNSIGNED NOT NULL,
  `to_user_id` int(10) UNSIGNED NOT NULL,
  `from_user_id` int(10) UNSIGNED NOT NULL,
  `chat_message` text NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Yes','No','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(1, 2, 1, 'ee', '2021-06-24 03:16:42', 'Yes'),
(2, 1, 2, 'ei', '2021-06-24 03:17:36', 'Yes'),
(3, 1, 3, 'eeeee', '2021-06-24 03:20:43', 'Yes'),
(4, 3, 1, 'ee', '2021-06-24 03:30:16', 'Yes'),
(5, 1, 3, 'hi', '2021-06-24 03:31:31', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `chat_user_table`
--

CREATE TABLE `chat_user_table` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_email` varchar(250) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_profile` varchar(100) NOT NULL,
  `user_status` enum('Disabled','Enable') NOT NULL,
  `user_created_on` datetime NOT NULL,
  `user_verification_code` varchar(100) NOT NULL,
  `user_login_status` enum('Logout','Login') NOT NULL,
  `user_token` text NOT NULL,
  `user_connection_id` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat_user_table`
--

INSERT INTO `chat_user_table` (`user_id`, `user_name`, `user_email`, `user_password`, `user_profile`, `user_status`, `user_created_on`, `user_verification_code`, `user_login_status`, `user_token`, `user_connection_id`) VALUES
(1, 'sstefan29', 'stefan.momcilovic001@gmail.com', 'test', 'assets/images/1624488283.png', 'Enable', '2021-06-24 00:44:43', 'c04107e86967e2555fd2cd4ccf7d14f2', 'Login', '8f12690c1fd07f5ca4909c148cb7610e', '104'),
(2, 'johndoe', 'johndoe@gmail.com', 'test', 'assets/images/1624490816.png', 'Enable', '2021-06-24 01:26:56', 'd21d514c5d859884452343b79da4f26d', 'Logout', '8ba8de994664ad88af959ec7e801c483', '100'),
(3, 'test', 'test@example.com', 'test', 'assets/images/1624497621.png', 'Enable', '2021-06-24 03:20:21', 'ff03ee70fd7683f7b21f30875fab1c05', 'Login', '60fa3f934e6acd7bf4072c0616208f82', '91');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chatrooms`
--
ALTER TABLE `chatrooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chatrooms`
--
ALTER TABLE `chatrooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat_user_table`
--
ALTER TABLE `chat_user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
