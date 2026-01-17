-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 17, 2026 at 02:22 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `netflix_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

DROP TABLE IF EXISTS `movies`;
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `category` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'movie',
  `full_video_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobile_image_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `video_url`, `image_url`, `logo_url`, `description`, `category`, `full_video_url`, `mobile_image_url`) VALUES
(1, 'Castlevania', 'https://res.cloudinary.com/distnohny/video/upload/v1767910468/Castlevania_Season_4_wtp1jl.mp4', 'AAAABZVrzA8Ia871uu3_yjtLaoCBwWAJpoRRqez1rqEdRhQ8H6BPOe9bCViXTVj0eMgL1AeVNJde1e1jnSlGaeOYeekTygxdChGMEjgi.webp', 'castlevaniapic.webp', 'Dracula\'s influence looms large as Belmont and Sypha investigate plans to resurrect the notorious vampire.', 'tv', 'https://drive.google.com/file/d/1YVCHoOq2ZzAM4Q8_1-mu3kJKYpesd6cz/preview', 'download (2).jpeg'),
(2, 'Dan Da Dan', 'https://res.cloudinary.com/distnohny/video/upload/v1767910427/DAN_DA_DAN___OFFICIAL_TRAILER_1_qity0t.mp4', 'dandadan 34.jpg', 'dandan.webp', 'A high school girl who believes in ghosts and a classmate who believes in aliens face supernatural encounters.', 'tv', 'https://drive.google.com/file/d/1vJhQlKNUsJU-dWfIVgM4DvUSlHleObfV/preview', 'pinit.jpeg'),
(3, 'BoJack Horseman', 'https://res.cloudinary.com/distnohny/video/upload/v1767910478/BoJack_Horseman___Season_6_Final_Trailer___Netflix_1_yq85pe.mp4', 'bobo.jpg', 'bojack logo.webp', 'Meet the most beloved sitcom horse of the 90s, 20 years later.', 'tv', 'https://drive.google.com/file/d/1MnkabQCQODlu5rkCDjapuYrYt32UqEo4/preview', 'download.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `my_list`
--

DROP TABLE IF EXISTS `my_list`;
CREATE TABLE IF NOT EXISTS `my_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `my_list`
--

INSERT INTO `my_list` (`id`, `user_id`, `movie_id`) VALUES
(1, 2, 3),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
CREATE TABLE IF NOT EXISTS `notes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `movie_id` (`movie_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `movie_id`, `created_at`) VALUES
(3, 6, 2, '2026-01-17 13:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `profile_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `profile_name`, `profile_img`) VALUES
(6, 6, 'kolise', 'AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profile_img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `profile_img`) VALUES
(6, 'anikolise@gmail.com', '$2y$10$7leHOSpkgXs4uRPbNhYjBeHTof2MqWRC.cGlBpiWjO6HiHPkwTloe', '2026-01-17 13:12:10', 'AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
