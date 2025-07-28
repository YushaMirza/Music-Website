-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2025 at 05:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist` varchar(50) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `release_year` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('published','pending') DEFAULT 'published',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `songs` varchar(255) DEFAULT NULL,
  `videos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `cover_image`, `release_year`, `description`, `status`, `created_at`, `updated_at`, `songs`, `videos`) VALUES
(3, 'Eminem', 'Tommy Richman', 'eminem.jpeg', 1999, 'asdsa', 'published', '2025-07-14 19:51:02', '2025-07-18 12:41:36', ' pizzazz,', 'Ocean Music'),
(4, 'Mystique', 'Tommy Richman', 'mystique.jpeg', 2000, 'qwdwqd', 'published', '2025-07-14 19:51:36', '2025-07-14 20:24:48', ' pizzazz,Made', 'Pink Moon'),
(5, 'Sphere', 'Akintoye', 'sphere.jpeg', 2000, 'wsfdf', 'published', '2025-07-14 19:52:06', '2025-07-14 19:52:06', 'MILLION DOLLAR BABY', 'Green Day'),
(6, 'Star Boy', 'Adam Port', 'starboy.jpeg', 1998, 'dsda', 'published', '2025-07-14 19:52:28', '2025-07-15 05:29:00', ' Optimist,', 'One Direction'),
(7, 'Symphony', 'ASTN', 'symphony.jpeg', 2024, 'dsa', 'published', '2025-07-14 19:52:49', '2025-07-14 19:52:49', 'Gradually', 'One Direction');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) NOT NULL,
  `genres` varchar(255) NOT NULL,
  `biography` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(10) DEFAULT 'active',
  `language` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `country`, `genres`, `biography`, `image`, `date_added`, `status`, `language`) VALUES
(11, 'ASTN', 'sxsaxsa', 'Rock', 'asdsa', 'astn.jpeg', '2025-07-14 19:29:33', 'active', 'sadsada'),
(12, 'Tommy Richman', 'aDAs', 'Hip-Hop', 'aSASAs', 'tommy.jpeg', '2025-07-14 19:29:51', 'active', 'dasSs'),
(13, 'Adam Port', 'asda', 'Rock', 'asas', 'adam.jpeg', '2025-07-14 19:30:09', 'active', 'aSA'),
(14, 'Akintoye', 'asdsasd', 'Hip-Hop', 'asdasd', 'akintoye.jpeg', '2025-07-14 19:31:07', 'active', 'asdfasdd');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `type` enum('artist','year','genre','language','album') NOT NULL,
  `value` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `type`, `value`) VALUES
(1, 'genre', 'YUHsa');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Yusha Mirza', 'yousha.mirza1987@gmail.com', 'GREAT', '2025-07-08 17:17:16'),
(2, 'Yusha MIrza', 'yousha.mirza328@gmail.com', 'werwefwd', '2025-07-08 17:18:28'),
(3, 'Yusha Mirza', 'yousha.mirza1987@gmail.com', 'GREAT', '2025-07-08 17:19:52'),
(4, 'Yusha Mirza', 'yousha.mirza1987@gmail.com', 'qwerty', '2025-07-08 17:21:13'),
(5, 'Yusha Mirza', 'yousha.mirza1987@gmail.com', 'qwerty', '2025-07-08 17:24:11'),
(6, 'Yusha MIrza', 'yousha.mirza1987@gmail.com', 'qwert', '2025-07-08 17:28:01'),
(7, 'Yusha MIrza', 'yousha.mirza1987@gmail.com', 'qwerty', '2025-07-08 17:29:15'),
(8, 'user', 'user@gmail.com', 'user', '2025-07-08 17:30:27'),
(9, 'user', 'user@gmail.com', 'user', '2025-07-08 17:33:04'),
(10, 'user', 'yousha.mirza1987@gmail.com', 'user', '2025-07-08 17:33:44'),
(11, 'user', 'yousha.mirza1987@gmail.com', 'user', '2025-07-08 17:34:19'),
(12, 'user', 'yousha.mirza1987@gmail.com', 'user', '2025-07-08 17:36:17'),
(13, '', '', '', '2025-07-08 17:38:56'),
(14, '', '', '', '2025-07-08 17:38:59'),
(15, '', '', '', '2025-07-21 09:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `song_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `song_id`, `video_id`, `created_at`) VALUES
(1, 3, NULL, 6, '2025-07-21 07:08:01'),
(2, 3, 7, NULL, '2025-07-21 08:02:29'),
(3, 3, NULL, 8, '2025-07-21 08:02:54'),
(4, 5, NULL, 5, '2025-07-21 14:31:34'),
(5, 4, 4, NULL, '2025-07-22 15:32:21'),
(6, 4, NULL, 6, '2025-07-22 15:33:05'),
(7, 4, 6, NULL, '2025-07-22 15:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `user_id`, `item_name`, `item_type`, `rating`, `review`, `created_at`) VALUES
(1, 2, 'Gradually', 'song', 4, 'GREAT VIBES', '2025-07-16 05:37:46'),
(2, 2, 'Tommy Richman', 'artist', 4, 'Best Artist!', '2025-07-16 05:38:41'),
(3, 2, 'Mystique', 'album', 3, 'Enjoyed!', '2025-07-16 05:39:10');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `artist` varchar(100) DEFAULT NULL,
  `album` varchar(100) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `new_flag` varchar(3) DEFAULT '0',
  `type` varchar(15) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `description` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `year`, `genre`, `language`, `image`, `new_flag`, `type`, `file`, `status`, `description`, `date_added`) VALUES
(3, ' Optimist', 'Crash Adams', 'New', '0000', 'Hip-Hop', 'Hindi', 'song-cover1.jpeg', 'NEW', 'song', 'Alex_Warren_-_Ordinary_CeeNaija.com_.mp3', 'published', 'dscxs', '2025-07-14 19:16:48'),
(4, 'Gradually', 'ASTN', '', '1998', 'Electronic', 'Hindi', 'song-cover2.jpeg', '', 'song', 'Rafta Rafta - Atif Aslam 128 Kbps.mp3', 'active', 'aSA', '2025-07-14 19:17:52'),
(5, 'MILLION DOLLAR BABY', 'Tommy Richman', 'New', '2024', 'Electronic', 'Spanish', 'song-cover3.jpeg', 'No', 'song', 'Shape Of You - (Raag.Fm).mp3', 'published', 'asdsads', '2025-07-14 19:18:24'),
(6, ' pizzazz', 'Akintoye', 'New', '2023', 'Hip-Hop', 'Urdu', 'song-cover4.jpeg', 'No', 'song', 'Har Kisi Ko - (Raag.Fm).mp3', 'published', 'aDSASDA', '2025-07-14 19:19:04'),
(7, 'Move', 'Adam Port', 'New', '2000', 'Hip-Hop', 'Hindi', 'song-cover5.jpeg', 'NEW', 'song', 'Die With A Smile - (Raag.Fm).mp3', 'published', 'wrded', '2025-07-14 19:19:37'),
(8, 'Made', 'Tommy Richman', 'Mystique', '2024', 'Hip-Hop', 'Urdu', 'song-cover5.jpeg', 'No', 'song', 'Har Kisi Ko - (Raag.Fm).mp3', 'published', 'sdfsdf', '2025-07-14 20:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` int(11) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `name`, `email`, `password`, `role`, `created_at`, `phone`, `address`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$et3V.3yTUni4.49yXI34MuunO.DVroNd8hV5PVf40T2l0HF.0NwAu', 'admin', '2025-07-15 19:37:12', 0, ''),
(2, 'Yusha Mirza', 'yusha@gmail.com', '$2y$10$.XWUQU5WJ0aSjsbTVMFQLuX416OfDB.P89FLSP7AOG/dkGMWR/pUy', 'user', '2025-07-15 19:38:23', 0, ''),
(3, 'sample', 'sample@gmail.com', '$2y$10$hOApd.btKNO9mttFanicjOLLogxuTmGVFjtZOYShb0YCuIaevcsjC', 'user', '2025-07-17 15:19:40', 0, ''),
(4, 'demo', 'demo@gmail.com', '$2y$10$sCBKcDipvcnAH6i8bvuOeOYryjr.DyqFkwaRfMFpvdQknSz4xk8uu', 'user', '2025-07-21 10:40:15', 0, ''),
(5, 'demo2', 'demo2@gmail.com', '$2y$10$XXVhM6DNsz.UKAhUdjY10eWCkuxZOuM8uZkfgOk270yf.eqbXtb/y', 'user', '2025-07-21 10:47:08', 2147483647, 'Pakistan, Karachi, Federal B Area Block 13');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `artist` varchar(100) DEFAULT NULL,
  `album` varchar(100) DEFAULT NULL,
  `year` year(4) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `new_flag` varchar(3) DEFAULT '0',
  `type` varchar(10) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `title`, `artist`, `album`, `year`, `genre`, `language`, `new_flag`, `type`, `image`, `link`, `status`, `description`, `date_added`) VALUES
(5, 'Boys Dont cry', 'Adam Port', 'Select album (optional)', '2024', 'Hip-Hop', 'English', 'Yes', 'video', 'boysdontcry.jpeg', 'https://www.youtube.com/watch?v=9GkVhgIeGJQ&pp=0gcJCfwAo7VqN5tD', 'Active', 'asdasd', '2025-07-14 19:39:51'),
(6, 'Pink Moon', 'Adam Port', 'Mystique', '2024', 'Electronic', 'English', 'No', 'video', 'pinkmoon.jpeg', 'https://www.youtube.com/watch?v=xqe6TF2y8i4&pp=0gcJCfwAo7VqN5tD', 'Active', 'aSAs', '2025-07-14 19:40:17'),
(7, 'One Direction', 'ASTN', 'Symphony', '2025', 'R&B', 'Urdu', 'Yes', 'video', 'starboy.jpeg', '', 'Active', 'svsdf', '2025-07-14 19:41:10'),
(8, 'Ocean Music', 'Tommy Richman', 'Select album (optional)', '1998', 'Electronic', 'Hindi', 'Yes', 'video', 'oceanmusic.jpeg', 'https://www.youtube.com/watch?v=dy9nwe9_xzw', 'Active', 'ASAS', '2025-07-14 19:41:34'),
(9, 'Green Day', 'Adam Port', 'Select album (optional)', '1998', 'Hip-Hop', 'English', 'Yes', 'video', 'greenday.jpeg', 'https://www.youtube.com/watch?v=Soa3gO7tL-c', 'Active', 'dsad', '2025-07-14 19:42:16'),
(10, 'temp', 'Adam Port', 'Star Boy', '2023', 'Electronic', 'Hindi', 'No', 'video', 'song-cover1.jpeg', 'https://www.youtube.com/watch?v=DyDfgMOUjCI&pp=0gcJCfwAo7VqN5tD', 'Active', 'asdas', '2025-07-15 05:28:59'),
(11, 'Jane Tamanna', 'ASTN', 'Eminem', '2021', 'Pop', 'Urdu', 'Yes', 'video', 'symphony.jpeg', 'https://www.youtube.com/watch?v=sIyOFBRc5Nc', 'published', 'Best', '2025-07-18 12:41:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_fav` (`user_id`,`video_id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_data` (`id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`),
  ADD CONSTRAINT `favorites_ibfk_3` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`),
  ADD CONSTRAINT `fk_favorites_videos` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
