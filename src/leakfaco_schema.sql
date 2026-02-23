-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:80
-- Generation Time: Jan 01, 2026 at 00:00 AM
-- Server version: 5.0.00
-- PHP Version: 8.0.0

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
-- Table structure for table `breach_hash`
--

CREATE TABLE `breach_hash` (
  `id` bigint UNSIGNED NOT NULL,
  `hash` binary(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breach_hash_temp`
--

CREATE TABLE `breach_hash_temp` (
  `id` bigint UNSIGNED NOT NULL,
  `hash` binary(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breach_item`
--

CREATE TABLE `breach_item` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbr` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breach_relation`
--

CREATE TABLE `breach_relation` (
  `hash_id` bigint UNSIGNED NOT NULL,
  `source_id` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `breach_source`
--

CREATE TABLE `breach_source` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `round_k` int UNSIGNED NOT NULL,
  `time` date NOT NULL,
  `major` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` int UNSIGNED DEFAULT NULL,
  `anchor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `search_log`
--

CREATE TABLE `search_log` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hash` binary(20) DEFAULT NULL,
  `isbreach` tinyint(1) NOT NULL DEFAULT '0',
  `ip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_category`
--

CREATE TABLE `source_category` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_item`
--

CREATE TABLE `source_item` (
  `id` int NOT NULL,
  `source` int NOT NULL,
  `item` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `source_tag`
--

CREATE TABLE `source_tag` (
  `id` int NOT NULL,
  `source` int NOT NULL,
  `tag` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE `stat` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `unique_hash` int NOT NULL,
  `relations` bigint UNSIGNED DEFAULT '0',
  `hit` int NOT NULL,
  `no_hit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int NOT NULL,
  `name` varchar(12) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `class` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `breach_hash`
--
ALTER TABLE `breach_hash`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_hash` (`hash`);

--
-- Indexes for table `breach_hash_temp`
--
ALTER TABLE `breach_hash_temp`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_hash` (`hash`);

--
-- Indexes for table `breach_item`
--
ALTER TABLE `breach_item`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `breach_relation`
--
ALTER TABLE `breach_relation`
  ADD PRIMARY KEY (`hash_id`,`source_id`),
  ADD KEY `idx_source` (`source_id`);

--
-- Indexes for table `breach_source`
--
ALTER TABLE `breach_source`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_category` (`category_id`);

--
-- Indexes for table `search_log`
--
ALTER TABLE `search_log`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `idx_hash` (`hash`);

--
-- Indexes for table `source_category`
--
ALTER TABLE `source_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_name` (`name`);

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
-- AUTO_INCREMENT for table `breach_hash`
--
ALTER TABLE `breach_hash`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `breach_hash_temp`
--
ALTER TABLE `breach_hash_temp`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `breach_item`
--
ALTER TABLE `breach_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `breach_source`
--
ALTER TABLE `breach_source`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `search_log`
--
ALTER TABLE `search_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_category`
--
ALTER TABLE `source_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_item`
--
ALTER TABLE `source_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `source_tag`
--
ALTER TABLE `source_tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stat`
--
ALTER TABLE `stat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
