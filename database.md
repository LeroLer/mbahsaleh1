-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 05, 2025 at 09:40 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbahsaleh1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_03_19_create_products_table', 1),
(5, '2024_03_19_create_sales_table', 1),
(6, '2024_03_19_remove_stock_from_products_table', 1),
(7, '2025_06_18_172054_change_quantity_to_decimal_in_sales_table', 2),
(8, '2024_06_18_200000_add_customer_name_to_sales_table', 3),
(9, '2025_06_29_145655_add_role_to_users_table', 4),
(10, '2025_06_29_151301_add_permissions_to_users_table', 5),
(11, '2025_07_01_000000_add_photo_to_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `created_at`, `updated_at`) VALUES
(1, 'nila', 'ikan nila tambak', 35000.00, 'products/pDfy7Ls7LmWNbkYamz0AsXJ9k3JQ2TefTy1m73oj.jpg', '2025-06-18 10:19:00', '2025-06-18 10:19:00'),
(3, 'lele', 'lele tambak', 25000.00, 'products/fPsXCp5nSjjVg8rmz3Ntv1Bxv7MZpvUZ1mmST2LT.jpg', '2025-06-23 03:46:12', '2025-06-23 03:46:24'),
(6, 'toMan', 'toMan brutal fatality', 120000.00, 'products/9K0b8AHtQRw4eWZdh43LRIWXdAfZgHbtokrImmUO.jpg', '2025-07-05 21:00:30', '2025-07-05 21:00:30'),
(7, 'koi hias', 'kada masuk akal jing', 9000000.00, 'products/qzrAJpcnTqdNY9Mm3kkUZNNSQsgxjILgFYn1ej7Z.jpg', '2025-07-05 21:01:05', '2025-07-05 21:01:05'),
(8, 'kakap merah', 'woilah', 80000.00, 'products/vf3ZDgSnf35x2m8KNilCrshz9VXFFb5LkmJyaf5b.jpg', '2025-07-05 21:01:52', '2025-07-05 21:01:52');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `sale_date` datetime NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `product_id`, `quantity`, `total_price`, `sale_date`, `customer_name`, `created_at`, `updated_at`) VALUES
(18, 3, 2.00, 50000.00, '2025-06-29 14:49:00', 'finzaldi', '2025-06-29 07:50:12', '2025-06-29 07:50:12'),
(19, 1, 3.00, 105000.00, '2025-06-29 14:49:00', 'finzaldi', '2025-06-29 07:50:12', '2025-06-29 07:50:12'),
(20, 1, 8.00, 280000.00, '2025-06-29 15:56:00', 'isan', '2025-06-29 08:56:44', '2025-07-05 20:58:58'),
(21, 3, 3.00, 75000.00, '2025-06-29 15:56:00', 'isan', '2025-06-29 08:56:44', '2025-06-29 08:56:44'),
(24, 3, 4.00, 100000.00, '2025-07-03 09:30:00', 'ilham', '2025-07-03 02:30:56', '2025-07-03 02:30:56'),
(25, 1, 5.00, 175000.00, '2025-07-03 09:30:00', 'ilham', '2025-07-03 02:30:56', '2025-07-03 02:30:56'),
(26, 7, 2.00, 18000000.00, '2025-06-29 15:56:00', 'isan', '2025-07-05 21:02:33', '2025-07-05 21:02:33'),
(27, 8, 3.00, 240000.00, '2025-06-29 15:56:00', 'isan', '2025-07-05 21:02:33', '2025-07-05 21:02:33'),
(28, 6, 4.00, 480000.00, '2025-06-29 15:56:00', 'isan', '2025-07-05 21:02:33', '2025-07-05 21:02:33'),
(29, 7, 1.00, 9000000.00, '2025-07-06 04:31:00', 'ical', '2025-07-05 21:31:30', '2025-07-05 21:31:30'),
(30, 6, 4.00, 480000.00, '2025-07-06 04:31:00', 'saidinaali poliban', '2025-07-05 21:31:58', '2025-07-05 21:31:58'),
(31, 1, 17.00, 595000.00, '2025-07-06 04:32:00', 'fiqriebillar', '2025-07-05 21:33:16', '2025-07-05 21:33:16'),
(32, 1, 9.00, 315000.00, '2025-07-06 04:33:00', 'hajeer elKirisaki', '2025-07-05 21:34:11', '2025-07-05 21:34:11'),
(33, 8, 4.00, 320000.00, '2025-07-06 04:33:00', 'hajeer elKirisaki', '2025-07-05 21:34:11', '2025-07-05 21:34:11'),
(34, 1, 10.00, 350000.00, '2025-07-06 04:34:00', 'king riezal', '2025-07-05 21:35:09', '2025-07-05 21:35:09'),
(35, 3, 10.00, 250000.00, '2025-07-06 04:34:00', 'king riezal', '2025-07-05 21:35:09', '2025-07-05 21:35:09'),
(36, 6, 7.00, 840000.00, '2025-07-06 04:34:00', 'king riezal', '2025-07-05 21:35:09', '2025-07-05 21:35:09'),
(37, 8, 9.00, 720000.00, '2025-07-06 04:34:00', 'king riezal', '2025-07-05 21:35:09', '2025-07-05 21:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('b92lR3wpcpa41zPdpvM3BMagFJwdKbrXFIvArUVM', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR1hCU3A0am1nZzV5Nm1tYnZuVFc1Tmg4UjZ4dFBEc1FReGQwcWtPZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zYWxlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1751751309);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','kasir') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `permissions` json DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `permissions`, `email_verified_at`, `password`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@pemancingan.com', 'admin', '[]', NULL, '$2y$12$McTAD7Mu1O5mFQAPMggsKeIvwUh90Q/GDGjdijX8WuZvhPyggdTUC', 'users/s0Y4VUXlMjh57kJ8uqzIvwfcXgUaysKw1DDMojL5.jpg', NULL, '2025-06-29 08:04:41', '2025-07-01 05:52:21'),
(2, 'Kasir', 'kasir@pemancingan.com', 'kasir', '[\"view_dashboard\", \"view_sales\", \"create_sales\", \"print_struk\", \"view_products\"]', NULL, '$2y$12$I6K9eJ2H3C6TnVSaqfg6te8b61mKKuVyHqAJfydvYdlmNd1xg4JOO', 'users/rxHLFDEO4SIkvk5RyazLb0bRpfZWO7TKbHxibbjW.jpg', NULL, '2025-06-29 08:04:42', '2025-07-01 05:54:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
