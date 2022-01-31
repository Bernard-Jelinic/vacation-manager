-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2022 at 06:18 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vacation-manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `manager_id` bigint(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `manager_id`, `updated_at`) VALUES
(1, 'Development', 14, '2022-01-30 08:26:35'),
(2, 'Sales', 4, '2022-01-30 08:24:44'),
(3, 'Finance', 19, '2022-01-31 03:18:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(5, '2014_10_12_000000_create_users_table', 1),
(6, '2014_10_12_100000_create_password_resets_table', 1),
(7, '2019_08_19_000000_create_failed_jobs_table', 1),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `last_name`, `role`, `department_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Jozo', 'Jozić', 'admin', NULL, 'jozo@gmail.com', NULL, '$2y$10$35.bci0mU7zxhTA3YpsMOOOQ7cQbdr7sPczBBsRzbrq2HhciIFZZK', NULL, '2022-01-31 15:40:29', '2022-01-31 15:40:29'),
(2, 'Bernard', 'Jelinić', 'user', 2, 'jelinic@gmail.com', NULL, '$2y$10$q06h2WGVbrvAy4azTwXxJ.Y4GuO26Dcyvm7SBIpJyi.38BT9tIup.', NULL, '2022-01-26 02:35:08', '2022-01-27 03:40:42'),
(3, 'Matea', 'Mokricki', 'user', 3, 'matea@gmail.com', NULL, '$2y$10$Shx8A00IQisbIDBSnW8Q.OpT9oqTId8zpiKCNywjrdKKJnK07nTgu', NULL, '2022-01-29 12:05:33', '2022-01-29 12:05:33'),
(4, 'Ivan', 'Jelinić', 'user', 1, 'ivan@gmail.com', NULL, '$2y$10$Ez3o/0ChyTfiHVswfsMUXeG12/uw1ukLDckg5pydtR6Xc055/sBEe', NULL, '2022-01-30 09:46:35', '2022-01-30 09:46:35'),
(5, 'Josip', 'Josipović', 'manager', NULL, 'josip@gmail.com', NULL, '$2y$10$xdI5HnJoA6SovmY3c0hZW.uQzmO2o3N9UGJFubbOrqBZeqMrulYfC', NULL, '2022-01-31 03:17:49', '2022-01-31 03:17:49'),
(6, 'Pero', 'Perić', 'manager', NULL, 'pero@gmail.com', NULL, '$2y$10$o3sSfMI0kSinX13ACZqH6eDvIqEO1eum2FA.6dCQ6.tImiUQTPtQi', NULL, '2022-01-31 15:42:55', '2022-01-31 15:42:55'),
(7, 'Ivo', 'Ivić', 'manager', NULL, 'ivo@gmail.com', NULL, '$2y$10$wuBuASrBRQ0nm2EUPqOviOP5qkPWPqM34MF2Dv0Ri97jieYg890V2', NULL, '2022-01-31 15:44:17', '2022-01-31 15:44:17'),
(8, 'Josipa', 'Jelinić', 'user', 1, 'josipa@gmail.com', NULL, '$2y$10$rHhOp35sDy2hS5PExBHZ2eOCehqp1PXzQngZxbyO7qu6ld.h3YC/u', NULL, '2022-01-31 15:45:33', '2022-01-31 15:45:33'),
(9, 'Miroslav', 'Jelinić', 'user', 2, 'miroslav@gmail.com', NULL, '$2y$10$qHDMZbUzEgkoV9qkdc0eAuVlCDDJY6n9oCQ6TMyQLOrTw0W5rIHR.', NULL, '2022-01-31 15:48:59', '2022-01-31 15:48:59'),
(10, 'Olivera', 'Jelinić', 'user', 3, 'olivera@gmail.com', NULL, '$2y$10$NR5aodqbY0mhH0pPX82n1ecaQdUQOanNI.Q5fQosYWKngP/uoUvCu', NULL, '2022-01-31 15:49:49', '2022-01-31 15:49:49'),
(11, 'test', 'test', 'manager', NULL, 'test@gmail.com', NULL, 'test', NULL, '2022-01-31 16:13:38', '2022-01-31 16:13:38');

-- --------------------------------------------------------

--
-- Table structure for table `vacations`
--

CREATE TABLE `vacations` (
  `id` int(11) NOT NULL,
  `depart` timestamp NULL DEFAULT NULL,
  `return` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) DEFAULT NULL,
  `admin_read` int(1) DEFAULT NULL,
  `manager_read` int(1) DEFAULT NULL,
  `user_notified` int(1) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vacations`
--

INSERT INTO `vacations` (`id`, `depart`, `return`, `created_at`, `updated_at`, `status`, `admin_read`, `manager_read`, `user_notified`, `user_id`) VALUES
(19, '2022-01-31 23:00:00', '2022-02-03 23:00:00', '2022-01-29 03:34:18', '2022-01-31 01:41:46', 1, 1, 1, 1, 2),
(20, '2022-01-31 23:00:00', '2022-02-03 23:00:00', '2022-01-29 03:48:15', '2022-01-29 03:48:15', 0, 1, 0, 0, 10),
(21, '2022-02-28 23:00:00', '2022-03-03 23:00:00', '2022-01-29 03:48:32', '2022-01-31 03:29:13', 1, 1, 1, 0, 3),
(22, '2022-02-08 23:00:00', '2022-02-27 23:00:00', '2022-01-29 05:19:55', '2022-01-29 05:19:55', 1, 1, 1, 0, 2),
(23, '2022-01-31 23:00:00', '2022-02-01 23:00:00', '2022-01-29 05:20:29', '2022-01-29 11:29:22', 0, 1, 0, 0, 2),
(24, '2022-01-31 23:00:00', '2022-02-02 23:00:00', '2022-01-29 05:23:32', '2022-01-29 05:23:32', 0, 1, 0, 1, 2),
(25, '2022-01-31 23:00:00', '2022-02-18 23:00:00', '2022-01-30 06:43:55', '2022-01-30 06:55:41', 0, 1, 1, 0, 4),
(26, '2022-02-19 23:00:00', '2022-02-25 23:00:00', '2022-01-30 09:47:01', '2022-01-30 09:48:03', 1, 1, 1, 1, 8),
(29, '2022-02-05 23:00:00', '2022-02-11 23:00:00', '2022-01-31 03:19:18', '2022-01-31 03:30:22', 2, 1, 1, 1, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
