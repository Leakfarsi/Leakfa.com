-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 09, 2022 at 07:44 PM
-- Server version: 5.7.14-google-log
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leakfaco`
--

-- --------------------------------------------------------

--
-- Table structure for table `breach_item`
--

CREATE TABLE `breach_item` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbr` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `breach_item`
--

INSERT INTO `breach_item` (`id`, `name`, `abbr`) VALUES
(1, 'نام', 'first'),
(2, 'نام خانوادگی', 'last'),
(3, 'نام کاربری', 'username'),
(4, 'شناسه کاربری', 'userid'),
(5, 'شماره تلفن ثابت', 'landline'),
(6, 'شماره تلفن همراه', 'mobile'),
(7, 'کلمه عبور', 'pass'),
(8, 'آدرس IP', 'ip'),
(9, 'آدرس ایمیل', 'email'),
(10, 'شهر', 'city'),
(11, 'استان', 'state'),
(12, 'محل اقامت', 'residence'),
(13, 'کد پستی', 'post'),
(14, 'شماره ملی', 'nid');

-- --------------------------------------------------------

--
-- Table structure for table `breach_log`
--

CREATE TABLE `breach_log` (
  `id` int(11) NOT NULL,
  `hash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breach_source`
--

CREATE TABLE `breach_source` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `round_k` int(11) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` date NOT NULL,
  `major` tinyint(1) NOT NULL DEFAULT '0',
  `file` tinyint(1) NOT NULL DEFAULT '0',
  `type` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `anchor` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `search_log`
--

CREATE TABLE `search_log` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hash` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbreach` tinyint(1) NOT NULL DEFAULT '0',
  `ip` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_item`
--

CREATE TABLE `source_item` (
  `id` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `item` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_tag`
--

CREATE TABLE `source_tag` (
  `id` int(11) NOT NULL,
  `source` int(11) NOT NULL,
  `tag` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE `stat` (
  `id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unique_hash` int(11) NOT NULL,
  `total_pop` int(11) NOT NULL,
  `total_pop_month` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hit` int(11) NOT NULL,
  `no_hit` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `name` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `class` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `breach_item`
--
ALTER TABLE `breach_item`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `breach_log`
--
ALTER TABLE `breach_log`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `source` (`source`) USING BTREE,
  ADD KEY `hash` (`hash`) USING BTREE;

--
-- Indexes for table `breach_source`
--
ALTER TABLE `breach_source`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `search_log`
--
ALTER TABLE `search_log`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `source_item`
--
ALTER TABLE `source_item`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `item` (`item`) USING BTREE,
  ADD KEY `source` (`source`) USING BTREE;

--
-- Indexes for table `source_tag`
--
ALTER TABLE `source_tag`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `source_tag_ibfk_1` (`source`) USING BTREE,
  ADD KEY `source_tag_ibfk_2` (`tag`) USING BTREE;

--
-- Indexes for table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `breach_item`
--
ALTER TABLE `breach_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `breach_log`
--
ALTER TABLE `breach_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `breach_source`
--
ALTER TABLE `breach_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_log`
--
ALTER TABLE `search_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_item`
--
ALTER TABLE `source_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_tag`
--
ALTER TABLE `source_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stat`
--
ALTER TABLE `stat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
