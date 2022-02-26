-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 26, 2022 at 02:58 PM
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
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Development', '2022-02-26 13:16:19', '2022-02-20 07:27:18'),
(2, 'Sales', '2022-02-26 13:16:19', '2022-02-19 07:26:52'),
(3, 'Finance', '2022-02-26 13:16:19', '2022-02-19 07:27:02');

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
  `department_id` int(11) UNSIGNED DEFAULT NULL,
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
(1, 'Stjepan', 'Stjepić', 'admin', NULL, 'stjepan@gmail.com', NULL, '$2y$10$XdAu34MYA8Vt.pUfFbHK.ulkR0rCuuW5YYgfTgyvcp1oQxreUKcrq', NULL, '2022-01-31 15:40:29', '2022-02-26 08:35:59'),
(2, 'Bernard', 'Jelinić', 'user', 2, 'jelinic@gmail.com', NULL, '$2y$10$w3opX36OCF./xc5pVsn7kOen/zB6119RZTShsYI15r8.ziEeUXDV6', NULL, '2022-01-26 02:35:08', '2022-02-26 11:40:55'),
(3, 'Matea', 'Mokricki', 'user', 3, 'mokricki@gmail.com', NULL, '$2y$10$k5xpXoz/sWldYzh1i067F.MqCtVEG4bFL5Z.H1NwlUS1IG4yUQacq', NULL, '2022-01-29 12:05:33', '2022-02-18 03:52:26'),
(4, 'Ivan', 'Jelinić', 'user', 1, 'ivan@gmail.com', NULL, '$2y$10$qYw8rdrZIzp6BUhfpW0q5eUjl2plrZshluRkswgJNrsloOVbCwPiy', NULL, '2022-01-30 09:46:35', '2022-02-26 07:33:41'),
(5, 'Josip', 'Josipović', 'manager', 1, 'josip@gmail.com', NULL, '$2y$10$eZT2UdJnLkCsq4d.YmrFPuNJxnrfqdC/LyC4xgg7BwFyiFNHvDBsW', NULL, '2022-01-31 03:17:49', '2022-02-26 11:20:03'),
(6, 'Pero', 'Perić', 'manager', 2, 'pero@gmail.com', NULL, '$2y$10$o3sSfMI0kSinX13ACZqH6eDvIqEO1eum2FA.6dCQ6.tImiUQTPtQi', NULL, '2022-01-31 15:42:55', '2022-02-26 12:51:18'),
(7, 'Ivo', 'Ivić', 'manager', 3, 'ivo@gmail.com', NULL, '$2y$10$wuBuASrBRQ0nm2EUPqOviOP5qkPWPqM34MF2Dv0Ri97jieYg890V2', NULL, '2022-01-31 15:44:17', '2022-01-31 15:44:17'),
(8, 'Josipa', 'Jelinić', 'user', 1, 'josipa@gmail.com', NULL, '$2y$10$rHhOp35sDy2hS5PExBHZ2eOCehqp1PXzQngZxbyO7qu6ld.h3YC/u', NULL, '2022-01-31 15:45:33', '2022-01-31 15:45:33'),
(9, 'Miroslav', 'Jelinić', 'user', 2, 'miroslav@gmail.com', NULL, '$2y$10$qHDMZbUzEgkoV9qkdc0eAuVlCDDJY6n9oCQ6TMyQLOrTw0W5rIHR.', NULL, '2022-01-31 15:48:59', '2022-01-31 15:48:59'),
(10, 'Olivera', 'Jelinić', 'user', 3, 'olivera@gmail.com', NULL, '$2y$10$NR5aodqbY0mhH0pPX82n1ecaQdUQOanNI.Q5fQosYWKngP/uoUvCu', NULL, '2022-01-31 15:49:49', '2022-01-31 15:49:49');

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
(19, '2022-01-31 23:00:00', '2022-02-03 23:00:00', '2022-01-29 03:34:18', '2022-02-26 12:09:19', 1, 1, 0, 1, 2),
(20, '2022-01-31 23:00:00', '2022-02-03 23:00:00', '2022-01-29 03:48:15', '2022-02-26 08:17:38', 0, 0, 0, 0, 10),
(21, '2022-02-28 23:00:00', '2022-03-03 23:00:00', '2022-01-29 03:48:32', '2022-02-26 08:17:38', 1, 1, 0, 0, 3),
(22, '2022-02-08 23:00:00', '2022-02-27 23:00:00', '2022-01-29 05:19:55', '2022-02-26 12:09:19', 1, 1, 0, 1, 2),
(23, '2022-01-31 23:00:00', '2022-02-01 23:00:00', '2022-01-29 05:20:29', '2022-02-26 12:09:19', 2, 1, 0, 1, 2),
(24, '2022-01-31 23:00:00', '2022-02-02 23:00:00', '2022-01-29 05:23:32', '2022-02-26 12:09:19', 1, 1, 0, 1, 2),
(25, '2022-01-31 23:00:00', '2022-02-18 23:00:00', '2022-01-30 06:43:55', '2022-02-26 11:20:56', 0, 0, 1, 0, 4),
(26, '2022-02-19 23:00:00', '2022-02-25 23:00:00', '2022-01-30 09:47:01', '2022-02-26 11:20:58', 1, 0, 1, 0, 8),
(29, '2022-02-05 23:00:00', '2022-02-11 23:00:00', '2022-01-31 03:19:18', '2022-02-26 08:17:38', 0, 1, 0, 1, 9),
(30, '2022-02-21 23:00:00', '2022-02-25 23:00:00', '2022-02-21 02:44:17', '2022-02-26 12:09:19', 1, 1, 0, 1, 2),
(31, '2022-02-24 23:00:00', '2022-02-27 23:00:00', '2022-02-21 03:41:05', '2022-02-26 12:09:19', 1, 1, 0, 1, 2),
(32, '2022-02-27 23:00:00', '2022-03-23 23:00:00', '2022-02-26 11:05:12', '2022-02-26 11:21:01', 2, 0, 1, 0, 8),
(33, '2022-02-28 23:00:00', '2022-03-16 23:00:00', '2022-02-26 11:44:22', '2022-02-26 12:09:19', 0, 0, 0, 1, 2),
(34, '2022-02-28 23:00:00', '2022-03-10 23:00:00', '2022-02-26 11:45:12', '2022-02-26 12:09:19', 0, 0, 0, 1, 2);

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
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `department_id` (`department_id`);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
