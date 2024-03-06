-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2021 at 07:20 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotify`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `artwork_path` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `title`, `artist`, `genre`, `artwork_path`) VALUES
(1, 'Bacon and Eggs', 2, 4, 'assets/images/artwork/clearday.jpg'),
(2, 'Pizza Head', 5, 10, 'assets/images/artwork/energy.jpg'),
(3, 'Best beats', 4, 6, 'assets/images/artwork/funkyelement.jpg'),
(4, 'Best of the Worst', 3, 9, 'assets/images/artwork/goinghigher.jpg'),
(5, 'Summer Hits', 2, 5, 'assets/images/artwork/popdance.jpg'),
(6, 'The move soundtrack', 5, 3, 'assets/images/artwork/sweet.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`) VALUES
(1, 'Micky Mouse'),
(2, 'Goofy'),
(3, 'bart simpson'),
(4, 'Homer'),
(5, 'Bruce Lee');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Rock'),
(2, 'Pop'),
(3, 'Hip-hop'),
(4, 'Rap'),
(5, 'R & B'),
(6, 'Classical'),
(7, 'Techno'),
(8, 'Jazz'),
(9, 'Folk'),
(10, 'Country');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `owner`, `date_created`) VALUES
(2, 'Playlist 2', 'Mustafaomari', '2021-11-22 00:00:00'),
(3, 'Playlist 3', 'Mustafaomari', '2021-11-22 00:00:00'),
(15, 'jazz', 'Mustafaomari', '2021-12-02 00:00:00'),
(16, 'relax', 'Mustafaomari', '2021-12-02 00:00:00'),
(17, 'classic', 'Mustafaomari', '2021-12-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `playlistsongs`
--

CREATE TABLE `playlistsongs` (
  `id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `playlist_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `playlistsongs`
--

INSERT INTO `playlistsongs` (`id`, `song_id`, `playlist_id`, `playlist_order`) VALUES
(3, 5, 2, 1),
(5, 9, 16, 3),
(6, 15, 3, 3),
(7, 15, 17, 0),
(8, 23, 16, 4),
(9, 13, 15, 0),
(12, 13, 3, 4),
(13, 13, 2, 3),
(14, 13, 16, 5),
(15, 13, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `artist` int(11) NOT NULL,
  `album` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `duration` varchar(8) NOT NULL,
  `path` varchar(500) NOT NULL,
  `album_order` int(11) NOT NULL,
  `plays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `artist`, `album`, `genre`, `duration`, `path`, `album_order`, `plays`) VALUES
(1, 'epic', 1, 1, 8, '2:58', 'assets/music/bensound-epic.mp3', 1, 24),
(2, 'A new beginning', 1, 5, 1, '2:35', 'assets/music/bensound-anewbeginning.mp3', 2, 14),
(3, 'Better Days', 1, 5, 2, '2:33', 'assets/music/bensound-betterdays.mp3', 3, 19),
(4, 'Buddy', 1, 5, 3, '2:02', 'assets/music/bensound-buddy.mp3', 4, 11),
(5, 'Clear Day', 1, 5, 4, '1:29', 'assets/music/bensound-clearday.mp3', 5, 19),
(6, 'Going Higher', 2, 1, 1, '4:04', 'assets/music/bensound-goinghigher.mp3', 1, 23),
(7, 'Funny Song', 2, 4, 2, '3:07', 'assets/music/bensound-funnysong.mp3', 2, 10),
(8, 'Funky Element', 2, 1, 3, '3:08', 'assets/music/bensound-funkyelement.mp3', 2, 24),
(9, 'Extreme Action', 2, 1, 4, '8:03', 'assets/music/bensound-extremeaction.mp3', 3, 23),
(10, 'Epic', 2, 4, 5, '2:58', 'assets/music/bensound-epic.mp3', 3, 27),
(11, 'Energy', 2, 1, 6, '2:59', 'assets/music/bensound-energy.mp3', 4, 15),
(12, 'Dubstep', 2, 1, 7, '2:03', 'assets/music/bensound-dubstep.mp3', 5, 13),
(13, 'Happiness', 3, 6, 8, '4:21', 'assets/music/bensound-happiness.mp3', 5, 12),
(14, 'Happy Rock', 3, 6, 9, '1:45', 'assets/music/bensound-happyrock.mp3', 4, 19),
(15, 'Jazzy Frenchy', 3, 6, 10, '1:44', 'assets/music/bensound-jazzyfrenchy.mp3', 3, 20),
(16, 'Little Idea', 3, 6, 1, '2:49', 'assets/music/bensound-littleidea.mp3', 2, 18),
(17, 'Memories', 3, 6, 2, '3:50', 'assets/music/bensound-memories.mp3', 1, 27),
(18, 'Moose', 4, 7, 1, '2:43', 'assets/music/bensound-moose.mp3', 5, 7),
(19, 'November', 4, 7, 2, '3:32', 'assets/music/bensound-november.mp3', 4, 9),
(20, 'Of Elias Dream', 4, 7, 3, '4:58', 'assets/music/bensound-ofeliasdream.mp3', 3, 8),
(21, 'Pop Dance', 4, 7, 2, '2:42', 'assets/music/bensound-popdance.mp3', 2, 10),
(22, 'Retro Soul', 4, 7, 5, '3:36', 'assets/music/bensound-retrosoul.mp3', 1, 11),
(23, 'Sad Day', 5, 2, 1, '2:28', 'assets/music/bensound-sadday.mp3', 1, 11),
(24, 'Sci-fi', 5, 2, 2, '4:44', 'assets/music/bensound-scifi.mp3', 2, 8),
(25, 'Slow Motion', 5, 2, 3, '3:26', 'assets/music/bensound-slowmotion.mp3', 3, 10),
(26, 'Sunny', 5, 2, 4, '2:20', 'assets/music/bensound-sunny.mp3', 4, 15),
(27, 'Sweet', 5, 2, 5, '5:07', 'assets/music/bensound-sweet.mp3', 5, 17),
(28, 'Tenderness ', 3, 3, 7, '2:03', 'assets/music/bensound-tenderness.mp3', 4, 21),
(29, 'The Lounge', 3, 3, 8, '4:16', 'assets/music/bensound-thelounge.mp3 ', 3, 23),
(30, 'Ukulele', 3, 3, 9, '2:26', 'assets/music/bensound-ukulele.mp3 ', 2, 33),
(31, 'Tomorrow', 3, 3, 1, '4:54', 'assets/music/bensound-tomorrow.mp3 ', 1, 21),
(32, 'Acoustic Breeze', 1, 5, 8, '2:37', 'assets/music/bensound-acousticbreeze.mp3', 1, 22);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(32) NOT NULL,
  `signup_date` datetime NOT NULL,
  `profile_pic` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `password`, `signup_date`, `profile_pic`) VALUES
(1, 'MustafaOmari', 'Mustafa', 'Omari', 'Mustafa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-10-26 00:00:00', 'assets/images/profile-pics/head_emerald.png'),
(2, 'omaromari', 'Omari', 'Omari', 'Omar@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2021-10-26 00:00:00', 'assets/images/profile-pics/head_emerald.png');

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
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlistsongs`
--
ALTER TABLE `playlistsongs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `playlistsongs`
--
ALTER TABLE `playlistsongs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
