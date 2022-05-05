-- phpMyAdmin SQL Dump
-- version 5.0.4deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 05, 2022 at 06:45 PM
-- Server version: 10.5.15-MariaDB-0+deb11u1
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `forename` varchar(16) NOT NULL,
  `surname` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `phonenumber` text NOT NULL,
  `app_date` varchar(16) NOT NULL,
  `app_details` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(16) NOT NULL,
  `s_details` varchar(256) NOT NULL,
  `s_timeframe_hours` decimal(2,1) NOT NULL,
  `s_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`s_id`, `s_name`, `s_details`, `s_timeframe_hours`, `s_price`) VALUES
(1, 'Movement Mapping', 'Movement Mapping combines the best of flow yoga with mobility training, human locomotive patterns, planes of movement, and progress learning principles in a truly fluid and adaptable practice.', '1.0', '10.00'),
(2, 'Sports Massage', 'Sports massage is a form of massage involving the manipulation of soft tissue to benefit a person engaged in regular physical activity. Soft tissue is connective tissue that has not hardened into bone and cartilage.', '1.0', '10.00'),
(3, 'Cupping', 'A therapy in which heated glass cups are applied to the skin along the meridians of the body, creating suction and believed to stimulate the flow of energy.', '1.0', '5.00'),
(4, 'K Tape', 'Elastic therapeutic tape, also called kinesiology tape or k-tape, or KT is an elastic cotton strip with an acrylic adhesive that is purported to ease pain and disability from athletic injuries and a variety of other physical disorders.', '1.0', '5.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `forename` varchar(16) NOT NULL,
  `surname` varchar(16) NOT NULL,
  `email` varchar(32) NOT NULL,
  `phonenumber` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `forename`, `surname`, `email`, `phonenumber`, `username`, `password`, `created_at`) VALUES
(1, 'Website', 'Admin', '', '0', 'websiteadmin', '$2y$10$xtCklZp.B2KoyExvQzmja.RLUc/vRUk22AiTt2UJ0Qa6Oblc/BdCS', '2022-04-25 17:00:10'),
(5, 'Jamiee', 'Shoreyy', 'jamieshorey42@gmail.com', '07933695060', 'bodinbuster', '$2y$10$6WjBzjMlQiWOc/coAYOhqOpxfm3weqvCNXw2s86ouvdAgwnQUnyVa', '2022-04-29 11:58:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`s_id`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
