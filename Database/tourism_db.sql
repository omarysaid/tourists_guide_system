-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2024 at 02:32 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tourism_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `attraction_id` int(11) NOT NULL,
  `region_id` int(11) NOT NULL,
  `district` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`attraction_id`, `region_id`, `district`, `name`, `description`, `image`) VALUES
(18, 1, 'Kibaha', 'Shavavile hollow', 'Stretching over 2,300 kilometers along the Queensland coast, the Great Barrier Reef is the world\'s largest coral reef system. Dive into its crystal-clear waters to discover a kaleidoscope of marine life, including vibrant coral reefs, tropical fish, and majestic sea turtles. Snorkeling, scuba diving, and glass-bottom boat tours offer unparalleled opportunities to explore this natural marvel.', 0x61312e6a7067),
(19, 1, 'Rufiji', 'Handeni kisewe', 'Stretching over 2,300 kilometers along the Queensland coast, the Great Barrier Reef is the world\'s largest coral reef system. Dive into its crystal-clear waters to discover a kaleidoscope of marine life, including vibrant coral reefs, tropical fish, and majestic sea turtles. Snorkeling, scuba diving, and glass-bottom boat tours offer unparalleled opportunities to explore this natural marvel.', 0x61322e6a706567),
(20, 1, 'Bagamoyo', 'Horoya hills', 'Stretching over 2,300 kilometers along the Queensland coast, the Great Barrier Reef is the world\'s largest coral reef system. Dive into its crystal-clear waters to discover a kaleidoscope of marine life, including vibrant coral reefs, tropical fish, and majestic sea turtles. Snorkeling, scuba diving, and glass-bottom boat tours offer unparalleled opportunities to explore this natural marvel.', 0x61332e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `region_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_name` blob NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`region_id`, `name`, `image_name`, `description`) VALUES
(1, 'Arusha', 0x726567696f6e5f363636326663393634316130372e6a7067, 'Pwani Region, also known as the Coast Region, is one of Tanzania\'s 31 administrative regions. Here are some key details about Pwani Region:\r\nLocation: Pwani Region is located in the eastern part of Tanzania, along the Indian Ocean coastline. It borders Dar es Salaam to the southeast, Morogoro Region to the west, Tanga Region to the north, and Lindi Region to the south.\r\n\r\nEconomy: The economy of Pwani Region is predominantly based on agriculture, fishing, and small-scale industries. Key agricultural products include cashew nuts, coconuts, sisal, and various fruits and vegetables. Fishing is an important livelihood for communities along the coast. Additionally, the region is experiencing growth in industrial activities, especially around the town of Bagamoyo.'),
(2, 'KIlimanjaro', 0x6b696c696d2e6a706567, ' Nestled high in the Andes Mountains, Machu Picchu is an ancient Incan citadel shrouded in mist and mystery. This UNESCO World Heritage site offers visitors a glimpse into the remarkable engineering and spiritual significance of the Inca civilization. Trek along the Inca Trail or take a scenic train ride to reach this awe-inspiring archaeological wonder.'),
(3, 'Mbeya', 0x6b692e6a7067, ' Nestled high in the Andes Mountains, Machu Picchu is an ancient Incan citadel shrouded in mist and mystery. This UNESCO World Heritage site offers visitors a glimpse into the remarkable engineering and spiritual significance of the Inca civilization. Trek along the Inca Trail or take a scenic train ride to reach this awe-inspiring archaeological wonder.'),
(6, 'Arusha', 0x6b696c692e6a7067, ' Nestled high in the Andes Mountains, Machu Picchu is an ancient Incan citadel shrouded in mist and mystery. This UNESCO World Heritage site offers visitors a glimpse into the remarkable engineering and spiritual significance of the Inca civilization. Trek along the Inca Trail or take a scenic train ride to reach this awe-inspiring archaeological wonder.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `country` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(30) NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `gender`, `country`, `phone`, `email`, `password`, `usertype`, `created`) VALUES
(1, 'omollo edward givenality', 'Male', 'Tanzania', '0672488849', 'omollo@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Tour_guider', '2024-06-01'),
(5, 'Helman Othamn Helmanmbmbvnccn', 'Male', 'Tanzania bm vcv ', '0989878765', 'helmanothman@gmail.com', 'dea7df9b5f2ff24756d5471091cf9b27', 'Normal_user', '2024-06-01'),
(6, 'Yussuph Helman Othman', 'Male', 'Kenya', '10989878765', 'yusuphmain@gmail.com', 'fcea920f7412b5da7be0cf42b8c93759', 'Normal_user', '2024-06-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`attraction_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`region_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `attraction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `region_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attractions`
--
ALTER TABLE `attractions`
  ADD CONSTRAINT `attractions_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`region_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
